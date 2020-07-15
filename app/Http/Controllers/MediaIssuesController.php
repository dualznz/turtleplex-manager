<?php

namespace App\Http\Controllers;

use App\DriveAssets;
use App\Drives;
use App\MediaIssues;
use App\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class MediaIssuesController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewMediaIssues', ['only' => 'index']);
        $this->middleware('can:sendMediaIssue', ['only' => 'storeSubmission']);
    }

    public function index()
    {
        $issues = MediaIssues::orderBy('created_at', 'DESC')->paginate(20);

        return view('media.issues.index', [
            'issues' => $issues
        ]);
    }

    public function store(Request $request, $server_slug, $drive_slug)
    {
        $validator = Validator::make($request->all(), [
            'tmdb_url'              => 'required',
            'drive_assets'          => 'required|numeric',
            'server_id'             => 'required|numeric',
            'drive_id'              => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $server = Servers::where('id', $request->server_id)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $request->drive_id)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('id', $request->drive_assets)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $s = new MediaIssues();
        $s->server_id = $server->id;
        $s->drive_id = $drive->id;
        $s->drive_asset_id = $asset->id;
        $s->state_asset_id = env('MEDIA_ISSUES_PENDING_ID');
        $s->tmdb_url = $request->tmdb_url;
        $s->save();

        return redirect()->route('media', [$server->slug, $drive->slug])
            ->with('message', 'Media issue has been successfully added!')
            ->with('type', 'alert-success');
    }

    public function viewStep1($id)
    {
        $issue = MediaIssues::where('id', $id)->first();
        if (is_null($issue)) {
            return redirect()->back()
                ->with('message', 'The media submission issue you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $server = Servers::where('id', $issue->server_id)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $issue->drive_id)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('id', $issue->drive_asset_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.issues.updater.step1', [
            'issue'     => $issue
        ]);
    }

    public function storeStep1(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tmdb_id'               => 'required',
            'tmdb_media_type'       => 'required',
            'server_id'             => 'required|numeric',
            'drive_id'              => 'required|numeric',
            'issue_id'              => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $issue = MediaIssues::where('id', $request->id)->first();
        if (is_null($issue)) {
            return redirect()->back()
                ->with('message', 'The media submission issue you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $server = Servers::where('id', $issue->server_id)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $issue->drive_id)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('id', $issue->drive_asset_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $data = [
            'tmdb_id'           => $request->tmdb_id,
            'tmdb_media_type'   => $request->tmdb_media_type,
            'issue_id'          => $issue->id,
            'server_id'         => $server->id,
            'drive_id'          => $drive->id,
        ];

        return redirect()->route('media-issues-updater-step2', $issue->id)->withCookie(cookie('mediaSubmissionUpdater', json_encode($data), 1440));
    }

    public function viewStep2($id)
    {
        if ($m = json_decode(Cookie::get('mediaSubmissionUpdater'))) {

            $issue = MediaIssues::where('id', $m->issue_id)->first();
            if (is_null($issue)) {
                return redirect()->route('media-issue')
                    ->with('message', 'The media submission issue you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $server = Servers::where('id', $issue->server_id)->first();
            if (is_null($server)) {
                return redirect()->route('media-issue')
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $drive = Drives::where('id', $issue->drive_id)
                ->where('server_id', $server->id)->first();
            if (is_null($drive)) {
                return redirect()->route('media-issue')
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $asset = DriveAssets::where('id', $issue->drive_asset_id)
                ->where('server_id', $server->id)
                ->where('drive_id', $drive->id)->first();
            if (is_null($asset)) {
                return redirect()->route('media-issue')
                    ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $stream = [];
            if ($m->tmdb_media_type == 'movie') {
                $stream = Http::withToken(config('services.tmdb.token'))
                    ->get(config('services.tmdb.domain').'movie/'.$m->tmdb_id)
                    ->json();
            } elseif ($m->tmdb_media_type == 'tv') {
                $stream = Http::withToken(config('services.tmdb.token'))
                    ->get(config('services.tmdb.domain').'tv/'.$m->tmdb_id)
                    ->json();
            }

            return view('media.issues.updater.step2', [
                'issue'         => $issue,
                'media_type'    => $m->tmdb_media_type,
                'stream'        => $stream
            ]);

        }
    }

    public function storeStep2(Request $request, $id)
    {

    }
}
