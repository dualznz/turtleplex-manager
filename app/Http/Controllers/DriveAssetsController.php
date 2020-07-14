<?php

namespace App\Http\Controllers;

use App\Assets;
use App\DriveAssets;
use App\Drives;
use App\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriveAssetsController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewDriveAssets', ['only' => 'index']);
        $this->middleware('can:addDriveAsset', ['only' => 'store']);
        $this->middleware('can:editDriveAsset', ['only' => 'update']);
        $this->middleware('can:removeDriveAsset', ['only' => 'remove', 'removeStore']);
    }

    public function index($slug)
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

        $a = DriveAssets::where('drive_id', $d->id)
            ->where('server_id', $s->id)->get();

        return view('drives.assets.index', [
            'drive'     => $d,
            'assets'    => $a
        ]);
    }

    public function store(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'asset_name'        => 'required',
            'asset_folder'      => 'required',
            'drive_id'          => 'required|numeric',
            'server_id'         => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add asset to drive! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $d = Drives::where('slug', $slug)
            ->where('id', $request->drive_id)->first();
        if (is_null($d)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = Servers::where('id', $request->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('drive-assets', $d->slug)
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = new DriveAssets();
        $a->drive_id = $d->id;
        $a->server_id = $s->id;
        $a->asset_name = $request->asset_name;
        $a->asset_folder = $request->asset_folder;
        $a->save();

        return redirect()->route('drive-assets', $d->slug)
            ->with('message', 'Asset has been successfully added to drive!')
            ->with('type', 'alert-success');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'asset_name'        => 'required',
            'asset_folder'      => 'required',
            'drive_id'          => 'required|numeric',
            'server_id'         => 'required|numeric',
            'asset_id'          => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update asset on drive! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $d = Drives::where('id', $request->drive_id)
            ->where('id', $request->drive_id)->first();
        if (is_null($d)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = Servers::where('id', $request->server_id)->first();
        if (is_null($s)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = DriveAssets::where('id', $request->asset_id)
            ->where('server_id', $s->id)
            ->where('drive_id', $d->id)->first();
        if (is_null($a)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a->asset_name = $request->asset_name;
        $a->asset_folder = $request->asset_folder;
        $a->save();

        return redirect()->route('drive-assets', $d->slug)
            ->with('message', 'Asset has been successfully updated on drive!')
            ->with('type', 'alert-success');
    }

    public function remove($slug, $id)
    {
        $d = Drives::where('slug', $slug)->first();
        if (is_null($d)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = Servers::where('id', $d->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = DriveAssets::where('id', $id)
            ->where('server_id', $s->id)
            ->where('drive_id', $d->id)->first();
        if (is_null($a)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('drives.assets.remove', [
            'asset' => $a,
            'drive' => $d
        ]);
    }

    public function removeStore(Request $request, $slug, $id)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'asset_id'      => 'required|numeric',
            'drive_id'      => 'required|numeric',
            'server_id'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove asset! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $s = Servers::where('id', $request->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $d = Drives::where('id', $request->drive_id)
            ->where('server_id', $s->id)->first();
        if (is_null($d)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = DriveAssets::where('id', $request->asset_id)
            ->where('server_id', $request->server_id)
            ->where('drive_id', $request->drive_id)->first();
        if (is_null($a)) {
            return redirect()->route('drive-assets', $slug)
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != $a->asset_name) {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $a->delete();

        return redirect()->route('drive-assets', $d->slug)
            ->with('message', 'Asset has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
