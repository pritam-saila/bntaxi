<?php

namespace App\Http\Controllers\driver;

use App\Http\Controllers\Concerns\ManagesDriverDocumentation;
use App\Http\Controllers\Controller;
use App\Models\DriverDocument;
use Illuminate\Http\Request;

/**
 * A driver managing their OWN documentation. Every action is scoped to the
 * logged-in user - there is no driver id in any URL to tamper with, and a
 * document belonging to anyone else is a 404 (not a 403, so ids can't be probed).
 */
class DriverDocumentController extends Controller
{
    use ManagesDriverDocumentation;

    protected function mode(): string
    {
        return 'driver';
    }

    public function index()
    {
        return $this->renderPage(auth()->user());
    }

    public function details(Request $request)
    {
        return $this->storeDetails($request, $request->user());
    }

    public function vehicle(Request $request)
    {
        return $this->storeVehicle($request, $request->user());
    }

    public function bank(Request $request)
    {
        return $this->storeBank($request, $request->user());
    }

    public function upload(Request $request, string $type)
    {
        return $this->storeDocument($request, $request->user(), $type);
    }

    public function file(Request $request, DriverDocument $document)
    {
        $this->own($request, $document);

        return $this->streamDocument($request, $document);
    }

    public function destroy(Request $request, DriverDocument $document)
    {
        $this->own($request, $document);

        return $this->removeDocument($request, $request->user(), $document);
    }

    private function own(Request $request, DriverDocument $document): void
    {
        abort_unless($document->user_id === $request->user()->id, 404);
    }
}
