<?php

namespace App\Http\Livewire;

use App\Media;
use Livewire\Component;

class GlobalMediaSearch extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) > 1) {
            $searchResults = Media::whereLike('media_title', $this->search)->limit(10)->get();
        }

        return view('livewire.global-media-search', [
            'searchResults' => $searchResults
        ]);
    }
}
