<?php

namespace App\Http\Controllers;

use App\OmbiUsers;
use Illuminate\Support\Facades\Http;

class OmbiController extends Controller
{
    public function getIssues()
    {
        $respose = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.domain').'Issues')->json();
    }

    public function getUsers()
    {
        $stream = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.api_domain').'Identity/Users')->json();
    }

    public function getMovies()
    {
        $stream = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.api_domain').'Request/movie')->json();

        $t = [];
        foreach ($stream as $i) {
            array_push($t, [
                $i['theMovieDbId'],
                $i['imdbId'],
                $i['overview'],
                $i['posterPath']
            ]);
        }
    }
}
