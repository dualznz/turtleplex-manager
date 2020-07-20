@section('title')
    Users
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Users</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item active"><i class="far fa-users"></i> Users</li>
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
                        <h5 class="card-title text-black">Users</h5>
                        <h6 class="card-subtitle">User accounts that have been registered to the management portal.</h6>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="30%">Username</th>
                                <th>Role</th>
                                <th width="17%">Created At</th>
                                <th width="17%">Last Updated</th>
                                <th style="width: 120px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $u->id }}</td>
                                    <td><a href="javascript:void(0);">{{ $u->username }}</a></td>
                                    <td>{{ $u->roles()->pluck('name')[0] }}</td>
                                    <td>{{ \App\Helpers\Timezone::getDate($u->created_at->getTimestamp()) }}</td>
                                    <td>{{ \App\Helpers\Timezone::getDate($u->updated_at->getTimestamp()) }}</td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="{{ route('developer-users-edit', $u->id) }}" class="btn btn-round btn-info"><i class="far fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
@endsection
