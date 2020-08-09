@section('title')
    Media Results
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Media Results: {{ $search->media_title }}</h4>
        <ol class="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
                <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('media-importer', [$server->slug, $drive->slug]) }}">Media Importer</a></li>
                <li class="breadcrumb-item active">Media Results</li>
            </ol>
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
                        <div class="pull-left">
                            <h5 class="card-title text-black">Media Results &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder.$search->asset->asset_folder }}</small></h5>
                            <h6 class="card-subtitle">
                                Return results from imported media file.
                            </h6>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('media-importer', [$server->slug, $drive->slug]) }}" class="btn btn-primary">Back To Media Importer</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th width="10%">&nbsp;</th>
                                <th>&nbsp;</th>
                                <th style="width: 180px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($searchResults == null)
                                <tr>
                                    <td colspan="3">
                                        <div align="center" style="font-size: 18px;">
                                            <br>
                                            Unable to find any results with this criteria
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($searchResults as $result)
                                    @if ($tmdb_media_type == 'movie')
                                        <tr>
                                            <td>
                                                @if (!is_null($result['poster_path']))
                                                    <img src="https://image.tmdb.org/t/p/w92{{ $result['poster_path'] }}" class="img-thumbnail">
                                                @else
                                                    <img src="/static/assets/images/noposter_92.jpg" class="img-shadow">
                                                @endif
                                            </td>
                                            <td>
                                                <a href="https://www.themoviedb.org/movie/{{ $result['id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['title'] }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #888888;">({!!  substr($result['release_date'], 0, strpos($result['release_date'], '-')) !!})</span></a><br>
                                                <i class="fas fa-camera-movie"></i> <b>Type:</b> Movie &nbsp;&nbsp;
                                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10<br>
                                                <br>
                                                {{ $result['overview'] }}
                                            </td>
                                            <td style="vertical-align: middle;" align="center">
                                                @if (count(\App\Media::where('media_title', $result['title'])->get()) == 0)
                                                    @can ('addImportedMediaResult')
                                                        <a href="{{ route('media-importer-insert', [$server->slug, $drive->slug, $tmdb_media_type, $result['id'], $search->hash_id]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                                    @endcan
                                                @else
                                                    <?php
                                                        $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->where('media_title', $result['title'])->first();
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-outline-secondary">Already Exists</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @elseif ($tmdb_media_type == 'tv')
                                        <tr>
                                            <td>
                                                @if (!is_null($result['poster_path']))
                                                    <img src="https://image.tmdb.org/t/p/w92{{ $result['poster_path'] }}" class="img-thumbnail">
                                                @else
                                                    <img src="/static/assets/images/noposter_92.jpg" class="img-shadow">
                                                @endif
                                            </td>
                                            <td>
                                                <a href="https://www.themoviedb.org/tv/{{ $result['id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['name'] }}</span> <span style="color: #888888;">({!! substr($result['first_air_date'], 0, strpos($result['first_air_date'], '-')) !!})</span></a><br>
                                                <i class="fas fa-tv-retro"></i> <b>Type:</b> TV Show &nbsp;&nbsp;
                                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10<br>
                                                <br>
                                                {{ $result['overview'] }}
                                            </td>
                                            <td style="vertical-align: middle;" align="center">
                                                @if (count(\App\Media::where('media_title', $result['name'])->get()) == 0)
                                                    @can ('addImportedMediaResult')
                                                        <a href="{{ route('media-importer-insert', [$server->slug, $drive->slug, $tmdb_media_type, $result['id'], $search->hash_id]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                                    @endcan
                                                @else
                                                    <?php
                                                    $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->where('media_title', $result['name'])->first();
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-outline-secondary">Already Exists</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>

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
