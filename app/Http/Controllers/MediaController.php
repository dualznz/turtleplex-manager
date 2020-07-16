<?php

namespace App\Http\Controllers;

use App\DriveAssets;
use App\Drives;
use App\Media;
use App\Servers;
use App\StateAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class MediaController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewDriveMedia', ['only' => 'index']);
        $this->middleware('can:addDriveMedia', ['only' => 'add']);
        $this->middleware('can:insertDriveMedia', ['only' => 'insertMedia', 'store']);
        $this->middleware('can:editDriveMedia', ['only' => 'viewMediaStore']);
        $this->middleware('can:moveDriveMedia', ['only' => 'viewMoveStep1', 'storeMoveStep1', 'viewMoveStep2', 'storeMoveStep2', 'viewMoveStep3', 'storeMoveStep3', 'viewMoveStep4', 'storeMoveStep4']);
        $this->middleware('can:removeDriveMedia', ['only' => 'remove', 'removeStore']);
    }

    public function index($server_slug, $drive_slug)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('drive_id', $drive->id)
            ->orderBy('created_at', 'DESC')->limit(5)->get();

        return view('media.index', [
           'server'     => $server,
           'drive'      => $drive,
           'media'      => $media
        ]);
    }

    public function add($server_slug, $drive_slug)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }


        return view('media.add.add', [
            'server'     => $server,
            'drive'      => $drive
        ]);
    }

    public function insertMedia($server_slug, $drive_slug, $tmdb_media_type, $tmdb_id)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $assets = DriveAssets::where('server_id', $server->id)
            ->where('drive_id', $drive->id)->get();
        if (is_null($assets)) {
            return redirect()->back()
                ->with('message', 'The assets that belong to this drive does not exist!')
                ->with('type', 'alert-warning');
        }

        $stream = [];
        if ($tmdb_media_type == 'movie') {
            $stream = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.domain').'movie/'.$tmdb_id)
                ->json();
        } elseif ($tmdb_media_type == 'tv') {
            $stream = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.domain').'tv/'.$tmdb_id)
                ->json();
        }

        return view('media.create', [
            'server'                => $server,
            'drive'                 => $drive,
            'assets'                => $assets,
            'media_type'            => $tmdb_media_type,
            'stream'                => $stream,
            'media_state_group'     => env('STATE_MEDIA_ASSET_GROUP')
        ]);

    }

    public function store(Request $request, $server_slug, $drive_slug)
    {
        $validator = Validator::make($request->all(), [
            'drive_assets'          => 'required',
            'media_state'           => 'required',
            'tmdb_id'               => 'required|numeric',
            'media_type'            => 'required',
            'media_title'           => 'required',
            'release_year'          => 'required',
            'vote_average'          => '',
            'poster_92_path'        => '',
            'poster_154_path'       => '',
            'backdrop_path'         => '',
            'overview'              => '',
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

        $s = new Media();
        $s->server_id = $server->id;
        $s->drive_id = $drive->id;
        $s->drive_asset_id = $request->drive_assets;
        $s->state_asset_id = $request->media_state;
        $s->tmdb_id = $request->tmdb_id;
        $s->media_title = $request->media_title;
        $s->release_year = $request->release_year;
        $s->vote_average = $request->vote_average;
        $s->poster_92_path = $request->poster_92_path == 'https://image.tmdb.org/t/p/w92' ? '/static/assets/images/noposter_92.jpg' : $request->poster_92_path;
        $s->poster_154_path = $request->poster_154_path == 'https://image.tmdb.org/t/p/w154' ? '/static/assets/images/noposter_154.jpg' : $request->poster_154_path;
        $s->backdrop_path = $request->backdrop_path == 'https://image.tmdb.org/t/p/original/' ? null : $request->backdrop_path;
        $s->media_type = $request->media_type;
        $s->overview = $request->overview == '' ? 'No overview is currently available at this time.' : $request->overview;
        $s->save();

        // replicate slug to ensure uniqueness
        $newPost = $s->replicate();

        return redirect()->route('media-add', [$server->slug, $drive->slug])
            ->with('message', $request->media_title . ' has been successfully added!')
            ->with('type', 'alert-success');
    }

    public function viewMedia($server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('slug', $slug)
            ->where('release_year', $release_year)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.view', [
            'server'                => $server,
            'drive'                 => $drive,
            'media'                 => $media,
            'media_state_group'     => env('STATE_MEDIA_ASSET_GROUP')
        ]);
    }

    public function viewMediaStore(Request $request,$server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'drive_assets'          => 'required',
            'media_state'           => 'required',
            'server_id'             => 'required|numeric',
            'drive_id'              => 'required|numeric',
            'media_id'              => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update media! have you filled in all the required fields ?')
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

        $media = Media::where('id', $request->media_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media->drive_asset_id = $request->drive_assets;
        $media->state_asset_id = $request->media_state;
        $media->save();

        return redirect()->back()
            ->with('message', 'Successfully updated media information!')
            ->with('type', 'alert-success');
    }

    public function viewMoveStep1($server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('slug', $slug)
            ->where('release_year', $release_year)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.move.step1', [
            'server'                => $server,
            'drive'                 => $drive,
            'media'                 => $media,
            'media_state_group'     => env('STATE_MEDIA_ASSET_GROUP')
        ]);
    }

    public function storeMoveStep1(Request $request, $server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'destination_server'    => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to move media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $server = Servers::where('id', $request->destination_server)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $data = [
            'server_id'             => $server->id,
            'drive_slug'            => $drive_slug,
            'media_type'            => $media_type,
            'media_slug'            => $slug,
            'media_release_year'    => $release_year,
        ];

        return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])->withCookie(cookie('mediaMove', json_encode($data), 1440));
    }

    public function viewMoveStep2($server_slug, $drive_slug, $media_type ,$slug, $release_year)
    {
        if ($m = json_decode(Cookie::get('mediaMove'))) {

            $old_server = Servers::where('slug', $server_slug)->first();
            if (is_null($old_server)) {
                return redirect()->route('media-move-step1', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_server = Servers::where('id', $m->server_id)->first();
            if (is_null($new_server)) {
                return redirect()->route('media-move-step1', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $old_drive = Drives::where('slug', $m->drive_slug)
                ->where('server_id', $old_server->id)->first();
            if (is_null($old_drive)) {
                return redirect()->route('media-move-step1', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_drive = Drives::where('slug', $m->drive_slug)
                ->where('server_id', $new_server->id)->first();
            if (is_null($new_drive)) {
                return redirect()->route('media-move-step1', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $media = Media::where('slug', $m->media_slug)
                ->where('release_year', $m->media_release_year)
                ->where('server_id', $old_server->id)
                ->where('drive_id', $old_drive->id)->first();
            if (is_null($media)) {
                return redirect()->route('media-move-step1', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            return view('media.move.step2', [
                'server'        => $old_server,
                'new_server'    => $new_server,
                'drive'         => $old_drive,
                'new_drive'     => $new_drive,
                'media'         => $media,
                'media_type'    => $m->media_type
            ]);
        }
    }

    public function storeMoveStep2(Request $request, $server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'destination_drive'    => 'required|numeric',
            'destination_server'   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to move media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $server = Servers::where('id', $request->destination_server)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $request->destination_drive)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $data = [
            'server_id'             => $server->id,
            'drive_id'              => $drive->id,
            'drive_slug'            => $drive_slug,
            'media_type'            => $media_type,
            'media_slug'            => $slug,
            'media_release_year'    => $release_year,
        ];

        return redirect()->route('media-move-step3', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])->withCookie(cookie('mediaMove', json_encode($data), 1440));
    }

    public function viewMoveStep3($server_slug, $drive_slug, $media_type ,$slug, $release_year)
    {
        if ($m = json_decode(Cookie::get('mediaMove'))) {

            $old_server = Servers::where('slug', $server_slug)->first();
            if (is_null($old_server)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_server = Servers::where('id', $m->server_id)->first();
            if (is_null($new_server)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $old_drive = Drives::where('slug', $drive_slug)
                ->where('server_id', $old_server->id)->first();
            if (is_null($old_drive)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_drive = Drives::where('server_id', $new_server->id)
                ->where('id', $m->drive_id)->first();
            if (is_null($new_drive)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $media = Media::where('slug', $m->media_slug)
                ->where('release_year', $m->media_release_year)
                ->where('server_id', $old_server->id)
                ->where('drive_id', $old_drive->id)->first();
            if (is_null($media)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            return view('media.move.step3', [
                'server'        => $old_server,
                'new_server'    => $new_server,
                'drive'         => $old_drive,
                'new_drive'     => $new_drive,
                'media'         => $media,
                'media_type'    => $m->media_type
            ]);
        }
    }

    public function storeMoveStep3(Request $request, $server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'destination_folder'     => 'required|numeric',
            'destination_drive'     => 'required|numeric',
            'destination_server'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to move media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $server = Servers::where('id', $request->destination_server)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $request->destination_drive)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('id', $request->destination_folder)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The destination folder you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $data = [
            'server_id'             => $server->id,
            'drive_id'              => $drive->id,
            'asset_id'              => $asset->id,
            'drive_slug'            => $drive_slug,
            'media_type'            => $media_type,
            'media_slug'            => $slug,
            'media_release_year'    => $release_year,
        ];

        return redirect()->route('media-move-step4', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])->withCookie(cookie('mediaMove', json_encode($data), 1440));
    }

    public function viewMoveStep4($server_slug, $drive_slug, $media_type ,$slug, $release_year)
    {
        if ($m = json_decode(Cookie::get('mediaMove'))) {

            $old_server = Servers::where('slug', $server_slug)->first();
            if (is_null($old_server)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_server = Servers::where('id', $m->server_id)->first();
            if (is_null($new_server)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $old_drive = Drives::where('slug', $drive_slug)
                ->where('server_id', $old_server->id)->first();
            if (is_null($old_drive)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_drive = Drives::where('server_id', $new_server->id)
                ->where('id', $m->drive_id)->first();
            if (is_null($new_drive)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $new_asset = DriveAssets::where('server_id', $new_server->id)
                ->where('drive_id', $new_drive->id)
                ->where('id', $m->asset_id)->first();
            if (is_null($new_asset)) {
                return redirect()->back()
                    ->with('message', 'The destination folder you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            $media = Media::where('slug', $m->media_slug)
                ->where('release_year', $m->media_release_year)
                ->where('server_id', $old_server->id)
                ->where('drive_id', $old_drive->id)->first();
            if (is_null($media)) {
                return redirect()->route('media-move-step2', [$server_slug, $drive_slug, $media_type ,$slug, $release_year])
                    ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                    ->with('type', 'alert-warning');
            }

            return view('media.move.step4', [
                'server'        => $old_server,
                'new_server'    => $new_server,
                'drive'         => $old_drive,
                'new_drive'     => $new_drive,
                'new_asset'     => $new_asset,
                'media'         => $media,
                'media_type'    => $m->media_type
            ]);
        }
    }

    public function storeMoveStep4(Request $request, $server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'destination_asset'     => 'required|numeric',
            'destination_drive'     => 'required|numeric',
            'destination_server'    => 'required|numeric',
            'media_id'              => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to move media! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $server = Servers::where('id', $request->destination_server)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('id', $request->destination_drive)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('id', $request->destination_asset)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The destination folder you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('id', $request->media_id)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media->server_id = $server->id;
        $media->drive_id = $drive->id;
        $media->drive_asset_id = $asset->id;
        $media->save();

        return redirect()->route('media', [$server->slug, $drive->slug])
            ->with('message', $media->media_title .'( ' . $media->release_year . ') has been successfully moved to new drive!')
            ->with('type', 'alert-success');
    }

    public function remove($server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('server_id', $server->id)
            ->where('slug', $drive_slug)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('slug', $slug)
            ->where('release_year', $release_year)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.remove', [
            'server'    => $server,
            'drive'     => $drive,
            'media'     => $media
        ]);
    }

    public function removeStore(Request $request, $server_slug, $drive_slug,$media_type ,$slug, $release_year)
    {
        $validator = Validator::make($request->all(), [
            'drive_id'          => 'required|numeric',
            'server_id'         => 'required|numeric',
            'media_id'          => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove media! have you filled in all the required fields ?')
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

        $media = Media::where('id', $request->media_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($media)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != $media->slug) {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }

        $media->delete();

        return redirect()->route('media', [$server->slug, $drive->slug])
            ->with('message', 'Media has been successfully removed!')
            ->with('type', 'alert-danger');
    }

    public function search($server_slug, $drive_slug)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        return view('media.search.search', [
            'server'    => $server,
            'drive'     => $drive
        ]);
    }

    public function viewAsset($server_slug, $drive_slug, $asset_id)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('id', $asset_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('drive_asset_id', $asset->id)
            ->orderBy('media_title', 'ASC')->paginate(10);

        return view('media.asset.asset', [
            'server'    => $server,
            'drive'     => $drive,
            'asset'     => $asset,
            'media'     => $media
        ]);
    }

    public function viewAssetFiltered($server_slug, $drive_slug, $asset_id, $state_asset_id)
    {
        $server = Servers::where('slug', $server_slug)->first();
        if (is_null($server)) {
            return redirect()->back()
                ->with('message', 'The server you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $drive = Drives::where('slug', $drive_slug)
            ->where('server_id', $server->id)->first();
        if (is_null($drive)) {
            return redirect()->back()
                ->with('message', 'The drive you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $asset = DriveAssets::where('id', $asset_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($asset)) {
            return redirect()->back()
                ->with('message', 'The asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $stateAsset = StateAssets::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('asset_id', $asset->id)
            ->where('id', $state_asset_id)->first();
        if (is_null($stateAsset)) {
            return redirect()->back()
                ->with('message', 'The media state asset you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $media = Media::where('server_id', $server->id)
            ->where('drive_id', $drive->id)
            ->where('drive_asset_id', $asset->id)
            ->where('state_asset_id', $stateAsset->id)
            ->orderBy('media_title', 'ASC')->paginate(10);

        return view('media.asset.filter.filter', [
            'server'    => $server,
            'drive'     => $drive,
            'asset'     => $asset,
            'media'     => $media
        ]);
    }
}
