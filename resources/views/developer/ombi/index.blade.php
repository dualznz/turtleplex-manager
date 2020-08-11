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
                                <th>Alias</th>
                                <th width="17%">Email Address</th>
                                <th width="17%">Last Updated</th>
                                <th style="width: 120px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($users) == 0)
                                <tr>
                                    <td colspan="5"><div align="center"><i>There are currently no imported ombi users!</i></div></td>
                                </tr>
                            @else
                                @foreach ($users as $u)
                                    <tr>
                                        <td><a href="javascript:void(0);">{{ $u->username }}</a></td>
                                        <td>{{ $u->alias }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ \App\Helpers\Timezone::getDate($u->updated_at->getTimestamp()) }}</td>
                                        <td>
                                            <div class="pull-right">

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
@endsection
