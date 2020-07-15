<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AddMediaSearch extends Component
{
    public $search = 'Matrix';
    public $drive;
    public $server;


    public function mount($drive, $server)
    {
        $this->drive = $drive;
        $this->server = $server;
    }

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) > 2) {
            $searchResults = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.domain').'search/multi?query='.$this->search)
                ->json()['results'];
        }

        return view('livewire.add-media-search', [
            'searchResults' => $searchResults,
            'server'        => $this->server,
            'drive'         => $this->drive
        ]);
    }
}
