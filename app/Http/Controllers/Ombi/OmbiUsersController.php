<?php

namespace App\Http\Controllers\Ombi;

use App\Http\Controllers\Controller;
use App\Jobs\ManualOmbiUsersImport;
use App\Jobs\RemoveOmbiUser;
use App\OmbiUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class OmbiUsersController extends Controller
{
    public function index()
    {
        return view('developer.ombi.index', [
            'users' => OmbiUsers::orderBy('username', 'ASC')->get()
        ]);
    }

    public function importer()
    {
        ManualOmbiUsersImport::dispatch();

        return redirect()->back()
            ->with('message', 'Manual ombi users import job has been dispatched, the information will update shortly!')
            ->with('type', 'alert-success');
    }

    public function removeAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'confirmation'  => 'required',
            'user_id'      => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Failed to remove ombi user, have you filled in all the required fields ?')
                ->with('type', 'alert-danger')
                ->withErrors($validator)
                ->withInput();
        }

        $user = OmbiUsers::where('user_id', $request->user_id)->first();
        if (is_null($user)) {
            return redirect()->route('ombi-users')
                ->with('message', 'The ombi user you selected does not exist, or you do not have permissions to view it!')
                ->with('type', 'alert-warning');
        }

        if ($request->confirmation != 'I-AGREE') {
            return redirect()->back()
                ->with('message', 'You have entered the incorrect confirmation code, please try again!')
                ->with('type', 'alert-warning')
                ->withErrors($validator)
                ->withInput();
        }


    }
}
