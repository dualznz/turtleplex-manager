<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaSearchController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewMediaSearch', ['only' => 'index']);
    }

    public function index()
    {
        return view('media.search.global');
    }
}
