<?php

namespace App\Http\Controllers;

use App\Drives;
use App\MediaImporter;
use App\Servers;
use Illuminate\Http\Request;

class ImportMediaController extends Controller
{
    /*
     * Permissions constructor
     */
    public function __construct()
    {
        $this->middleware('can:viewDriveMediaImporter', ['only' => 'index']);
    }

    // tester
    public function import()
    {
        foreach(file(public_path('im.txt')) as $line) {
            $a = str_replace(array('(', ')'), '', $line);
            $b = preg_replace( '/\r|\n/', '', $a);
            $c = preg_replace('/(19|20)[0-9][0-9]/', '', $b);
            $d = mb_substr($c, 0, -1);
            $e = preg_replace( '/\r|\n/', '', $d);
            if ($d != null) {
                $n = new MediaImporter();
                $n->server_id = 2;
                $n->drive_id = 2;
                $n->drive_asset_id = 1;
                $n->media_title = $e;
                $n->tmdb_media_type = 'movie';
                $n->save();
            }
        }
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
}
