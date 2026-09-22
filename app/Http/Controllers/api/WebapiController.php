<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function fetchsubcat($id)
    {
        $data = Category::where(['cat_id' => $id])->get();
        return response($data);
    }
}
