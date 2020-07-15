@section('title')
    Add Media
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Add Media</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item active"><i class="far fa-plus"></i> Add Media</li>
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
                        <h5 class="card-title text-black">Add Media &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                        <h6 class="card-subtitle">
                            Search for new media in realtime as you type in the search criteria.
                            <div class="pull-right">
                                @can ('sendMediaIssue')
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#sendSubmission"><i class="far fa-paper-plane"></i>&nbsp; Send Submission Issue</a>
                                @endcan
                            </div>
                        </h6>
                    </div>
                    <div class="card-body">

                        <livewire:add-media-search  :server="$server"   :drive="$drive">

                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Row Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End XP Contentbar -->

    <!-- Start Media Submission Issue -->
    <div class="modal fade" id="sendSubmission" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ route('media-issue-store', [$server->slug, $drive->slug]) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Send Submission Issue</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="form-group {{ $errors->first('tmdb_url') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">The Movie DB URL</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="tmdb_url" value="{{ old('tmdb_url') }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            <small>Visit <a href="https://www.themoviedb.org/" target="_blank">https://www.themoviedb.org</a> and search for the media then copy the address.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('drive_assets') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Media Folder</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="drive_assets" id="drive_assets" required>
                                            <option disabled selected>Please select media folder...</option>
                                            @foreach (\App\DriveAssets::where('server_id', $server->id)->where('drive_id', $drive->id)->orderBy('asset_name', 'ASC')->get() as $a)
                                                <option value="{{ $a->id }}">{{ $a->asset_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select which media asset this will go into.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Issue</button>
                        <input type="hidden" name="server_id" value="{{ $server->id }}">
                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Media Submission Issue -->
@endsection
