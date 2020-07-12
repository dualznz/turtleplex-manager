<?php

namespace App\Http\Controllers\Developer;

use App\Invite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvitesController extends Controller
{
    public function index()
    {
        return view('developer.invites.index', [
            'invites' => Invite::orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function create()
    {
        $i = new Invite();
        $i->token = md5($this->generateRandomString());
        $i->made_by = auth()->user()->id;
        $i->save();

        return view('developer.invites.create', [
            'i' => $i
        ]);
    }

    public function destroy($id, Request $request)
    {
        $i = Invite::find($id);
        if (is_null($i)) {
            return redirect()->route('developer-invites')
                ->with('danger', 'Unable to find invite');
        }

        if (!is_null($i->claimed_by)) {
            return redirect()->route('developer-invites')
                ->with('warning', 'Unable to delete invite ');
        }

        $i->delete();

        return redirect()->route('developer-invites')
            ->with('success', 'Invite removed');
    }

    private function generateRandomString($length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}