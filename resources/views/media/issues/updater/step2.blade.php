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

                        <form class="form-horizontal" method="POST" action="{{ route('media-issues-updater-step2-store', [$issue->id]) }}">
                            @csrf

                            <?php
                            // asset declaration
                            $tmdb_id = $stream['id'];
                            $media_title = '';
                            $release_year = null;
                            $vote_average = '';
                            $poster_92_path = '';
                            $poster_154_path = '';
                            $backdrop_path = '';
                            $overview = '';
                            $media_icon = '';

                            switch ($media_type) {
                                case 'movie':
                                    $media_title = $stream['title'];
                                    $release_year = substr($stream['release_date'], 0, strpos($stream['release_date'], '-'));
                                    $vote_average = $stream['vote_average'];
                                    $poster_92_path = 'https://image.tmdb.org/t/p/w92'.$stream['poster_path'];
                                    $poster_154_path = 'https://image.tmdb.org/t/p/w154'.$stream['poster_path'];
                                    $backdrop_path = 'https://image.tmdb.org/t/p/original/'.$stream['backdrop_path'];
                                    $overview = $stream['overview'];
                                    $media_icon = 'fas fa-camera-movie';
                                    break;
                                case 'tv':
                                    $media_title = $stream['name'];
                                    $release_year = substr($stream['first_air_date'], 0, strpos($stream['first_air_date'], '-'));
                                    $vote_average = $stream['vote_average'];
                                    $poster_92_path = 'https://image.tmdb.org/t/p/w92'.$stream['poster_path'];
                                    $poster_154_path = 'https://image.tmdb.org/t/p/w154'.$stream['poster_path'];
                                    $backdrop_path = 'https://image.tmdb.org/t/p/original/'.$stream['backdrop_path'];
                                    $overview = $stream['overview'];
                                    $media_icon = 'fas fa-tv-retro';
                                    break;
                            }
                            ?>

                            <div class="jumbotron" style="background-image:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $backdrop_path }}'); background-size: cover; background-repeat: no-repeat; color: black;">
                                <div class="col-md-12" style="color: white;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="{{ $poster_154_path }}" class="img-shadow">
                                        </div>
                                        <div class="col-md-9">
                                            <span style="font-size: 26px;">{{ $media_title }} ({{ $release_year }})</span><br>
                                            <span style="font-size: 15px;">
                                                <i class="{{ $media_icon }}"></i> <b>Type:</b> {{ $media_type == 'movie' ? 'Movie' : 'TV Show' }} &nbsp;&nbsp;
                                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $vote_average }} / 10<br>
                                            </span>
                                            <br>
                                            <span style="font-size: 15px;">{{ $overview }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                            <div class="form-group {{ $errors->first('state_asset') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Status</label>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="state_asset" id="state_asset" required>
                                            <option selected disabled>Please select media status...</option>
                                            @foreach (\App\StateAssets::where('group_id', env('STATE_MEDIA_ISSUES_ASSET_GROUP'))->orderBy('asset_name', 'ASC')->get() as $a)
                                                <option value="{{ $a->id }}" {{ $a->id == $issue->asset_id ? 'selected' : '' }}>{{ $a->asset_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select which status this submission issue is in.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 control-label"></div>
                                    <div class="col-lg-5">
                                        <a href="{{ route('media-issues-updater-step1', [$issue->id]) }}" class="btn btn-success"><i class="far fa-chevron-double-left"></i>&nbsp; Go Back</a>&nbsp;&nbsp;
                                        <a class="btn btn-warning" href="{{ route('media-issue') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Complete Issue&nbsp; <i class="far fa-chevron-double-right"></i></button>
                                        <input type="hidden" name="server_id" value="{{ $issue->server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $issue->drive->id }}">
                                        <input type="hidden" name="asset_id" value="{{ $issue->asset->id }}">
                                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                        <input type="hidden" name="tmdb_id" value="{{ $tmdb_id }}">
                                        <input type="hidden" name="media_type" value="{{ $media_type }}">
                                        <input type="hidden" name="media_title" value="{{ $media_title }}">
                                        <input type="hidden" name="release_year" value="{{ $release_year }}">
                                        <input type="hidden" name="vote_average" value="{{ $vote_average }}">
                                        <input type="hidden" name="poster_92_path" value="{{ $poster_92_path }}">
                                        <input type="hidden" name="poster_154_path" value="{{ $poster_154_path }}">
                                        <input type="hidden" name="backdrop_path" value="{{ $backdrop_path }}">
                                        <input type="hidden" name="overview" value="{{ $overview }}">
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
