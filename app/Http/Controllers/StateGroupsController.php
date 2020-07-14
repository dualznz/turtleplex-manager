<?php

namespace App\Http\Controllers;

use App\StateAssets;
use App\StateGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewStateGroups', ['only' => 'index']);
        $this->middleware('can:addStateGroup', ['only' => 'store']);
        $this->middleware('can:editStateGroup', ['only' => 'update']);
        $this->middleware('can:removeStateGroup', ['only' => 'remove', 'removeStore']);
    }

    public function index()
    {
        $groups = StateGroups::orderBy('group_name', 'ASC')->get();

        return view('states.index', [
           'groups' => $groups
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new state group! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $s = new StateGroups();
        $s->group_name = $request->group_name;
        $s->save();

        // replicate slug to ensure uniqueness
        $newPost = $s->replicate();

        return redirect()->route('state-groups')
            ->with('message', 'New state group has been successfully created!')
            ->with('type', 'alert-success');
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'group_name'    => 'required',
            'group_id'      => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add update state group! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $s = StateGroups::where('id', $request->group_id)
            ->where('slug', $slug)->first();
        if (is_null($s)) {
            return redirect()->route('state-groups')
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s->group_name = $request->group_name;
        $s->save();

        return redirect()->route('state-groups')
            ->with('message', 'New state group has been successfully updated!')
            ->with('type', 'alert-success');
    }

    public function remove($slug)
    {
        $g = StateGroups::where('slug', $slug)->first();
        if (is_null($g)) {
            return redirect()->route('state-groups')
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = StateAssets::where('group_id', $g->id)->get();

        return view('states.remove', [
            'group'     => $g,
            'assets'    => $s
        ]);
    }

    public function removeStore(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'group_id'      => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove state group! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $g = StateGroups::where('id', $request->group_id)
            ->where('slug', $slug)->first();
        if (is_null($g)) {
            return redirect()->route('state-groups')
                ->with('message', 'The state group you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != $g->slug) {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $g->delete();

        return redirect()->route('state-groups')
            ->with('message', 'State group has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
