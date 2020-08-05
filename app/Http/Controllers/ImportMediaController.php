<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportMediaController extends Controller
{
    public function import()
    {
        $output = [];
        $p = '';
        foreach(file(public_path('im.txt')) as $line) {
            $p = preg_replace( '/\r|\n/', '', $line);
            $p =  preg_replace('/(19|20)[0-9][0-9]/', '', $line);
            array_push($output, preg_replace( '/\r|\n/', '', $p));
        }
        ddd($output);
    }
}
