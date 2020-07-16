@section('title')
    Remove Issue
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove Issue</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-issue') }}"></a><i class="fal fa-plug"></i> Submission Issues</li>
            <li class="breadcrumb-item active">Remove Issue</li>
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
                        <h5 class="card-title text-black">Remove Issue</h5>
                        <h6 class="card-subtitle">Remove media submission issue if it is a duplicate or is invalid.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('media-issues-remove-store', [$issue->id]) }}">
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
                                    <label class="col-lg-2 control-label label-right my-auto">Folder Path</label>
                                    <div class="col-lg-5">
                                        <span class="text-green"><i class="far fa-folder"></i>&nbsp;{{ $issue->server->network_path.$issue->drive->drive_folder.$issue->asset->asset_folder }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Tmdb URL:</label>
                                    <div class="col-lg-5">
                                        <a href="{{ $issue->tmdb_url }}" target="_blank">{{ $issue->tmdb_url }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Current Status:</label>
                                    <div class="col-lg-5">
                                        {!! \App\Helpers\AccentHelper::accent($issue->stateAsset->asset_name, $issue->stateAsset->text_color, $issue->stateAsset->background_color) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-8">
                                        <div align="center">
                                            <p>
                                                <b>Warning:</b> please confirm that you wish to remove this media item,<br>
                                                This operation cannot be reversed and any associated data <b>will</b> be removed!
                                            </p>
                                            <p style="font-size: 15px;">
                                                To remove this server please type <b>I-AGREE</b> in the box below.
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
                                        <a href="{{ route('media-issue') }}" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-danger" type="submit">Remove Issue</button>
                                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                        <input type="hidden" name="server_id" value="{{ $issue->server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $issue->drive->id}}">
                                        <input type="hidden" name="asset_id" value="{{ $issue->asset->id }}">
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
