<?php

namespace App\Http\Livewire;

use App\MediaIssues;
use Livewire\Component;

class MediaIssuesSorting extends Component
{
    public $sorting = 0;

    public function render()
    {
        $sortResults = [];

        $sortResults = MediaIssues::where('completed', $this->sorting)->orderBy('id', 'DESC')->get();

        return view('livewire.media-issues-sorting', [
            'sortResults' => $sortResults
        ]);
    }
}
