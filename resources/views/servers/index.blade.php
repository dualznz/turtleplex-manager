@section('title')
    Servers
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Servers</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item active"><i class="fal fa-server"></i> Servers</li>
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
                        <h5 class="card-title text-black">Servers</h5>
                        <h6 class="card-subtitle">Add / view servers that have been added to the management portal.</h6>
                    </div>
                    <div class="card-body">

                        <div class="float-right">
                            @can('addServer')
                                <a href="{{ route('servers-add') }}" class="btn btn-primary"><i class="far fa-plus"></i> Add Server</a>
                                <p>&nbsp;</p>
                            @endcan
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Server Name</th>
                                <th>No. of Drives</th>
                                <th>No. of Media</th>
                                <th>Last Pinged</th>
                                <th style="width: 150px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($count_servers == 0)
                                <tr>
                                    <td colspan="7"><div align="center"><i>There are currently no servers available!</i></div></td>
                                </tr>
                            @else
                                @foreach($servers as $server)
                                    <tr>
                                        <td>{!! $server->ping_status() !!}</td>
                                        <td>{{ $server->server_name }}</td>
                                        <td><span class="label label-primary">{{ count(\App\Drives::where('server_id', $server->id)->get()) }}</span></td>
                                        <td><span class="label label-info">{{ count(\App\Media::where('server_id', $server->id)->get()) }}</span></td>
                                        <td>{{ \App\Timezone::getDate($server->pinged_at->getTimestamp()) }}</td>
                                        <td>
                                                <span class="float-right">
                                                    <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_model_{{ $server->slug }}" id="viewInfo" style="color: white;"><i class="far fa-eye"></i></a>
                                                    @can('editServer')
                                                        &nbsp;&nbsp;<a href="{{ route('servers-edit', $server->slug) }}" class="btn btn-sm btn-primary" id="editServer"><i class="fal fa-edit"></i></a>
                                                    @endcan
                                                    @can('removeServer')
                                                        &nbsp;&nbsp;<a href="{{ route('servers-remove', $server->slug) }}" class="btn btn-sm btn-danger" id="removeServer"><i class="far fa-trash-alt"></i></a>
                                                    @endcan
                                                </span>
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
