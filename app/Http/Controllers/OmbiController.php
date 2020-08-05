<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class OmbiController extends Controller
{
    public function getIssues()
    {
        $respose = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.domain').'Issues')->json();
    }
}
