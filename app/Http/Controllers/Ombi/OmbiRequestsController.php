<?php

namespace App\Http\Controllers\Ombi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OmbiRequestsController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewOmbiRequests', ['only' => 'index']);
    }

    public function index()
    {

    }
}
