<?php

namespace Tests\Feature;

use App\Models\DriverDocument;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * A driver reads the issue/expiry date off their own document and enters it
 * themselves - either alongside the upload, or afterwards without needing to
 * re-upload the file.
 */
class DriverSelfReportedDatesTest extends TestCase
{
    use DatabaseTransactions;

    private const PDF = "%PDF-1.4\n1 0 obj<< /Type /Catalog >>endobj\ntrailer<< /Root 1 0 R >>\n%%EOF";
    private const JSON = ['Accept' => 'application/json'];

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('driver_documents');
    }

    private function driver(): User
    {
        return User::create([
            'name' => 'Sam Driver', 'email' => Str::random(8) . '@example.test', 'phone' => '07123 456789',
            'password' => 'secret-pass', 'type' => 2, 'status' => 1,
        ]);
    }

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => Str::random(8) . '@example.test', 'password' => 'secret-pass', 'type' => 1, 'status' => 1]);
    }

    private function pdf(string $name = 'doc.pdf'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, self::PDF);
    }

    // ------------------------------------------------------------ the rename

    /** @test */
    public function the_licence_document_is_labelled_private_hire_hackney_carriage(): void
    {
        $driver = $this->driver();

        $html = $this->actingAs($driver)->get(route('driver.docs.index'))->getContent();

        $this->assertStringContainsString('Private Hire / Hackney Carriage Driver', $html);
        $this->assertStringNotContainsString('UK Driving Licence', $html);
    }

    // -------------------------------------------------------- dates at upload

    /** @test */
    public function a_driver_can_give_the_expiry_and_issue_date_alongside_the_upload(): void
    {
        $driver = $this->driver();

        $this->actingAs($driver)->post(route('driver.docs.upload', 'driving_licence_front'), [
            'document' => $this->pdf(), 'issue_date' => '2024-01-15', 'expiry_date' => '2029-01-15',
        ], self::JSON)->assertOk();

        $doc = DriverDocument::where('user_id', $driver->id)->where('type', 'driving_licence_front')->firstOrFail();
        $this->assertSame('2024-01-15', $doc->issue_date->toDateString());
        $this->assertSame('2029-01-15', $doc->expiry_date->toDateString());
    }

    /** @test */
    public function dates_are_optional_at_upload_and_validated_when_given(): void
    {
        $driver = $this->driver();

        // No dates at all - upload still succeeds.
        $this->actingAs($driver)->post(route('driver.docs.upload', 'driving_licence_front'),
            ['document' => $this->pdf()], self::JSON)->assertOk();
        $doc = DriverDocument::where('user_id', $driver->id)->where('type', 'driving_licence_front')->firstOrFail();
        $this->assertNull($doc->expiry_date);

        // Garbage date is rejected.
        $this->actingAs($driver)->post(route('driver.docs.upload', 'driving_licence_front'), [
            'document' => $this->pdf('two.pdf'), 'expiry_date' => 'not-a-date',
        ], self::JSON)->assertStatus(422);
    }

    /** @test */
    public function a_date_is_silently_ignored_for_a_document_type_that_does_not_use_it(): void
    {
        $driver = $this->driver();

        // v5c_logbook has no issue/expiry date configured.
        $this->actingAs($driver)->post(route('driver.docs.upload', 'v5c_logbook'), [
            'document' => $this->pdf(), 'issue_date' => '2024-01-01', 'expiry_date' => '2029-01-01',
        ], self::JSON)->assertOk();

        $doc = DriverDocument::where('user_id', $driver->id)->where('type', 'v5c_logbook')->firstOrFail();
        $this->assertNull($doc->issue_date);
        $this->assertNull($doc->expiry_date);
    }

    /** @test */
    public function admin_uploading_on_a_drivers_behalf_can_also_set_the_dates(): void
    {
        $driver = $this->driver();
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.dv.upload', [$driver, 'phv_vehicle_licence']), [
            'document' => $this->pdf(), 'expiry_date' => '2028-06-01',
        ], self::JSON)->assertOk();

        $doc = DriverDocument::where('user_id', $driver->id)->where('type', 'phv_vehicle_licence')->firstOrFail();
        $this->assertSame('2028-06-01', $doc->expiry_date->toDateString());
    }

    // ------------------------------------------------------- save dates alone

    /** @test */
    public function a_driver_can_correct_dates_without_re_uploading_the_file(): void
    {
        $driver = $this->driver();
        $this->actingAs($driver)->post(route('driver.docs.upload', 'driving_licence_front'), [
            'document' => $this->pdf(), 'expiry_date' => '2029-01-15',
        ], self::JSON)->assertOk();
        $doc = DriverDocument::where('user_id', $driver->id)->where('type', 'driving_licence_front')->firstOrFail();
        $originalPath = $doc->path;

        $this->actingAs($driver)->post(route('driver.docs.dates', $doc), [
            'issue_date' => '2024-02-01', 'expiry_date' => '2029-02-01',
        ], self::JSON)->assertOk()->assertJson(['ok' => true]);

        $doc->refresh();
        $this->assertSame('2024-02-01', $doc->issue_date->toDateString());
        $this->assertSame('2029-02-01', $doc->expiry_date->toDateString());
        $this->assertSame($originalPath, $doc->path);   // the file itself is untouched
        $this->assertDatabaseHas('driver_document_reviews', ['driver_document_id' => $doc->id, 'action' => 'dates_updated', 'actor_role' => 'driver']);
    }

    /** @test */
    public function a_driver_cannot_edit_dates_on_an_approved_document_without_replacing_it(): void
    {
        $driver = $this->driver();
        $doc = DriverDocument::create([
            'user_id' => $driver->id, 'type' => 'phv_vehicle_licence', 'original_name' => 'x.pdf', 'path' => 'x/x.enc',
            'mime' => 'application/pdf', 'extension' => 'pdf', 'size' => 10, 'checksum' => str_repeat('a', 64),
            'status' => 'approved', 'uploaded_at' => now(), 'expiry_date' => now()->addYear(),
        ]);

        $this->actingAs($driver)->post(route('driver.docs.dates', $doc), ['expiry_date' => now()->addYears(2)->toDateString()], self::JSON)
            ->assertStatus(403)->assertJson(['reason' => 'approved_locked']);

        $this->assertNotSame(now()->addYears(2)->toDateString(), $doc->fresh()->expiry_date->toDateString());
    }

    /** @test */
    public function a_driver_cannot_correct_dates_on_someone_elses_document(): void
    {
        $owner = $this->driver();
        $other = $this->driver();
        $this->actingAs($owner)->post(route('driver.docs.upload', 'driving_licence_front'),
            ['document' => $this->pdf()], self::JSON)->assertOk();
        $doc = DriverDocument::where('user_id', $owner->id)->firstOrFail();

        $this->actingAs($other)->post(route('driver.docs.dates', $doc), ['expiry_date' => '2030-01-01'], self::JSON)
            ->assertNotFound();
    }

    /** @test */
    public function the_documents_page_shows_the_driver_the_date_inputs_and_a_save_button(): void
    {
        $driver = $this->driver();
        $this->actingAs($driver)->post(route('driver.docs.upload', 'driving_licence_front'), [
            'document' => $this->pdf(), 'expiry_date' => '2029-01-15',
        ], self::JSON)->assertOk();

        $html = $this->actingAs($driver)->get(route('driver.docs.index'))->getContent();

        $this->assertStringContainsString('dd-upload-expiry-date', $html);
        $this->assertStringContainsString('value="2029-01-15"', $html);
        $this->assertStringContainsString('Save dates', $html);
    }
}
