@section('title')
    Edit Server
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Edit Server</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('servers') }}"><i class="fal fa-server"></i> Servers</a></li>
            <li class="breadcrumb-item active">Edit Server</li>
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
                        <h5 class="card-title text-black">Edit Server</h5>
                        <h6 class="card-subtitle">Edit existing server information that is used to mount drives to.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('servers-edit-store', $server->slug) }}">
                            @csrf

                            <div class="form-group {{ $errors->first('server_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="server_name" value="{{ $server->server_name }}" readonly />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the server name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('server_host') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Host/IP</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fal fa-ethernet"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="server_host" value="{{ $server->server_host }}" required="" placeholder="127.0.0.1" />
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the server hostname / ip address.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('network_path') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Network Path</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fal fa-folder"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="network_path" value="{{ $server->network_path }}" required="" placeholder="/path/to/server..." />
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the network path to the server.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Last Ping Status</label>
                                    <div class="col-lg-5">
                                        {!! $server->ping_status_detailed() !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('servers') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Edit Server</button>
                                        <input type="hidden" name="server_id" value="{{ $server->id }}">
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
