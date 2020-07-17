@section('title')
    Account Settings
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Account Settings</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Account Settings</li>
        </ol>
    </div>
    <!-- End XP Breadcrumbbar -->
    <!-- Start XP Contentbar -->
    <div class="xp-contentbar">
        <!-- Start Include Alerts -->
    @include('layouts.alerts')
    <!-- End Inclue Alerts -->
        <!-- Start Row -->
        <div class="row">
            <!-- Start XP Col -->
            <div class="col-lg-12">
                <!-- Start Card -->
                <div class="card m-b-30">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-black">Account Settings</h5>
                        <h6 class="card-subtitle">Update your account information and password information.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="post" action="{{ route('account-settings-update') }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Avatar</label>
                                    <div class="col-lg-5">
                                        <img src="{{ $u->avatar() }}" alt="user-profile" class="rounded-circle">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('username') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Username</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="username" title="username" value="{{ $u->username }}" required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide your username.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('email') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Email</label>
                                    <div class="col-lg-5">
                                        <input type="email" class="form-control" name="email" title="Email" value="{{ $u->email }}" required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide your email address.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <button class="btn btn-primary" type="submit">Update Account</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <p style="font-size: 16px;">Update Password</p>

                        <form class="form-horizontal" method="post" action="{{ route('account-settings-password') }}">
                            @csrf

                            <div class="form-group {{ $errors->first('current_password') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Current Password</label>
                                    <div class="col-lg-5">
                                        <input type="password" class="form-control" name="current_password" placeholder="Current Password..." required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide your current password.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('new_password') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">New Password</label>
                                    <div class="col-lg-5">
                                        <input type="password" class="form-control" name="new_password" placeholder="New Password..." required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the new password.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('new_confirm_password') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirm New Password</label>
                                    <div class="col-lg-5">
                                        <input type="password" class="form-control" name="new_confirm_password" placeholder="Confirm New Password..." required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please confirm the new password.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <button class="btn btn-primary" type="submit">Update Password</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <p style="font-size: 16px;">Delete Account</p>

                        <form class="form-horizontal" method="post" action="{{ route('account-settings-remove') }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <b>Please Note:</b> Destroying your account will remove the ability for them to login into the management portal and thus you will have to be re-invited in order to access the management portal again.<br>
                                        To proceed with your account being deleted please type <b>DELETE</b> into the box below.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="confirmation" placeholder="Please enter confirmation" required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please confirm your account being deleted.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <button class="btn btn-danger" type="submit"><i class="far fa-trash"></i> Delete Account</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Row Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End XP Contentbar -->
@endsection
