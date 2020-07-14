<?php

namespace App\Http\Controllers;

use App\Assets;
use App\DriveAssets;
use App\Drives;
use App\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrivesController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewDrives', ['only' => 'index']);
        $this->middleware('can:addDrive', ['only' => 'create', 'store']);
        $this->middleware('can:editDrive', ['only' => 'edit', 'update']);
        $this->middleware('can:removeDrive', ['only' => 'remove', 'removeStore']);
    }

    public function index()
    {
        $drives = Drives::orderBy('drive_name', 'ASC')->get();

        return view('drives.index', [
           'drives' => $drives
        ]);
    }

    public function create()
    {
        return view('drives.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drive_name'        => 'required',
            'attached_server'   => 'required',
            'drive_folder'      => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new drive to associated server! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $srv = Servers::where('id', $request->attached_server)->first();
        if (is_null($srv)) {
            return redirect()->route('drives')
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = new Drives();
        $s->server_id = $srv->id;
        $s->drive_name = $request->drive_name;
        $s->drive_folder = $request->drive_folder;
        $s->save();

        // replicate slug to ensure uniqueness
        $newPost = $s->replicate();

        return redirect()->route('drives')
            ->with('message', 'New drive has been successfully created and binded to ' . $srv->server_name . '!')
            ->with('type', 'alert-success');
    }

    public function edit($slug)
    {
        $d = Drives::where('slug', $slug)->first();
        if (is_null($d)) {
            return redirect()->route('drives')
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('drives.edit', [
           'drive'  => $d
        ]);
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'attached_server'   => 'required',
            'drive_folder'      => 'required',
            'drive_id'          => 'required|numeric',
            'server_id'         => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update drive on associated server! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $d = Drives::where('slug', $slug)
            ->where('id', $request->drive_id)
            ->where('server_id', $request->server_id)->first();
        if (is_null($d)) {
            return redirect()->route('drives')
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = Servers::where('id', $request->attached_server)->first();
        if (is_null($s)) {
            return redirect()->route('drives')
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $d->server_id = $s->id;
        $d->drive_folder = $request->drive_folder;
        $d->save();

        return redirect()->route('drives')
            ->with('message', 'Drive has been successfully updated!')
            ->with('type', 'alert-success');
    }

    public function remove($slug)
    {
        $d = Drives::where('slug', $slug)->first();
        if (is_null($d)) {
            return redirect()->route('drives')
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = Servers::where('id', $d->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('drives')
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = DriveAssets::where('server_id', $s->id)
            ->where('drive_id', $d->id)->get();

        return view('drives.remove', [
            'drive'     => $d,
            'assets'    => $a
        ]);
    }

    public function removeStore(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'drive_id'      => 'required|numeric',
            'server_id'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove drive! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $d = Drives::where('slug', $slug)
            ->where('id', $request->drive_id)
            ->where('server_id', $request->server_id)->first();
        if (is_null($d)) {
            return redirect()->route('drives')
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != $d->slug) {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $d->delete();

        return redirect()->route('drives')
            ->with('message', 'Drive has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
