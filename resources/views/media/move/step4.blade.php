@section('title')
    Move Media
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Move Media</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item"><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-view', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}"></a> Viewing Media: {{ $media->media_title }} ({{ $media->release_year }})</li>
            <li class="breadcrumb-item active">Move Media</li>
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
                        <h5 class="card-title text-black">Move Media: {{ $media->media_title }} ({{ $media->release_year }})</h5>
                        <h6 class="card-subtitle">Move media from an existing location to a new destination.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('media-move-step4-store', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}">
                            @csrf

                            <div class="jumbotron" style="background-image:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $media->backdrop_path }}'); background-size: cover; background-repeat: no-repeat; color: black;">
                                <div class="col-md-12" style="color: white;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="{{ $media->poster_154_path }}" class="img-thumbnail">
                                        </div>
                                        <div class="col-md-9">
                                            <span style="font-size: 26px;">{{ $media->media_title }} ({{ $media->release_year }})</span><br>
                                            <span style="font-size: 15px;">
                                                <i class="{{ $media->media_type == 'movie' ? 'fas fa-camera-movie' : 'fas fa-tv-retro' }}"></i> <b>Type:</b> {{ $media->media_type == 'movie' ? 'Movie' : 'TV Show' }} &nbsp;&nbsp;
                                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $media->vote_average }} / 10<br>
                                            </span>
                                            <br>
                                            <span style="font-size: 15px;">{{ $media->overview }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span style="font-size: 16px;">Progress:</span><br>
                            <div class="form-group progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-info" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">&nbsp;</label>
                                    <div class="col-lg-7">
                                        Please confirm that the following below details are correct, before completing this move.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Destination Server</label>
                                    <div class="col-lg-5">
                                        {{ $new_server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Destination Drive</label>
                                    <div class="col-lg-5">
                                        {{ $new_drive->drive_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Destination Drive</label>
                                    <div class="col-lg-5">
                                        {{ $new_asset->asset_folder }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Full New Path Location</label>
                                    <div class="col-lg-5">
                                        <span class="text-green"><i class="far fa-folder"></i>&nbsp; {{ $new_drive->server->network_path.$new_drive->drive_folder.$new_asset->asset_folder.'/'.$media->media_title.' ('.$media->release_year.')' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 control-label"></div>
                                    <div class="col-lg-5">
                                        <a href="{{ route('media-move-step3', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}" class="btn btn-success"><i class="far fa-chevron-double-left"></i>&nbsp; Go Back</a>&nbsp;&nbsp;
                                        <a href="{{ route('media-view', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;
                                        <button class="btn btn-primary" type="submit">Move Media&nbsp; <i class="far fa-chevron-double-right"></i></button>
                                        <input type="hidden" name="destination_server" value="{{ $new_server->id }}">
                                        <input type="hidden" name="destination_drive" value="{{ $new_drive->id }}">
                                        <input type="hidden" name="destination_asset" value="{{ $new_asset->id }}">
                                        <input type="hidden" name="media_id" value="{{ $media->id }}">
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
