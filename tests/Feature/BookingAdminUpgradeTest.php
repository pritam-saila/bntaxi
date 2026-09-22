<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookingStop;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * End-to-end checks for the admin booking-management upgrade.
 * Runs against the real DB inside a transaction (rolled back after each test).
 */
class BookingAdminUpgradeTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('type', 1)->firstOrFail();
    }

    /** @test */
    public function schema_and_settings_are_in_place(): void
    {
        foreach ([
            'duration_minutes', 'internal_notes', 'driver_notes', 'amount_paid',
            'outstanding_amount', 'payment_actual_method', 'payment_date',
            'payment_confirmed_by', 'payment_notes', 'min_distance_override',
            'min_distance_override_reason', 'min_distance_override_by', 'min_distance_override_at',
        ] as $col) {
            $this->assertTrue(Schema::hasColumn('books', $col), "books.$col missing");
        }
        $this->assertTrue(Schema::hasTable('booking_stops'));
        $this->assertSame('8', Setting::get('minimum_journey_miles'));
        $this->assertSame('1', Setting::get('minimum_journey_enforced'));
        $this->assertNotEmpty(Setting::get('minimum_journey_message'));
    }

    /** @test */
    public function existing_data_was_backfilled_consistently(): void
    {
        $methods = array_keys(Book::PAYMENT_METHODS);
        $statuses = array_keys(Book::PAYMENT_STATUSES);

        foreach (Book::all() as $b) {
            $this->assertContains($b->payment_method, $methods, "booking {$b->id} bad payment_method");
            $this->assertContains($b->payment_status, $statuses, "booking {$b->id} bad payment_status");
            if ($b->payment_status !== 'refunded') {
                $this->assertEqualsWithDelta(
                    (float) $b->price,
                    (float) $b->amount_paid + (float) $b->outstanding_amount,
                    0.01,
                    "booking {$b->id}: paid + outstanding != price"
                );
            }
        }
    }

    /** @test */
    public function admin_edit_page_renders_every_section(): void
    {
        $book = Book::query()->first();

        $res = $this->actingAs($this->admin)->get("/admbook/{$book->id}/edit");

        $res->assertOk();
        $res->assertSee($book->name, false);
        $res->assertSee('Customer Details');
        $res->assertSee('Journey Details');
        $res->assertSee('Vehicle Details');
        $res->assertSee('Payment Details');
        $res->assertSee('Booking Management');
        $res->assertSee('Booking Audit Log');
        $res->assertSee('Recalculate route');
        $res->assertSee('name="min_distance_override"', false);
        $res->assertSee('maps/api/js', false);
    }

    /** @test */
    public function full_edit_saves_all_fields_stops_and_writes_an_audit_entry(): void
    {
        $book = Book::query()->firstOrFail();
        $driverId = User::where('type', 2)->value('id');
        $originalPrice = (float) $book->price;

        $res = $this->actingAs($this->admin)->patch("/admbook/{$book->id}", [
            'name' => 'Audit Test Customer',
            'email' => 'audit@test.com',
            'phone' => '07999 111222',
            'pickup' => $book->pickup ?: 'Edinburgh EH11, UK',
            'dropoff' => $book->dropoff ?: 'Glasgow, UK',
            'pickup_date' => '2026-12-01',
            'pickup_time' => '07:15',
            'is_return' => 0,
            'distance' => 123.45,
            'duration_minutes' => 150,
            'stops' => [
                ['id' => '', 'address' => 'Livingston EH54, UK', 'notes' => 'pickup a colleague'],
            ],
            'car_id' => \App\Models\Cars::value('id'),
            'passengers' => 4,
            'bags' => 2,
            'status' => 'DRIVER ASSIGNED',
            'driver_id' => $driverId,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending_payment',
            'price' => 199.00,
            'amount_paid' => 0,
            'original_price' => $originalPrice,
            'price_change_confirmed' => 1,
            'special_instructions' => 'customer note',
            'internal_notes' => 'internal note',
            'driver_notes' => 'driver note',
        ]);

        $res->assertRedirect("/admbook/{$book->id}/edit");
        $res->assertSessionHas('success');

        $book->refresh()->load('stops');
        $this->assertSame('Audit Test Customer', $book->name);
        $this->assertSame('bank_transfer', $book->payment_method);
        $this->assertSame('pending_payment', $book->payment_status);
        $this->assertSame('DRIVER ASSIGNED', $book->status);
        $this->assertSame('internal note', $book->internal_notes);
        $this->assertSame('driver note', $book->driver_notes);
        $this->assertEqualsWithDelta(199.00, (float) $book->price, 0.01);
        $this->assertEqualsWithDelta(199.00, (float) $book->outstanding_amount, 0.01);

        $this->assertCount(1, $book->stops);
        $this->assertSame('Livingston EH54, UK', $book->stops[0]->address);
        $this->assertSame(1, $book->stops[0]->sequence);
        $this->assertSame('pickup a colleague', $book->stops[0]->notes);

        $this->assertSame(
            [$book->pickup, 'Livingston EH54, UK', $book->dropoff],
            $book->vias,
            'vias JSON not kept in step with stops'
        );

        $last = collect($book->timeline)->last();
        $this->assertSame('Booking details updated', $last['event']);
        $this->assertSame($this->admin->name, $last['actor']);
        $this->assertStringContainsString('Price:', $last['details']);
        $this->assertStringContainsString('Stops:', $last['details']);
        $this->assertStringContainsString('Payment method:', $last['details']);
        $this->assertStringContainsString('Booking status:', $last['details']);
    }

    /** @test */
    public function stops_can_be_updated_reordered_and_removed(): void
    {
        $book = Book::query()->firstOrFail();
        $book->stops()->delete();
        $a = $book->stops()->create(['address' => 'Carlisle, UK', 'sequence' => 1, 'notes' => 'first']);
        $b = $book->stops()->create(['address' => 'Penrith, UK', 'sequence' => 2, 'notes' => 'second']);

        // submit them reversed, edit one address, drop nothing
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'distance' => 50,
            'stops' => [
                ['id' => $b->id, 'address' => 'Penrith, UK', 'notes' => 'now first'],
                ['id' => $a->id, 'address' => 'Kendal, UK', 'notes' => 'renamed + moved'],
            ],
        ]))->assertSessionHas('success');

        $stops = $book->fresh()->stops;
        $this->assertCount(2, $stops);
        $this->assertSame('Penrith, UK', $stops[0]->address);
        $this->assertSame(1, $stops[0]->sequence);
        $this->assertSame('Kendal, UK', $stops[1]->address);
        $this->assertSame(2, $stops[1]->sequence);
        $this->assertSame('now first', $stops[0]->notes);

        // now remove all stops
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'distance' => 50,
            'stops' => [],
        ]))->assertSessionHas('success');

        $this->assertCount(0, $book->fresh()->stops);
        $this->assertSame([$book->pickup, $book->dropoff], $book->fresh()->vias);
    }

    /** @test */
    public function price_change_without_confirmation_is_rejected(): void
    {
        $book = Book::query()->firstOrFail();
        $originalPrice = (float) $book->price;

        $res = $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'price' => $originalPrice + 50,
            'original_price' => $originalPrice,
            'price_change_confirmed' => 0,
        ]));

        $res->assertSessionHas('error');
        $this->assertEqualsWithDelta($originalPrice, (float) $book->fresh()->price, 0.01);
    }

    /** @test */
    public function eight_mile_minimum_blocks_admin_save_without_override_and_allows_it_with_reason(): void
    {
        $book = Book::query()->firstOrFail();

        // no override -> blocked
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'pickup' => 'Brighton, UK',
            'dropoff' => 'Hove, UK',
            'stops' => [],
            'distance' => 2.8,
            'min_distance_override' => 0,
        ]))->assertSessionHas('error');

        $this->assertNotSame('Brighton, UK', $book->fresh()->pickup);

        // override + reason -> saved and logged
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'pickup' => 'Brighton, UK',
            'dropoff' => 'Hove, UK',
            'stops' => [],
            'distance' => 2.8,
            'min_distance_override' => 1,
            'min_distance_override_reason' => 'Long-standing corporate client',
        ]))->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('Brighton, UK', $book->pickup);
        $this->assertTrue((bool) $book->min_distance_override);
        $this->assertSame('Long-standing corporate client', $book->min_distance_override_reason);
        $this->assertSame($this->admin->name, $book->min_distance_override_by);
        $this->assertTrue(
            collect($book->timeline)->contains(fn ($e) => $e['event'] === 'Minimum Distance Overridden')
        );
    }

    /** @test */
    public function editing_an_already_short_booking_shows_the_override_box_and_needs_a_reason(): void
    {
        $book = Book::query()->firstOrFail();
        $book->update(['distance' => 3.2, 'min_distance_override' => false, 'min_distance_override_reason' => null]);

        // the edit page must surface the override controls (not hidden) up front
        $res = $this->actingAs($this->admin)->get("/admbook/{$book->id}/edit");
        $res->assertOk();
        $this->assertMatchesRegularExpression(
            '/id="overrideBox"[^>]*style="display:block;"/',
            $res->getContent(),
            'override box should be visible on load for a sub-minimum booking'
        );

        // saving an unrelated change without ticking override is blocked
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'phone' => '07000 999888',
            'distance' => 3.2,
            'min_distance_override' => 0,
        ]))->assertSessionHas('error');

        // ticking override with a reason lets it through and logs it
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'phone' => '07000 999888',
            'distance' => 3.2,
            'min_distance_override' => 1,
            'min_distance_override_reason' => 'Account customer',
        ]))->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('07000 999888', $book->phone);
        $this->assertTrue((bool) $book->min_distance_override);
    }

    /** @test */
    public function recalculate_returns_figures_without_touching_the_booking(): void
    {
        $book = Book::query()->firstOrFail();
        $snapshot = $book->only(['pickup', 'dropoff', 'price', 'distance']);

        $res = $this->actingAs($this->admin)->postJson("/admin/book/{$book->id}/recalculate", [
            'pickup' => 'Edinburgh EH11, UK',
            'dropoff' => 'Horley, Gatwick RH6 0NY, UK',
            'car_id' => \App\Models\Cars::where('call_for_quote', 0)->value('id'),
            'is_return' => 0,
            'stops' => [['address' => 'Carlisle, UK']],
        ]);

        $res->assertOk();
        $json = $res->json();
        $this->assertTrue($json['ok']);
        $this->assertGreaterThan(300, $json['distance']);
        $this->assertCount(2, $json['legs']);
        $this->assertArrayHasKey('previous', $json);
        $this->assertArrayHasKey('minimum', $json);

        $this->assertSame($snapshot, $book->fresh()->only(['pickup', 'dropoff', 'price', 'distance']));
    }

    /** @test */
    public function manual_payment_panel_records_partial_then_full_payment(): void
    {
        $book = Book::where('price', '>', 0)->firstOrFail();
        $price = (float) $book->price;

        $this->actingAs($this->admin)->post("/admin/book/{$book->id}/payment", [
            'payment_status' => 'partially_paid',
            'amount_paid' => 25,
            'payment_actual_method' => 'pay_in_car_cash',
            'payment_notes' => 'deposit taken',
        ])->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('partially_paid', $book->payment_status);
        $this->assertEqualsWithDelta($price - 25, (float) $book->outstanding_amount, 0.01);

        $this->actingAs($this->admin)->post("/admin/book/{$book->id}/payment", [
            'payment_status' => 'paid',
            'amount_paid' => $price,
        ])->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('paid', $book->payment_status);
        $this->assertEqualsWithDelta(0.0, (float) $book->outstanding_amount, 0.01);
        $this->assertSame($this->admin->name, $book->payment_confirmed_by);
        $this->assertNotNull($book->payment_date);

        // never fabricates a Stripe transaction
        $this->assertFalse(
            collect($book->timeline)->contains(fn ($e) => str_contains(($e['details'] ?? ''), 'Stripe Refund ID'))
        );
    }

    /** @test */
    public function reject_does_not_call_stripe_for_a_non_stripe_reference(): void
    {
        $book = Book::query()->firstOrFail();
        $book->update([
            'payment_method' => 'stripe',
            'payment_status' => 'paid',
            'refund_transaction_reference' => 'not_a_real_payment_intent',
        ]);

        // Would throw a Stripe API/auth error if the code actually called Stripe.
        $this->actingAs($this->admin)->post("/admin/book/{$book->id}/reject", [
            'rejection_reason' => 'no availability',
        ])->assertRedirect();

        $book->refresh();
        $this->assertSame('REJECTED', $book->status);
        $this->assertSame('Manual Refund Required', $book->refund_status);
    }

    /** @test */
    public function customer_cannot_submit_a_sub_eight_mile_booking(): void
    {
        // postorderreview() recomputes the distance from the routing API.
        if (app(\App\Services\RouteService::class)->distanceMiles(['Brighton, UK', 'Hove, UK']) <= 0) {
            $this->markTestSkipped('Routing API unavailable.');
        }

        $before = Book::count();

        $res = $this->post('/order-review', [
            'name' => 'Blocked Customer',
            'email' => 'blocked@test.com',
            'phone' => '07000000000',
            'car_id' => \App\Models\Cars::value('id'),
            'pickup' => 'Brighton, UK',
            'dropoff' => 'Hove, UK',
            'passengers' => 1,
            'bags' => 0,
            'distancearr' => ['Brighton, UK', 'Hove, UK'],
            'distance' => 2.8,
            'price' => 20,
            'payment_method' => 'stripe',
            'is_return' => 0,
        ]);

        $res->assertRedirect();
        $res->assertSessionHas('error');
        $this->assertSame($before, Book::count(), 'a sub-8-mile booking was created');
    }

    /** @test */
    public function a_valid_long_journey_cash_booking_is_still_created_with_the_new_vocabulary(): void
    {
        $route = ['Brighton, UK', 'Gatwick Airport, UK'];
        if (app(\App\Services\RouteService::class)->distanceMiles($route) <= 8) {
            $this->markTestSkipped('Routing API unavailable.');
        }

        $before = Book::count();
        $res = $this->post('/order-review', [
            'name' => 'Valid Customer', 'email' => 'valid@test.com', 'phone' => '07111222333',
            'car_id' => \App\Models\Cars::where('call_for_quote', 0)->value('id'),
            'pickup' => $route[0], 'dropoff' => $route[1],
            'passengers' => 2, 'bags' => 1,
            'distancearr' => $route, 'distance' => 27, 'price' => 90,
            'payment_method' => 'cash', 'is_return' => 0,
        ]);

        $this->assertSame($before + 1, Book::count());
        $b = Book::latest('id')->first();
        $this->assertSame('pay_in_car_cash', $b->payment_method);
        $this->assertSame('unpaid', $b->payment_status);
        $this->assertSame('PENDING APPROVAL', $b->status);
        $this->assertEqualsWithDelta((float) $b->price, (float) $b->outstanding_amount, 0.01);
        $this->assertEqualsWithDelta(0.0, (float) $b->amount_paid, 0.01);
    }

    /** @test */
    public function customer_quote_page_blocks_short_journeys_and_allows_long_ones(): void
    {
        // Uses the live routing API; guard against transient API failures
        // (distance 0) so the test asserts behaviour, not Google's uptime.
        $short = app(\App\Services\RouteService::class)->distanceMiles(['Brighton, UK', 'Hove, UK']);
        if ($short <= 0) {
            $this->markTestSkipped('Routing API unavailable for the short-journey check.');
        }
        $this->assertLessThan(8, $short, 'expected Brighton->Hove to be under 8 miles');

        $this->get('/pricing?' . http_build_query(['pickup' => 'Brighton, UK', 'dropoff' => 'Hove, UK']))
            ->assertOk()
            ->assertSee("take this booking", false)
            ->assertSee('we do not accept bookings for journeys under', false)
            ->assertDontSee('>Continue<', false);

        $long = app(\App\Services\RouteService::class)->distanceMiles(['Brighton, UK', 'Gatwick Airport, UK']);
        if ($long <= 8) {
            $this->markTestSkipped('Routing API unavailable for the long-journey check.');
        }

        $this->get('/pricing?' . http_build_query(['pickup' => 'Brighton, UK', 'dropoff' => 'Gatwick Airport, UK']))
            ->assertOk()
            ->assertSee('>Continue<', false);
    }

    /** @test */
    public function booking_list_and_payment_filters_all_load(): void
    {
        foreach (['', 'paid', 'unpaid', 'partially_paid', 'online', 'cash', 'pending', 'confirmed', 'urgent', 'airport'] as $filter) {
            $this->actingAs($this->admin)
                ->get('/admbook' . ($filter ? "?filter={$filter}" : ''))
                ->assertOk();
        }

        $this->actingAs($this->admin)->get('/admbook')
            ->assertSee('Payment &amp; Amounts', false)
            ->assertSee('Owes', false);
    }

    /** @test */
    public function booking_view_shows_split_payment_and_manage_panel(): void
    {
        $book = Book::query()->firstOrFail();

        $this->actingAs($this->admin)->get("/admbook/{$book->id}")
            ->assertOk()
            ->assertSee('Manage Payment')
            ->assertSee('Outstanding Balance')
            ->assertSee('Total Booking Amount');
    }

    /** @test */
    public function booking_source_is_shown_and_editable(): void
    {
        $book = Book::query()->firstOrFail();
        $this->assertContains($book->source, array_keys(Book::SOURCES));

        // shown on the view + edit pages
        $this->actingAs($this->admin)->get("/admbook/{$book->id}")
            ->assertOk()->assertSee('Booking Source');
        $this->actingAs($this->admin)->get("/admbook/{$book->id}/edit")
            ->assertOk()->assertSee('name="source"', false);

        // editable, validated, and logged
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'source' => 'phone',
            'distance' => 50,
        ]))->assertSessionHas('success');

        $book->refresh();
        $this->assertSame('phone', $book->source);
        $this->assertSame('Phone Booking', $book->source_label);
        $this->assertTrue(
            collect($book->timeline)->contains(fn ($e) => str_contains(($e['details'] ?? ''), 'Booking source'))
        );

        // rejects an unknown value
        $this->actingAs($this->admin)->patch("/admbook/{$book->id}", $this->basePayload($book, [
            'source' => 'carrier-pigeon',
            'distance' => 50,
        ]))->assertSessionHasErrors('source');
    }

    /** @test */
    public function customer_bookings_are_recorded_with_web_source(): void
    {
        $route = ['Brighton, UK', 'Gatwick Airport, UK'];
        if (app(\App\Services\RouteService::class)->distanceMiles($route) <= 8) {
            $this->markTestSkipped('Routing API unavailable.');
        }

        $before = Book::count();
        $this->post('/order-review', [
            'name' => 'Source Test', 'email' => 'src@test.com', 'phone' => '07000000123',
            'car_id' => \App\Models\Cars::where('call_for_quote', 0)->value('id'),
            'pickup' => $route[0], 'dropoff' => $route[1],
            'passengers' => 1, 'bags' => 0,
            'distancearr' => $route, 'distance' => 27, 'price' => 90,
            'payment_method' => 'cash', 'is_return' => 0,
        ]);

        $this->assertSame($before + 1, Book::count(), 'booking was not created');
        $this->assertSame('web', Book::latest('id')->first()->source);
    }

    /** @test */
    public function an_unpaid_stripe_booking_is_not_labelled_as_paid_online(): void
    {
        $book = Book::query()->firstOrFail();

        $book->update(['payment_method' => 'stripe', 'payment_status' => 'unpaid']);
        $this->assertSame('Pay in Car', $book->fresh()->payment_method_display);

        $book->update(['payment_status' => 'pending_payment']);
        $this->assertSame('Pay in Car', $book->fresh()->payment_method_display);

        $book->update(['payment_status' => 'payment_failed']);
        $this->assertSame('Pay in Car', $book->fresh()->payment_method_display);

        // only once money actually moved through Stripe does it read as Stripe
        $book->update(['payment_status' => 'paid']);
        $this->assertSame('Stripe – Online Payment', $book->fresh()->payment_method_display);

        $book->update(['payment_status' => 'partially_paid']);
        $this->assertSame('Stripe – Online Payment', $book->fresh()->payment_method_display);

        // the raw stored value is still available for the admin edit form / audit log
        $this->assertSame('Stripe – Online Payment', $book->fresh()->payment_method_label);
    }

    private function basePayload(Book $book, array $overrides = []): array
    {
        return array_merge([
            'name' => $book->name ?: 'X',
            'email' => $book->email ?: 'x@x.com',
            'phone' => $book->phone ?: '0700',
            'pickup' => $book->pickup ?: 'Edinburgh EH11, UK',
            'dropoff' => $book->dropoff ?: 'Glasgow, UK',
            'pickup_date' => '2026-12-01',
            'pickup_time' => '09:00',
            'is_return' => 0,
            'distance' => (float) ($book->distance ?: 50),
            'stops' => [],
            'car_id' => \App\Models\Cars::value('id'),
            'passengers' => 1,
            'bags' => 0,
            'status' => 'CONFIRMED',
            'payment_method' => $book->payment_method ?: 'pay_in_car_cash',
            'payment_status' => $book->payment_status ?: 'unpaid',
            'price' => (float) $book->price,
            'original_price' => (float) $book->price,
        ], $overrides);
    }
}
