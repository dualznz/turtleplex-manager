<?php

namespace App\Http\Controllers\Developer;

use App\User;
use App\Invite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        return view('developer.users.index', [
            'users' => User::all()
        ]);
    }

    public function edit($id)
    {
        $u = User::find($id);
        if (is_null($u)) {
            return redirect()->route('developer-users')
                ->with('danger', 'Unable to find user');
        }

        return view('developer.users.edit', [
            'u' => $u
        ]);
    }

    public function update($id, Request $request)
    {
        $u = User::find($id);
        if (is_null($u)) {
            return redirect()->route('developer-users')
                ->with('danger', 'Unable to find user');
        }

        $this->validate($request, [
            'username'          => 'required|string|max:255',
            'email'             => 'required|string|email|max:255',
            'role'              => 'required|string'
        ]);

        $u->username = $request->username;
        $u->email = $request->email;
        if ($u->isDirty()) $u->save();

        $u->syncRoles($request->role);

        return redirect()->route('developer-users-edit', $u->id)
            ->with('success', 'Updated user');
    }

    public function destroy($id, Request $request)
    {
        $u = User::find($id);
        if (is_null($u)) {
            return redirect()->route('developer-users')
                ->with('danger', 'Unable to find user');
        }

        $i = Invite::where('claimed_by', $u->id)->first();

        $i->delete();

        $u->delete();

        return redirect()->route('developer-users')
            ->with('success', 'User has been deleted');
    }
}
