<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;

class AutoRejectPendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:auto-reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically reject pending bookings that are within the configurable approval deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-rejection checks for pending bookings...');

        // Fetch configurable threshold hours (default to 1 hour if not set)
        $thresholdHours = floatval(Setting::get('auto_rejection_time_hours', 1));
        
        // Threshold date/time
        $deadline = Carbon::now()->addHours($thresholdHours);
        
        $this->info("Deadline threshold is set to: {$thresholdHours} hour(s) from now. Deadline time: " . $deadline->toDateTimeString());

        // Get all pending bookings
        $pendingBookings = Book::where('status', 'PENDING APPROVAL')->get();

        $rejectedCount = 0;

        foreach ($pendingBookings as $booking) {
            if (!$booking->pickup_date || !$booking->pickup_time) {
                continue;
            }

            try {
                $pickupDateTime = Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
                
                // If pickup time is past or within the threshold (e.g. less than or equal to $deadline)
                if ($pickupDateTime->lte($deadline)) {
                    $this->warn("Booking {$booking->booking_id} (Pickup: {$pickupDateTime->toDateTimeString()}) has breached the deadline.");

                    // 1. Reject booking
                    $booking->status = 'REJECTED';
                    $booking->rejection_reason = 'Not approved within required timeframe';
                    
                    // 2. Process refund if the customer had already paid
                    if ($booking->isPaid()) {
                        if ($booking->canAutoRefund()) {
                            try {
                                $stripeSecretKey = env('STRIPE_SECRET');
                                $stripe = new \Stripe\StripeClient($stripeSecretKey);

                                $refund = $stripe->refunds->create([
                                    'payment_intent' => $booking->refund_transaction_reference
                                ]);

                                $booking->refund_status = 'Refunded';
                                $booking->refund_amount = $booking->price;
                                $booking->refund_transaction_reference = $refund->id;
                                $booking->payment_status = 'refunded';
                                $booking->logTimeline('Stripe Auto-Refund', 'Auto-refunded £' . number_format($booking->price, 2) . ' due to auto-rejection. Stripe Refund ID: ' . $refund->id, 'System');
                            } catch (\Exception $e) {
                                $booking->refund_status = 'Refund Failed';
                                $booking->logTimeline('Stripe Auto-Refund Failed', 'Auto-refund processing failed: ' . $e->getMessage(), 'System');
                            }
                        } else {
                            $booking->refund_status = 'Manual Refund Required';
                            $booking->logTimeline('Manual Refund Flagged', 'Payment taken as "' . $booking->payment_method_label . '" — manual refund required.', 'System');
                        }
                    }

                    // 3. Save
                    $booking->save();
                    
                    // 4. Log to timeline
                    $booking->logTimeline('Auto Rejection', 'Booking request auto-rejected because it was not approved within the required threshold of ' . $thresholdHours . ' hour(s).', 'System');

                    // 5. Notify customer and admin
                    try {
                        // Customer Email
                        Mail::to($booking->email)->send(new BookingMail($booking));
                        
                        // Admin Notification Email
                        $adminEmail = \App\Models\User::where('type', 1)->value('email') ?? env('MAIL_FROM_ADDRESS', 'admin@bntaxi.co.uk');
                        Mail::to($adminEmail)->send(new BookingMail($booking));
                        
                        $booking->logTimeline('Auto Rejection Emails Sent', 'Notification emails sent to customer and admin.', 'System');
                    } catch (\Exception $e) {
                        $this->error("Failed to send emails for booking {$booking->booking_id}: " . $e->getMessage());
                    }

                    $rejectedCount++;
                }
            } catch (\Exception $e) {
                $this->error("Error processing booking {$booking->id}: " . $e->getMessage());
            }
        }

        $this->info("Completed checks. {$rejectedCount} booking(s) auto-rejected.");
    }
}
