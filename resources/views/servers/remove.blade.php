@section('title')
    Remove Server
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove Server</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('servers') }}"><i class="fal fa-server"></i> Servers</a></li>
            <li class="breadcrumb-item active"><i class="far fa-trash-alt"></i> Remove Server</li>
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
                        <h5 class="card-title text-black">Remove Server</h5>
                        <h6 class="card-subtitle">Remove existing sever from the servers list.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('servers-remove-store', $server->slug) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-5">
                                        {{ $server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Host/IP</label>
                                    <div class="col-lg-5">
                                        {{ $server->server_host }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Network Path</label>
                                    <div class="col-lg-5">
                                        {{ $server->network_path }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">No. of Drives</label>
                                    <div class="col-lg-5">
                                        <span class="badge badge-primary">{!! count($drives) !!}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">No. of Media</label>
                                    <div class="col-lg-5">
                                        <span class="badge badge-info">{{ count(\App\Media::where('server_id', $server->id)->get()) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-8">
                                        <div align="center">
                                            <p>
                                                <b>Warning:</b> please confirm that you wish to remove this server,<br>
                                                This operation cannot be reversed and any associated data <b>will</b> be removed!
                                            </p>
                                            <p style="font-size: 15px;">
                                                To remove this server please type <b>{{ $server->slug }}</b> in the box below.
                                            </p>
                                            <input type="text" class="form-control col-md-3" name="confirmation" value="{{ old('confirmation') }}" placeholder="Confirm Code...." required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        @if (count($drives) > 0)
                                            <b>Warning:</b> there are network drives assigned to this server <i class="fas fa-share"></i>&nbsp;&nbsp;<a class="btn btn-warning" href="{{ route('servers') }}">Cancel</a> &nbsp;<button class="btn btn-danger" type="submit" title="Action has been disabled, please remove or move all drives & media first!" disabled>Remove Server</button>
                                        @else
                                            <a class="btn btn-warning" href="{{ route('servers') }}">Cancel</a> &nbsp;
                                            <button class="btn btn-danger" type="submit">Remove Server</button>
                                        @endif
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
