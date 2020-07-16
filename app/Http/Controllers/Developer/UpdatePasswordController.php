<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePasswordController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password'          => 'required',
            'new_confirm_password'  => 'same:new_password',
            'user_id'               => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to update password, have you entered the new password correctly?')
                ->with('type', 'alert-danger')
                ->withErrors($validator);
        }

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('developer-users-edit', $user->id)
            ->with('success', 'Updated users password');
    }
}
