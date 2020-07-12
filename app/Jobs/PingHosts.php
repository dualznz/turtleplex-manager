<?php

namespace App\Jobs;

use App\Servers;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JJG\Ping;
use Illuminate\Support\Facades\Log;

class PingHosts implements ShouldQueue
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
        // ping each server to return result

        $updated = 0;

        $servers = Servers::all();
        foreach ($servers as $s) {
            $host = $s->server_host;
            $ping = new Ping($host);
            $latency = $ping->ping();
            if ($latency !== false) {
                $s->ping_status = 1;
                $s->pinged_at = Carbon::now();
                $s->save();
            } else {
                $s->ping_status = 0;
                $s->pinged_at = Carbon::now();
                $s->save();
            }

            $updated++;
        }
        Log::info('[JOB][PingHosts] pinged (' . $updated . ') hosts');
    }
}
