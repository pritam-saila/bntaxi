<?php

namespace App\Support;

/**
 * Stylesheets for the public site (resources/views/goods).
 *
 * The CSS that used to sit in <style> blocks inside the Blade templates now lives in
 * public/goods/css/partials (shared header, footer, quote form...) and public/goods/css/pages
 * (one file per page). Templates load them with the @stylesheet('...') Blade directive, which:
 *
 *  - adds ?v=<file modified time>, so browsers fetch a fresh copy after every change
 *    (no more manual ?v=5 / ?v=6 bumps);
 *  - prints nothing on the homepage when its CSS is already inlined from home.min.css
 *    (built by `npm run build:home-css`), so there are no extra requests there.
 */
class SiteAssets
{
    /** True once a page has inlined home.min.css (set by goods/include/assets.blade.php). */
    public static bool $bundled = false;

    /**
     * Absolute path of a file in the public web root. On some hosts the web root
     * (e.g. public_html) is not Laravel's public/ folder, so the document root is checked too.
     */
    public static function path(string $relative): ?string
    {
        $relative = ltrim($relative, '/');
        $candidates = [public_path($relative)];
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/' . $relative;
        }
        foreach ($candidates as $file) {
            if (is_file($file)) {
                return $file;
            }
        }
        return null;
    }

    /** URL with a cache-busting version taken from the file's modified time. */
    public static function url(string $relative): string
    {
        $file = static::path($relative);
        return url($relative) . ($file ? '?v=' . filemtime($file) : '');
    }

    /** <link> tag for a stylesheet, or nothing when the page already has its CSS inlined. */
    public static function stylesheet(string $relative): string
    {
        if (static::$bundled) {
            return '';
        }
        return '<link rel="stylesheet" href="' . e(static::url($relative)) . '">';
    }
}
