<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Loads the FAQ content from database/data/page-faqs.json.
 *
 * Safe to run more than once: a question that already exists for the same page/route is skipped,
 * and existing FAQs are never changed or deleted (new ones are added after them).
 * After this runs, the FAQs are managed in the admin panel.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        foreach ($this->groups() as $group) {
            $target = $this->target($group);
            if ($target === null) {
                Log::warning('FAQ seed: route not found, group skipped', ['route' => $group['route'] ?? null]);
                continue;
            }

            $existing = DB::table('faqs')->where($target)->pluck('question')
                ->map(fn ($q) => mb_strtolower(trim((string) $q)))->all();
            $order = (int) DB::table('faqs')->where($target)->max('sort_order');

            foreach ($group['faqs'] as [$question, $answer]) {
                if (in_array(mb_strtolower(trim($question)), $existing, true)) {
                    continue;
                }
                DB::table('faqs')->insert($target + [
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => ++$order,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->groups() as $group) {
            $target = $this->target($group);
            if ($target === null) {
                continue;
            }
            DB::table('faqs')->where($target)
                ->whereIn('question', array_column($group['faqs'], 0))
                ->delete();
        }
    }

    private function groups(): array
    {
        return json_decode(file_get_contents(database_path('data/page-faqs.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    /** ['page' => 'home'] or ['routehandle_id' => '2'], or null if the route doesn't exist here. */
    private function target(array $group): ?array
    {
        if (!empty($group['page'])) {
            return ['page' => $group['page']];
        }

        $id = DB::table('routehandles')->whereRaw('LOWER(slug) = ?', [mb_strtolower($group['route'])])->value('id');

        return $id ? ['routehandle_id' => (string) $id] : null;
    }
};
