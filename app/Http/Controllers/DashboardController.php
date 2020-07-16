<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $media = Media::all();

        return view('dashboard', [
            'media'     => $media
        ]);
    }
}
