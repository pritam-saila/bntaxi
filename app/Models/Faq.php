<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A question and answer shown on a public page.
 *
 * Belongs to either a route (routehandle_id -> /route-details/{slug}) or a page
 * (page = "home", "about" or "service:{service slug}").
 */
class Faq extends Model
{
    use HasFactory;

    /** Pages (other than routes) that can have FAQs; services are added dynamically. */
    public const PAGES = [
        'home' => 'Homepage',
        'about' => 'About Us',
    ];

    protected $fillable = [
        'routehandle_id',
        'page',
        'question',
        'answer',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeForPage(Builder $query, string $page): Builder
    {
        return $query->where('page', $page)->ordered();
    }

    public function scopeForRoute(Builder $query, $routehandleId): Builder
    {
        return $query->where('routehandle_id', (string) $routehandleId)->ordered();
    }

    /** Every page key an admin can attach FAQs to, with a readable name. */
    public static function pageOptions(): array
    {
        $options = self::PAGES;
        foreach (Service::orderBy('id')->get(['slug', 'title']) as $service) {
            $options['service:' . $service->slug] = 'Service: ' . $service->title;
        }
        return $options;
    }
}
