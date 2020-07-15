@section('title')
    Issue Updater
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Issue Updater</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-issue') }}"><i class="fal fa-plug"></i> Submission Issues</a></li>
            <li class="breadcrumb-item active">Issue Updater</li>
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
                        <h5 class="card-title text-black">Issue Updater</h5>
                        <h6 class="card-subtitle">Update existing media submission issues to add them into the database manually via <a href="https://www.postman.com/" target="_blank">Postman</a>.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('media-issues-updater-step1-store', [$issue->id]) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server</label>
                                    <div class="col-lg-5">
                                        {{ $issue->server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive</label>
                                    <div class="col-lg-5">
                                        {{ $issue->drive->drive_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Media Folder</label>
                                    <div class="col-lg-5">
                                        {{ $issue->asset->asset_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Current Status</label>
                                    <div class="col-lg-5">
                                        {!! \App\Helpers\AccentHelper::accent($issue->stateAsset->asset_name, $issue->stateAsset->text_color, $issue->stateAsset->background_color) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Tmdb Media URL</label>
                                    <div class="col-lg-5">
                                        <a href="{{ $issue->tmdb_url }}" target="_blank" id="viewTMDBUrl">{{ $issue->tmdb_url }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('tmdb_id') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Tmdb Media ID</label>
                                    <div class="col-lg-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fal fa-database"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="tmdb_id" value="{{ old('tmdb_id') }}" required="" placeholder="123456" />
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the tmdb id number from <b>Postman</b>.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('tmdb_media_type') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Tmdb Media Type</label>
                                    <div class="col-lg-5">
                                        <div class="i-checks">
                                            <label> <input type="radio" name="tmdb_media_type" value="" {{ $issue->tmdb_media_type == 0 ? 'checked=checked' : '' }} disabled> <i></i>&nbsp;&nbsp;none&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label> <input type="radio" name="tmdb_media_type" value="movie" {{ $issue->tmdb_media_type == 1 ? 'checked=checked' : '' }}> <i></i>&nbsp;&nbsp;movie&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label> <input type="radio" name="tmdb_media_type" value="tv" {{ $issue->tmdb_media_type == 2 ? 'checked=checked' : '' }}> <i></i>&nbsp;&nbsp;tv&nbsp;&nbsp;</label>
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the media type from <b>Postman</b></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('media-issue') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Continue&nbsp; <i class="far fa-chevron-double-right"></i></button>
                                        <input type="hidden" name="server_id" value="{{ $issue->server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $issue->drive->id }}">
                                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
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
