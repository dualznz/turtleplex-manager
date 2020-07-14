@section('title')
    Remove Drive
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove Drive</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> Hard Drives</a></li>
            <li class="breadcrumb-item active"><i class="far fa-trash-alt"></i> Remove Drive</li>
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
                        <h5 class="card-title text-black">Remove Drive</h5>
                        <h6 class="card-subtitle">Remove existing hard drive from management portal.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('drives-remove-store', $drive->slug) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive Name</label>
                                    <div class="col-lg-5">
                                        {{ $drive->drive_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Attached Server</label>
                                    <div class="col-lg-5">
                                        {{ $drive->server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive Folder</label>
                                    <div class="col-lg-5">
                                        {{ $drive->drive_folder }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Full Path</label>
                                    <div class="col-lg-5">
                                        {{ $drive->server->network_path.$drive->drive_folder }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">No. of Media</label>
                                    <div class="col-lg-5">
                                        <span class="badge badge-info">{{ count(\App\Media::where('server_id', $drive->server->id)->where('drive_id', $drive->id)->get()) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-8">
                                        <div align="center">
                                            <p>
                                                <b>Warning:</b> please confirm that you wish to remove this drive,<br>
                                                This operation cannot be reversed and any associated data <b>will</b> be removed!
                                            </p>
                                            <p style="font-size: 15px;">
                                                To remove this drive please type <b>{{ $drive->slug }}</b> in the box below.
                                            </p>
                                            <input type="text" class="form-control col-md-3" name="confirmation" value="{{ old('confirmation') }}" placeholder="Confirm Code....">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        @if (count($assets) > 0)
                                            <b>Warning:</b> there are assets assigned to this server <i class="fas fa-share"></i>&nbsp;&nbsp;<a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;<button class="btn btn-danger" type="submit" title="Action has been disabled, please remove or move all assets first!" disabled>Remove Drive</button>
                                        @else
                                            <a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;
                                            <button class="btn btn-danger" type="submit">Remove Drive</button>
                                        @endif
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <input type="hidden" name="server_id" value="{{ $drive->server->id }}">
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
