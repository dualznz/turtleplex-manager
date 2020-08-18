@section('title')
    Ombi Users
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Ombi Users</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item active">Ombi Users</li>
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
                        <div class="pull-left">
                            <h5 class="card-title text-black">Ombi Users</h5>
                            <h6 class="card-subtitle">View / edit or delete imported ombi users which is used to incoming requests, issues and so forth</h6>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('ombi-users-manual-import') }}" class="btn btn-primary">Manual Import</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="pull-right">
                            <span class="badge badge-info">Total Users: {!! number_format(\App\OmbiUsers::orderBy('id', 'ASC')->count(), 0) !!}</span>
                        </div>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th width="30%">Username</th>
                                <th width="30%">Email Address</th>
                                <th>Last Updated</th>
                                <th style="width: 120px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($users) == 0)
                                <tr>
                                    <td colspan="4"><div align="center"><i>There are currently no ombi users available!</i></div></td>
                                </tr>
                            @else
                                @foreach ($users as $u)
                                    <tr>
                                        <td><a href="{{ config('services.ombi.domain') }}usermanagement/user/{{ $u->user_id }}" target="_blank">{{ $u->username }}</a></td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ \App\Helpers\Timezone::getDate($u->updated_at->getTimestamp()) }}</td>
                                        <td>
                                            <div class="pull-right">
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#removeAccount_{{ $u->user_id }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Row Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End XP Contentbar -->

    <!-- Start Remove Account Model -->
    @foreach ($users as $u)
        <div class="modal fade" id="removeAccount_{{ $u->user_id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="form-horizontal" method="POST" action="{{ route('ombi-users-remove') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleLargeModalLabel">Remove Ombi Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Username</label>
                                        <div class="col-lg-5">
                                            {{ $u->username }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Email Address</label>
                                        <div class="col-lg-5">
                                            {{ $u->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Confirmation</label>
                                        <div class="col-lg-8">
                                            <div align="center">
                                                <p>
                                                    <b>Warning:</b> please confirm that you wish to remove this ombi account,<br>
                                                    This operation cannot be reversed and any associated data <b>will</b> be removed!
                                                </p>
                                                <p style="font-size: 15px;">
                                                    To remove this user please type <b>I-AGREE</b> in the box below.
                                                </p>
                                                <input type="text" class="form-control col-md-5" name="confirmation" value="{{ old('confirmation') }}" placeholder="Confirm Code....">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Remove Account</button>
                            <input type="hidden" name="user_id" value="{{ $u->user_id }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <!-- End Remove Account Model -->
@endsection
