<?php

namespace App\Http\Controllers;

use App\StateAssets;
use App\StateGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use voku\helper\ASCII;

class StateAssetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewStateAssets', ['only' => 'index']);
        $this->middleware('can:addStateAsset', ['only' => 'store']);
        $this->middleware('can:editStateAsset', ['only' => 'update']);
        $this->middleware('can:removeStateGroup', ['only' => 'remove', 'removeStore']);
    }

    public function index($slug)
    {
        $g = StateGroups::where('slug', $slug)->first();
        if (is_null($g)) {
            return redirect()->route('drives')
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = StateAssets::where('group_id', $g->id)->get();

        return view('states.assets.index', [
            'group'     => $g,
            'assets'    => $a
        ]);
    }

    public function store(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'asset_name'        => 'required',
            'text_color'        => '',
            'background_color'  => '',
            'accent_id'         => '',
            'group_id'          => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add asset to state group! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $g = StateGroups::where('slug', $slug)->first();
        if (is_null($g)) {
            return redirect()->route('state-assets', $slug)
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = new StateAssets();
        $s->group_id = $g->id;
        $s->asset_name = $request->asset_name;
        $s->text_color = $request->text_color;
        $s->background_color = $request->background_color;
        $s->save();

        return redirect()->route('state-assets', $g->slug)
            ->with('message', 'Asset has been successfully added to state group!')
            ->with('type', 'alert-success');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'asset_name'        => 'required',
            'text_color'        => '',
            'background_color'  => '',
            'asset_id'          => 'required|numeric',
            'group_id'          => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update asset to state group! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $g = StateGroups::where('id', $request->group_id)->first();
        if (is_null($g)) {
            return redirect()->back()
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = StateAssets::where('id', $request->asset_id)->first();
        if (is_null($a)) {
            return redirect()->route('state-assets', $g->slug)
                ->with('message', 'The state asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a->asset_name = $request->asset_name;
        $a->text_color = $request->text_color;
        $a->background_color = $request->background_color;
        $a->save();

        return redirect()->route('state-assets', $g->slug)
            ->with('message', 'Asset has been successfully updated!')
            ->with('type', 'alert-success');
    }

    public function remove($slug, $id)
    {
        $g = StateGroups::where('slug', $slug)->first();
        if (is_null($g)) {
            return redirect()->back()
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = StateAssets::where('id', $id)->first();
        if (is_null($a)) {
            return redirect()->route('state-assets', $g->slug)
                ->with('message', 'The state asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('states.assets.remove', [
           'group'  => $g,
           'asset'  => $a
        ]);
    }

    public function removeStore(Request $request, $slug, $id)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'group_id'      => 'required|numeric',
            'asset_id'      => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove state asset! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $g = StateGroups::where('id', $request->group_id)->first();
        if (is_null($g)) {
            return redirect()->back()
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $a = StateAssets::where('id', $request->asset_id)->first();
        if (is_null($a)) {
            return redirect()->back()
                ->with('message', 'The state asset you selected does not exist, or you do not have permissions to view it!')
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

        return redirect()->route('state-assets', $g->slug)
            ->with('message', 'State asset has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
