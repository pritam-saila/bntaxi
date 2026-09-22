<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Service;
use App\Models\Routehandle;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

        public function __construct()
    {

        $menu = Content::whereIn('id', [2, 3, 4])->get();
        // You can share more data, even from DB
        View::share('categories', $menu);

        $services = Service::all();
        View::share('services', $services);

        $routehandles = Routehandle::all();
        View::share('routehandles', $routehandles);
    }
}
