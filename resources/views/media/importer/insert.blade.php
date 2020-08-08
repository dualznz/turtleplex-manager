@section('title')
    Add Media
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Add Media: {{ $media_type == 'movie' ? $stream['title'] : $stream['name'] }} ({{ $media_type == 'movie' ? substr($stream['release_date'], 0, strpos($stream['release_date'], '-')) : substr($stream['first_air_date'], 0, strpos($stream['first_air_date'], '-'))}})</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-importer', [$server->slug, $drive->slug]) }}">Media Importer</a></li>
            <li class="breadcrumb-item active">Add Media: {{ $media_type == 'movie' ? $stream['title'] : $stream['name'] }} ({{ $media_type == 'movie' ? substr($stream['release_date'], 0, strpos($stream['release_date'], '-')) : substr($stream['first_air_date'], 0, strpos($stream['first_air_date'], '-'))}})</li>
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
                        <h5 class="card-title text-black">Add Media: {{ $media_type == 'movie' ? $stream['title'] : $stream['name'] }} ({{ $media_type == 'movie' ? substr($stream['release_date'], 0, strpos($stream['release_date'], '-')) : substr($stream['first_air_date'], 0, strpos($stream['first_air_date'], '-'))}})</h5>
                        <h6 class="card-subtitle">Add selected media to the database which can be used for searching and updating at a later date if needed.</h6>
                    </div>
                    <div class="card-body">

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

                        <form class="form-horizontal" method="POST" action="{{ route('media-importer-insert-store', [$server->id, $drive->id, $media_type, $stream['id']]) }}">
                            @csrf

                            <div class="jumbotron" style="background-image:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $backdrop_path }}'); background-size: cover; background-repeat: no-repeat; color: black;">
                                <div class="col-md-12" style="color: white;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if (!is_null($poster_92_path))
                                                <img src="https://image.tmdb.org/t/p/w92{{ $poster_92_path }}" class="img-thumbnail">
                                            @else
                                                <img src="/static/assets/images/noposter_92.jpg" class="img-shadow">
                                            @endif
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

                            <div class="form-group {{ $errors->first('drive_assets') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Media Folder</label>
                                    <div class="col-lg-5">
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

                            <div class="form-group {{ $errors->first('media_state') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Media State</label>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="media_state" id="media_state" required>
                                            <option selected disabled>Please select media state group...</option>
                                            @foreach (\App\StateAssets::where('group_id', $media_state_group)->orderBy('asset_name', 'ASC')->orderBy('asset_name', 'ASC')->get() as $s)
                                                <option value="{{ $s->id }}">{{ $s->asset_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select which state this media is in.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('media-importer-insert-store', [$server->slug, $drive->slug]) }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Add Media</button>
                                        <input type="hidden" name="tmdb_id" value="{{ $tmdb_id }}">
                                        <input type="hidden" name="media_type" value="{{ $media_type }}">
                                        <input type="hidden" name="media_title" value="{{ $media_title }}">
                                        <input type="hidden" name="release_year" value="{{ $release_year }}">
                                        <input type="hidden" name="vote_average" value="{{ $vote_average }}">
                                        <input type="hidden" name="poster_92_path" value="{{ $poster_92_path }}">
                                        <input type="hidden" name="poster_154_path" value="{{ $poster_154_path }}">
                                        <input type="hidden" name="backdrop_path" value="{{ $backdrop_path }}">
                                        <input type="hidden" name="overview" value="{{ $overview }}">
                                        <input type="hidden" name="server_id" value="{{ $server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <input type="hidden" name="hash_id" value="{{ $search->hash_id }}">
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
