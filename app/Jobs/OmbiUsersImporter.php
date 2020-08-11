<?php

namespace App\Jobs;

use App\OmbiUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OmbiUsersImporter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stream = Http::withHeaders([
            'ApiKey' => config('services.ombi.key')
        ])->get(config('services.ombi.api_domain').'Identity/Users')->json();

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
        Log::info('[JOB][OmbiUsersImporter] Added (' . $count . ') ombi users');
    }
}
