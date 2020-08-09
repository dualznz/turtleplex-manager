<?php

namespace App\Http\Controllers\Ombi;

use App\Http\Controllers\Controller;
use App\OmbiUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OmbiUsersController extends Controller
{
    public function index()
    {
        return view('developer.ombi.index', [
            'users' => OmbiUsers::orderBy('username', 'ASC')->get()
        ]);
    }

    public function importer()
    {
        $stream = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.domain').'Identity/Users')->json();

        $count = 0;

        foreach ($stream as $i) {
            // check to see if the user is already in the database table
            $users = OmbiUsers::where('user_id', $i['id'])->first();
            if (is_null($users)) {
                // user has not been found so we can add them
                $s = new OmbiUsers();
                $s->user_id = $i['id'];
                $s->username = $i['userName'];
                $s->alias = $i['alias'];
                $s->email = $i['emailAddress'];
                $s->save();

                $count++;
            }
        }
    }
}
