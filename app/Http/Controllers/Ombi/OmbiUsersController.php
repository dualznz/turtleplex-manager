<?php

namespace App\Http\Controllers\Ombi;

use App\Http\Controllers\Controller;
use App\Jobs\ManualOmbiUsersImport;
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
        ManualOmbiUsersImport::dispatch();

        return redirect()->back()
            ->with('message', 'Manual ombi users import job has been dispatched, the information will update shortly!')
            ->with('type', 'alert-success');
    }
}
