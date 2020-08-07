<?php

namespace App\Http\Controllers;

use App\DriveAssets;
use App\Drives;
use App\Media;
use App\MediaImporter;
use App\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ImportMediaController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewDriveMediaImporter', ['only' => 'index']);
        $this->middleware('can:uploadDriveMediaImporter', ['only' => 'viewUploader', 'storeUploader']);
        $this->middleware('can:searchImportedMedia', ['only' => 'search']);
        $this->middleware('can:addImportedMediaResult', ['only' => 'viewInsert', 'storeInsert']);
        $this->middleware('can:removeImportedMedia', ['only' => 'remove', 'removeStore']);
    }

    public function index($server_slug, $drive_slug)
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

        $media = MediaImporter::where('server_id', $server->id)
            ->where('drive_id', $drive->id)->paginate(50);

        return view('media.importer.index', [
           'server' => $server,
           'drive'  => $drive,
           'media'  => $media
        ]);
    }

    public function viewUploader($server_slug, $drive_slug)
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

        return view('media.importer.uploader', [
           'server' => $server,
           'drive'  => $drive
        ]);
    }

    public function storeUploader(Request $request, $server_slug, $drive_slug)
    {
        $validator = Validator::make($request->all(), [
            'drive_assets'          => 'required',
            'tmdb_media_type'       => 'required',
            'location'              => 'required',
            'server_id'             => 'required|numeric',
            'drive_id'              => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to import media file! have you filled in all the required fields ?')
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

        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567891011121314151617181920212223242526';

        if ($request->file(['location']) != null) {
            $file = $request->file(['location']);
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();

                // define file types
                if ($extension == 'txt'){
                    $shuffled = str_shuffle($str);
                    $shuffled = substr($shuffled,1,24);

                    $fileName = $shuffled . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/static/media-import/', $fileName);
                } else {
                    return redirect()->back()
                        ->with('message', 'Failed to import media file due to incorrect file type, supported files: .txt')
                        ->with('type', 'alert-warning')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        } else {
            return redirect()->back()
                ->with('message', 'Something went very very very wrong....')
                ->with('type', 'alert-danger');
        }

        sleep(5);

        foreach(file(public_path().'/static/media-import/'.$fileName) as $line) {
            $a = str_replace(array('(', ')'), '', $line);
            $b = preg_replace( '/\r|\n/', '', $a);
            $c = preg_replace('/(19|20)[0-9][0-9]/', '', $b);
            $d = mb_substr($c, 0, -1);
            $e = preg_replace( '/\r|\n/', '', $d);
            if ($d != null) {
                $str1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567891011121314151617181920212223242526';

                $shuffled1 = str_shuffle($str1);
                $shuffled1 = substr($shuffled1,1,24);

                $n = new MediaImporter();
                $n->hash_id = $shuffled1;
                $n->server_id = $server->id;
                $n->drive_id = $drive->id;
                $n->drive_asset_id = $request->drive_assets;
                $n->media_title = $e;
                $n->tmdb_media_type = $request->tmdb_media_type;
                $n->save();
            }
        }

        return redirect()->route('media-importer', [$server->slug, $drive->slug])
            ->with('message', 'Media file has been successfully imported!')
            ->with('type', 'alert-success');
    }

    public function search($server_slug, $drive_slug, $tmdb_media_type, $hash_id)
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

        $search = MediaImporter::where('hash_id', $hash_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($search)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $searchResults = [];
        if ($search->tmdb_media_type == 'movie') {
            $searchResults = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.domain').'search/movie?query='.$search->media_title)
                ->json()['results'];
        } else if ($search->tmdb_media_type == 'tv') {
            $searchResults = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.domain').'search/tv?query='.$search->media_title)
                ->json()['results'];
        }

        return view('media.importer.results', [
            'server'            => $server,
            'drive'             => $drive,
            'search'            => $search,
            'tmdb_media_type'   => $tmdb_media_type,
            'searchResults'     => $searchResults
        ]);
    }

    public function viewInsert($server_slug, $drive_slug, $tmdb_media_type, $tmdb_id, $hash_id)
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

        $search = MediaImporter::where('hash_id', $hash_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($search)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $assets = DriveAssets::where('id', $search->drive_asset_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($assets)) {
            return redirect()->back()
                ->with('message', 'The drive asset you selected does not exist, or you do not have permissions to view it!')
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

        return view('media.importer.insert', [
            'server'                => $server,
            'drive'                 => $drive,
            'assets'                => $assets,
            'media_type'            => $tmdb_media_type,
            'stream'                => $stream,
            'media_state_group'     => env('STATE_MEDIA_ASSET_GROUP'),
            'search'                => $search
        ]);
    }

    public function storeInsert(Request $request, $server_slug, $drive_slug)
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
            'drive_id'              => 'required|numeric',
            'hash_id'               => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to add imported media! have you filled in all the required fields ?')
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

        $imported = MediaImporter::where('hash_id', $request->hash_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($imported)) {
            return redirect()->back()
                ->with('message', 'The media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $str1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567891011121314151617181920212223242526';

        $shuffled1 = str_shuffle($str1);
        $shuffled1 = substr($shuffled1,1,24);

        $s = new Media();
        $s->server_id = $server->id;
        $s->drive_id = $drive->id;
        $s->drive_asset_id = $request->drive_assets;
        $s->state_asset_id = $request->media_state;
        $s->hash_id = $shuffled1;
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

        // remove media import data
        $imported->delete();

        return redirect()->route('media-importer', [$server->slug, $drive->slug])
            ->with('message', $request->media_title . ' has been successfully added!')
            ->with('type', 'alert-success');
    }

    public function remove($server_slug, $drive_slug, $hash_id)
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

        $imported = MediaImporter::where('hash_id', $hash_id)
            ->where('server_id', $server->id)
            ->where('drive_id', $drive->id)->first();
        if (is_null($imported)) {
            return redirect()->back()
                ->with('message', 'The imported media you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        $imported->delete();

        return redirect()->route('media-importer', [$server->slug, $drive->slug])
            ->with('message', 'Imported media file has been successfully removed!')
            ->with('type', 'alert-danger');
    }
}
