@section('title')
    Add Server
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Add Server</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('servers') }}"><i class="fal fa-server"></i> Servers</a></li>
            <li class="breadcrumb-item active"><i class="far fa-plus"></i> Add Server</li>
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
                        <h5 class="card-title text-black">Add Server</h5>
                        <h6 class="card-subtitle">Add a new server which will allow you to assign drives and so forth to the management portal.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('servers-store') }}">
                            @csrf

                            <div class="form-group {{ $errors->first('server_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="server_name" value="{{ old('server_name') }}" required="" placeholder="Server name..." />
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
                                            <input type="text" class="form-control" name="server_host" value="{{ old('server_host') }}" required="" placeholder="___.___.___.___" />
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
                                            <input type="text" class="form-control" name="network_path" value="{{ old('network_path') }}" required="" placeholder="/path/to/server..." />
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the network path to the server.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('servers') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Add Server</button>
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
