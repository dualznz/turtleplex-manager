@section('title')
    Import File
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Import File</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-importer', [$server->slug, $drive->slug]) }}">Media Importer</a></li>
            <li class="breadcrumb-item active">Import File</li>
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
                        <h5 class="card-title text-black">Import File &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                        <h6 class="card-subtitle">Import a <b>text</b> file which contains multiple media items which will allow you to then search the system for each item.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('media-importer-uploader-store', [$server->slug, $drive->slug]) }}">
                            @csrf

                            <div class="form-group {{ $errors->first('drive_assets') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Media Folder</label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="drive_assets" id="drive_assets" required>
                                            <option selected disabled>Please select media media folder...</option>
                                            @foreach (\App\DriveAssets::where('server_id', $server->id)->where('drive_id', $drive->id)->orderBy('asset_name', 'ASC')->get() as $a)
                                                <option value="{{ $a->id }}">{{ $a->asset_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select which asset folder this media is in.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('tmdb_media_type') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Tmdb Media Type</label>
                                    <div class="col-lg-9">
                                        <div class="i-checks">
                                            <label> <input type="radio" name="tmdb_media_type" value="" disabled> <i></i>&nbsp;&nbsp;none&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label> <input type="radio" name="tmdb_media_type" value="movie"> <i></i>&nbsp;&nbsp;movie&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label> <input type="radio" name="tmdb_media_type" value="tv"> <i></i>&nbsp;&nbsp;tv&nbsp;&nbsp;</label>
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Visit <a href="https://www.themoviedb.org/" target="_blank">https://www.themoviedb.org</a> and search for the media then copy the media type.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('location') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Media File</label>
                                    <div class="col-lg-6">
                                        <input type="file" name="location">
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the media <b>text</b> file, <span class="text-green">Supported formats: <b>.txt</b></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info"><b>Please note:</b> once you click <b>Upload File</b> this could take a while to process depending on the amount of items that have to be processed!</div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('media-importer', [$server->slug, $drive->slug]) }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Upload File</button>
                                        <input type="hidden" name="server_id" value="{{ $server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
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
