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
                                <th style="width: 180px;"></th>
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
                                        <td><span class="badge badge-primary">{{ count(\App\Drives::where('server_id', $server->id)->get()) }}</span></td>
                                        <td><span class="badge badge-info">{{ count(\App\Media::where('server_id', $server->id)->get()) }}</span></td>
                                        <td>{{ \App\Timezone::getDate($server->pinged_at->getTimestamp()) }}</td>
                                        <td>
                                                <span class="float-right">
                                                    <a class="btn btn-round btn-info" data-toggle="modal" data-target="#info_model_{{ $server->slug }}" id="viewInfo" style="color: white;"><i class="far fa-eye"></i></a>
                                                    @can('editServer')
                                                        <a href="{{ route('servers-edit', $server->slug) }}" class="btn btn-round btn-primary" id="editServer"><i class="fal fa-edit"></i></a>
                                                    @endcan
                                                    @can('removeServer')
                                                        <a href="{{ route('servers-remove', $server->slug) }}" class="btn btn-round btn-danger" id="removeServer"><i class="far fa-trash-alt"></i></a>
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

    @foreach ($servers as $server)
        <div class="modal fade" id="info_model_{{ $server->slug }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Server Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-md-12">

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-8">
                                        {{ $server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">Server Host/IP</label>
                                    <div class="col-lg-8">
                                        {{ $server->server_host }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">Network Path</label>
                                    <div class="col-lg-8">
                                        {{ $server->network_path }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">Last Ping Status</label>
                                    <div class="col-lg-8">
                                        {!! $server->ping_status_detailed() !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">No. of Drives</label>
                                    <div class="col-lg-8">
                                        <span class="badge badge-primary">{{ count(\App\Drives::where('server_id', $server->id)->get()) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-4 control-label label-right my-auto">No. of Media</label>
                                    <div class="col-lg-8">
                                        <span class="badge badge-info">{{ count(\App\Media::where('server_id', $server->id)->get()) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <p>&nbsp;</p>

                        <div class="col-md-12">
                            <b>Attached Drives</b>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="70%">Drive Path</th>
                                    <th>No. of Media</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (\App\Drives::where('server_id', $server->id)->count() == 0)
                                    <tr>
                                        <td colspan="2"><div align="center"><i>There are currently no drives available!</i></div></td>
                                    </tr>
                                @else
                                    <?php
                                    $drives = \App\Drives::where('server_id', $server->id)->get();
                                    ?>
                                    @foreach($drives as $drive)
                                        <tr>
                                            <td>{{ $server->network_path.$drive->drive_folder }}</td>
                                            <td><span class="badge badge-info">{{ count(\App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->get()) }}</span> </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
