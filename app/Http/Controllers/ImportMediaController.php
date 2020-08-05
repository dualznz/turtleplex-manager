<?php

namespace App\Http\Controllers;

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
        $output = [];
        foreach(file(public_path('im.txt')) as $line) {
            $a = str_replace(array('(', ')'), '', $line);
            $b = preg_replace( '/\r|\n/', '', $a);
            $c = preg_replace('/(19|20)[0-9][0-9]/', '', $b);
            $d = mb_substr($c, 0, -1);
            if ($d != null) {
                // if string is not empty push it to array
                array_push($output, preg_replace( '/\r|\n/', '', $d));
            }
        }
        ddd($output);
    }

    public function index($server_slug, $drive_slug)
    {

    }
}
