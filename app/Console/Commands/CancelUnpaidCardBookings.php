<?php

namespace App\Console\Commands;

use App\Services\CardPaymentService;
use Illuminate\Console\Command;

class CancelUnpaidCardBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cancel-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel online card bookings whose payment was never completed and notify the customer and admin';

    /**
     * Execute the console command.
     */
    public function handle(CardPaymentService $payments)
    {
        $results = $payments->cancelAbandoned();

        $this->info("Unpaid card bookings: {$results['cancelled']} cancelled, {$results['paid']} found paid, {$results['skipped']} left for the next run.");
    }
}
