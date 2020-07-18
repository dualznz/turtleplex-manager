<?php

namespace App\Http\Controllers;

use App\DriveAssets;
use App\Drives;
use App\Media;
use App\MediaIssues;
use App\Servers;
use App\StateAssets;
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
        $this->middleware('can:updateMediaIssue', ['only' => 'viewStep1', 'storeStep1', 'viewStep2', 'storeStep2']);
        $this->middleware('can:removeMediaIssue', ['only' => 'remove', 'removeStore']);
    }

    public function index()
    {
        $issues = MediaIssues::where('completed', 0)
            ->orderBy('id', 'DESC')->paginate(20);

        return view('media.issues.index', [
            'issues' => $issues
        ]);
    }

    public function filter($completed)
    {
        $issues = MediaIssues::where('completed', $completed)
            ->orderBy('id', 'DESC')->paginate(20);


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
        $validator = Validator::make($request->all(), [
            'server_id'         => 'required|numeric',
            'drive_id'          => 'required|numeric',
            'asset_id'          => 'required|numeric',
            'issue_id'          => 'required|numeric',
            'state_issue_asset' => 'required',
            'state_asset'       => 'required',
            'tmdb_id'           => 'required',
            'media_type'        => 'required',
            'media_title'       => 'required',
            'release_year'      => 'required',
            'vote_average'      => '',
            'poster_92_path'    => '',
            'poster_154_path'   => '',
            'backdrop_path'     => '',
            'overview'          => '',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add new media & resolve issue! have you filled in all the required fields ?')
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

        $asset = DriveAssets::where('id', $request->asset_id)
            ->where('server_id', $server->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The drive asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $stateIssueAsset = StateAssets::where('id', $request->state_issue_asset)->first();
        if (is_null($stateIssueAsset)) {
            return redirect()->back()
                ->with('message', 'The issue status you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $stateAsset = StateAssets::where('id', $request->state_asset)->first();
        if (is_null($stateAsset)) {
            return redirect()->back()
                ->with('message', 'The media status you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $issue = MediaIssues::where('id', $request->issue_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('drive_asset_id', $asset->id)->first();
        if (is_null($issue)) {
            return redirect()->back()
                ->with('message', 'The media issue you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = new Media();
        $media->server_id = $server->id;
        $media->drive_id = $drive->id;
        $media->drive_asset_id = $asset->id;
        $media->state_asset_id = $stateAsset->id;
        $media->tmdb_id = $request->tmdb_id;
        $media->media_title = $request->media_title;
        $media->release_year = $request->release_year;
        $media->vote_average = $request->vote_average;
        $media->poster_92_path = $request->poster_92_path == 'https://image.tmdb.org/t/p/w92' ? '/static/assets/images/noposter_92.jpg' : $request->poster_92_path;
        $media->poster_154_path = $request->poster_154_path == 'https://image.tmdb.org/t/p/w154' ? '/static/assets/images/noposter_154.jpg' : $request->poster_154_path;
        $media->backdrop_path = $request->backdrop_path == 'https://image.tmdb.org/t/p/original/' ? null : $request->backdrop_path;
        $media->media_type = $request->media_type;
        $media->overview = $request->overview == '' ? 'No overview is currently available at this time.' : $request->overview;
        $media->save();

        // replicate slug to ensure uniqueness
        $newPost = $media->replicate();

        $issue->tmdb_id = $request->tmdb_id;
        $issue->tmdb_media_type = $request->media_type;
        $issue->state_asset_id = $stateIssueAsset->id;
        $issue->completed = 1;
        $issue->save();

        return redirect()->route('media-issue')
            ->with('message', 'Issue has been successfully resolved & '.$request->media_title.' ('.$request->release_year.') has been added to '.$drive->drive_name.'!')
            ->with('type', 'alert-success');
    }

    public function remove($id) {
        $issue = MediaIssues::where('id', $id)->first();
        if (is_null($issue)) {
            return redirect()->route('media-issue')
                ->with('message', 'The issue you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.issues.remove', [
            'issue' => $issue
        ]);
    }

    public function removeStore(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'      => 'required',
            'server_id'         => 'required|numeric',
            'drive_id'          => 'required|numeric',
            'issue_id'          => 'required|numeric',
            'asset_id'          => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove media issue! have you filled in all the required fields ?')
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

        $asset = DriveAssets::where('id', $request->asset_id)
            ->where('server_id', $server->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The drive asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $issue = MediaIssues::where('id', $request->issue_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('drive_asset_id', $asset->id)->first();
        if (is_null($issue)) {
            return redirect()->back()
                ->with('message', 'The media issue you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != 'I-AGREE') {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $issue->delete();

        return redirect()->route('media-issue')
            ->with('message', 'Media issue has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
