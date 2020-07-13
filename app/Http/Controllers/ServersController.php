<?php

namespace App\Http\Controllers;

use App\Drives;
use App\Servers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JJG\Ping;
use voku\helper\ASCII;

class ServersController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewServers', ['only' => 'index']);
        $this->middleware('can:addServer', ['only' => 'create', 'store']);
        $this->middleware('can:editServer', ['only' => 'edit', 'update']);
        $this->middleware('can:removeServer', ['only' => 'remove', 'removeStore']);
    }

    public function index()
    {
        $servers = Servers::orderBy('server_name', 'ASC')->get();

        return view('servers.index', [
            'servers'       => $servers,
            'count_servers' => Servers::count()
        ]);
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'server_name'   => 'required',
            'server_host'   => 'required',
            'network_path'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new server! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        // ping server host for initial host check
        $result = 0;
        $host = $request->server_host;
        $ping = new Ping($host);
        $latency = $ping->ping();
        if ($latency !== false) {
            // response successful
            $result = 1;
        } else {
            // response failure
            $result = 0;
        }


        $s = new Servers();
        $s->server_name = $request->server_name;
        $s->server_host = $request->server_host;
        $s->network_path = $request->network_path;
        $s->ping_status = $result;
        $s->pinged_at = Carbon::now();
        $s->save();

        // replicate slug to ensure uniqueness
        $newPost = $s->replicate();

        return redirect()->route('servers')
            ->with('message', 'New server has been successfully created!')
            ->with('type', 'alert-success');
    }

    public function edit($slug)
    {
        $s = Servers::where('slug', $slug)->first();
        if (is_null($s)) {
            return redirect()->route('servers')
                ->with('message', 'This server does not exist or you do not have permission to view it!')
                ->with('type', 'alert-warning');
        }

        return view('servers.edit', [
           'server' => $s
        ]);
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'server_host'   => 'required',
            'network_path'  => 'required',
            'server_id'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update server! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $s = Servers::where('slug', $slug)
            ->where('id', $request->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('servers')
                ->with('message', 'This server does not exist or you do not have permission to view it!')
                ->with('type', 'alert-warning');
        }

        // ping server host for initial host check
        $result = 0;
        $host = $request->server_host;
        $ping = new Ping($host);
        $latency = $ping->ping();
        if ($latency !== false) {
            // response successful
            $result = 1;
        } else {
            // response failure
            $result = 0;
        }

        $s->server_host = $request->server_host;
        $s->network_path = $request->network_path;
        $s->ping_status = $result;
        $s->pinged_at = Carbon::now();
        $s->save();

        return redirect()->route('servers')
            ->with('message', 'Server has been successfully updated!')
            ->with('type', 'alert-success');
    }

    public function remove($slug)
    {
        $s = Servers::where('slug', $slug)->first();
        if (is_null($s)) {
            return redirect()->route('servers')
                ->with('message', 'This server does not exist or you do not have permission to view it!')
                ->with('type', 'alert-warning');
        }

        $drives = Drives::where('server_id', $s->id)->get();

        return view('servers.remove', [
           'server' => $s,
           'drives' => $drives
        ]);

    }

    public function removeStore(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'server_id'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove server! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $s = Servers::where('slug', $slug)
            ->where('id', $request->server_id)->first();
        if (is_null($s)) {
            return redirect()->route('servers')
                ->with('message', 'This server does not exist or you do not have permission to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != $s->slug) {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $s->delete();

        return redirect()->route('servers')
            ->with('message', 'Server has been successfully removed!')
            ->with('type', 'alert-danger');

    }

}
