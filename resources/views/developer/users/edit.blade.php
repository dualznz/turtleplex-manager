@section('title')
    Edit User
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Edit User: {{ $u->username }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item"><a href="{{ route('developer-users') }}"></a><i class="far fa-users"></i> Users</li>
            <li class="breadcrumb-item active">Edit User</li>
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
                        <h5 class="card-title text-black">Edit User</h5>
                        <h6 class="card-subtitle">Edit an existing users account, set role / update password. anything that is needed to manage registered users.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="post" action="{{ route('developer-users-update', $u->id) }}">
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
                                        <input type="text" class="form-control" name="name" title="Name" value="{{ $u->username }}" required>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the users username.</small>
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
                                            <small>Please provide the users email address.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('role') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Role</label>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="role" title="Role">
                                            @foreach (\Spatie\Permission\Models\Role::all() as $r)
                                                <option value="{{ $r->name }}" {{ $u->hasRole($r->name) ? 'selected' : '' }}>{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('developer-users') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Edit {{ $u->username }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <p style="font-size: 16px;">Update Password</p>

                        <form class="form-horizontal" method="post" action="{{ route('developer-users-update-password', [$u->id]) }}">
                            @csrf

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
                                            <small>Please provide the new password.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <button class="btn btn-primary" type="submit">Update Password</button>
                                        <input type="hidden" name="user_id" value="{{ $u->id }}">
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
