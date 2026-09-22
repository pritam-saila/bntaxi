<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Driver & vehicle documentation.
     *
     * Name / email / phone / vehicle make & model stay on `users` (they already
     * live there and other screens edit them). Everything new lives here.
     */
    public function up(): void
    {
        // One row per driver: emergency contact, vehicle year and bank details.
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->unsignedSmallInteger('vehicle_year')->nullable();

            // Encrypted by the model ("encrypted" cast) - ciphertext is far
            // longer than the plain value, hence text columns.
            $table->text('bank_account_holder')->nullable();
            $table->text('bank_account_number')->nullable();
            $table->text('bank_sort_code')->nullable();
            $table->text('bank_name')->nullable();

            $table->timestamps();
        });

        // The current file for each (driver, document type).
        Schema::create('driver_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();   // used in URLs instead of the sequential id
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 50);

            $table->string('original_name');
            $table->string('path');            // encrypted file on the private disk
            $table->string('thumb_path')->nullable();
            $table->string('mime', 100);
            $table->string('extension', 10);
            $table->unsignedBigInteger('size');
            $table->char('checksum', 64);

            // uploaded | under_review | approved | rejected  ("expired" is derived from expiry_date)
            $table->string('status', 20)->default('uploaded');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->timestamp('uploaded_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'type']);
            $table->index(['status', 'expiry_date']);
        });

        // Append-only audit trail. Survives the document row being deleted or
        // replaced (document id goes null, driver + type are kept).
        Schema::create('driver_document_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_document_id')->nullable()->constrained('driver_documents')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();   // the driver
            $table->string('document_type', 50);

            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('actor_role', 10);          // driver | admin
            $table->string('action', 30);              // uploaded, replaced, deleted, started_review, approved, rejected, reupload_requested, dates_updated, note
            $table->string('from_status', 20)->nullable();
            $table->string('to_status', 20)->nullable();
            $table->text('reason')->nullable();        // shown to the driver
            $table->text('note')->nullable();          // internal - admins only

            $table->timestamp('created_at')->nullable();

            $table->index(['user_id', 'document_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_document_reviews');
        Schema::dropIfExists('driver_documents');
        Schema::dropIfExists('driver_profiles');
    }
};
