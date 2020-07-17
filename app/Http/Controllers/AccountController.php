<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index', [
           'u'   => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update your account! have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $u = User::where('id', Auth::user()->id)->first();

        $u->username = $request->username;
        $u->email = $request->email;
        if ($u->isDirty()) $u->save();


        return redirect()->route('account-settings')
            ->with('success', 'Successfully updated you account information!');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'      => ['required', new MatchOldPassword()],
            'new_password'          => 'required',
            'new_confirm_password'  => 'same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update password, have you entered the new password correctly?')
                ->with('type', 'alert-danger')
                ->withErrors($validator);
        }

        $u = User::where('id', Auth::user()->id)->first();
        if (is_null($u)) {
            return redirect()->route('account-settings')
                ->with('danger', 'Unable to find user account!');
        }
        $u->password = Hash::make($request->new_password);
        if ($u->isDirty()) $u->save();

        return redirect()->route('account-settings')
            ->with('success', 'Successfully updated you password!');
    }

    public function removeAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove your account! have you filled in all the required fields?')
                ->with('type', 'alert-danger')
                ->withErrors($validator);
        }

        if ($request->confirmation != 'DELETE') return redirect()->back()->with('message', 'Failed to remove your account! you have entered the incorrect confirmation text')->with('type', 'alert-warning');

        $u = User::where('id', Auth::user()->id)->first();
        if (is_null($u)) {
            return redirect()->route('account-settings')
                ->with('danger', 'Unable to find user account!');
        }

        $i = Invite::where('claimed_by', $u->id)->first();
        $i->delete();

        $u->delete();
        Auth::logout();

        return redirect()->route('index');
    }
}
