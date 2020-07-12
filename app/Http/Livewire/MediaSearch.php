<?php

namespace App\Http\Livewire;

use App\Media;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MediaSearch extends Component
{
    public $search = '';
    public $server;
    public $drive;

    public function mount($server, $drive)
    {
        $this->server = $server;
        $this->drive = $drive;
    }

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) > 1) {
            $searchResults = Media::whereLike('media_title', $this->search)
                ->where('server_id', $this->server->id)
                ->where('drive_id', $this->drive->id)->limit(10)->get();
        }

        return view('livewire.media-search', [
            'server'        => $this->server,
            'drive'         => $this->drive,
            'searchResults' => $searchResults
        ]);
    }
}
