<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FAQs can now belong to any public page, not only to a route:
 *  - routehandle_id set  -> shown on /route-details/{slug} (as before)
 *  - page set            -> shown on that page: "home", "about" or "service:{service slug}"
 * sort_order controls the display order (lowest first, then oldest first).
 */
return new class extends Migration
{
    public function up(): void
    {
        // The faqs table was created outside the migrations on existing installs.
        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('routehandle_id')->nullable();
                $table->text('question')->nullable();
                $table->text('answer')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'page')) {
                $table->string('page', 100)->nullable()->after('routehandle_id')->index();
            }
            if (!Schema::hasColumn('faqs', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('answer');
            }
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            if (Schema::hasColumn('faqs', 'page')) {
                $table->dropIndex(['page']);
                $table->dropColumn('page');
            }
            if (Schema::hasColumn('faqs', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
