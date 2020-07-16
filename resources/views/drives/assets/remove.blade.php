@section('title')
    Remove Asset Folder
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove Asset Folder: {{ $asset->asset_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> Hard Drives</a></li>
            <li class="breadcrumb-item"><a href="{{ route('drive-assets', [$drive->slug]) }}"></a><i class="fad fa-books"></i> Drive Assets: {{ $drive->drive_name }}</li>
            <li class="breadcrumb-item active">Remove Asset Folder</li>
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
                        <h5 class="card-title text-black">Remove Asset Folder</h5>
                        <h6 class="card-subtitle">Remove existing asset folder from the selected drive.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('drive-assets-remove-store', [$drive->slug, $asset->id]) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Asset Name</label>
                                    <div class="col-lg-5">
                                        {{ $asset->asset_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Asset Folder</label>
                                    <div class="col-lg-5">
                                        {{ $asset->asset_folder }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-5">
                                        {{ $drive->server->server_name }}
                                    </div>
                                </div>
                            </div>

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
                                    <label class="col-lg-2 control-label label-right my-auto">No. of Media</label>
                                    <div class="col-lg-5">
                                        <span class="badge badge-info">{{ count(\App\Media::where('server_id', $drive->server->id)->where('drive_id', $drive->id)->where('drive_asset_id', $asset->id)->get()) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-8">
                                        <div align="center">
                                            <p>
                                                <b>Warning:</b> please confirm that you wish to remove this asset,<br>
                                                This operation cannot be reversed and any associated data <b>will</b> be removed!
                                            </p>
                                            <p style="font-size: 15px;">
                                                To remove this asset please type <b>{{ $asset->asset_name }}</b> in the box below.
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
                                        <a class="btn btn-warning" href="{{ route('drive-assets', [$drive->slug]) }}">Cancel</a> &nbsp;
                                        <button class="btn btn-danger" type="submit">Remove Asset</button>
                                        <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <input type="hidden" name="server_id" value="{{ $drive->server->id }}">
                                    </div>
                                </div>
                            </div>


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
