<?php

namespace App\Support;

use App\Models\DriverDocument;
use App\Models\User;

/**
 * The driver screen and the admin screen are the same views; only the URLs
 * differ. Views ask this object for URLs instead of branching on the mode.
 */
class DriverDocumentRoutes
{
    public function __construct(private string $mode, private ?User $driver = null)
    {
    }

    private function admin(): bool
    {
        return $this->mode === 'admin';
    }

    public function page(): string
    {
        return $this->admin() ? route('admin.dv.show', $this->driver) : route('driver.docs.index');
    }

    public function details(): string
    {
        return $this->admin() ? route('admin.dv.details', $this->driver) : route('driver.docs.details');
    }

    public function vehicle(): string
    {
        return $this->admin() ? route('admin.dv.vehicle', $this->driver) : route('driver.docs.vehicle');
    }

    public function bank(): string
    {
        return $this->admin() ? route('admin.dv.bank', $this->driver) : route('driver.docs.bank');
    }

    public function upload(string $type): string
    {
        return $this->admin() ? route('admin.dv.upload', [$this->driver, $type]) : route('driver.docs.upload', $type);
    }

    public function file(DriverDocument $doc, bool $thumb = false, bool $download = false): string
    {
        $params = array_filter(['thumb' => $thumb ?: null, 'download' => $download ?: null]);

        return $this->admin()
            ? route('admin.dv.file', [$doc] + $params)
            : route('driver.docs.file', [$doc] + $params);
    }

    public function destroy(DriverDocument $doc): string
    {
        return $this->admin() ? route('admin.dv.destroy', $doc) : route('driver.docs.destroy', $doc);
    }

    /** Admin only. */
    public function review(DriverDocument $doc): string
    {
        return route('admin.dv.review', $doc);
    }

    /** Admin only. */
    public function startReview(): string
    {
        return route('admin.dv.start-review', $this->driver);
    }
}
