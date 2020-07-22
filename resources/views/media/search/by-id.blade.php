@section('title')
    Add Media By TMDB ID
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Add Media By TMDB ID</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item"><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item active">Add Media By TMDB ID</li>
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
                        <h5 class="card-title text-black">Add Media By TMDB ID &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                        <h6 class="card-subtitle">Search for new media by adding its The Movie DB ID.</h6>
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
                            @if ($result->media_type == 'movie')
                                <tr>
                                    <td>
                                        <img src="{{ $result->poster_92_path }}" class="img-thumbnail">
                                    </td>
                                    <td>
                                        <a href="https://www.themoviedb.org/movie/{{ $result->id }}" target="_blank"><span style="font-size: 22px;">{{ $result->media_title }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #888888;">({{ $result->release_year }})</span></a><br>
                                        <i class="fas fa-camera-movie"></i> <b>Type:</b> Movie &nbsp;&nbsp;
                                        <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result->vote_average }} / 10<br>
                                        <br>
                                        {{ $result->overview }}
                                    </td>
                                    <td style="vertical-align: middle;" align="center">
                                        @if (count(\App\Media::where('tmdb_id', $result->id)->get()) == 0)
                                            @can ('insertDriveMedia')
                                                <a href="{{ route('media-add-insert', [$server->slug, $drive->slug, $result->media_type, $result->id]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                            @endcan
                                        @else
                                            <?php
                                            $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->whereLike('media_title', $result->medeia_title)->first();
                                            ?>
                                            <a href="{{ route('media-view', [$s->server->slug, $s->drive->slug, $s->media_type, $s->slug, $s->release_year]) }}" class="btn btn-outline-secondary">Already Exists</a>
                                        @endif
                                    </td>
                                </tr>
                            @elseif ($result->media_type == 'tv')
                                <tr>
                                    <td>
                                        <img src="{{ $result->poster_92_path }}" class="img-thumbnail">
                                    </td>
                                    <td>
                                        <a href="https://www.themoviedb.org/tv/{{ $result->id }}" target="_blank"><span style="font-size: 22px;">{{ $result->media_title }}</span> <span style="color: #888888;">({{ $result->release_year }})</span></a><br>
                                        <i class="fas fa-tv-retro"></i> <b>Type:</b> TV Show &nbsp;&nbsp;
                                        <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result->vote_average }} / 10<br>
                                        <br>
                                        {{ $result->overview }}
                                    </td>
                                    <td style="vertical-align: middle;" align="center">
                                        @if (count(\App\Media::where('tmdb_id', $result->id)->get()) == 0)
                                            @can ('insertDriveMedia')
                                                <a href="{{ route('media-add-insert', [$server->slug, $drive->slug, $result->media_type, $result->id]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                            @endcan
                                        @else
                                            <?php
                                            $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->whereLike('media_title', $result->media_title)->first();
                                            ?>
                                            <a href="{{ route('media-view', [$s->server->slug, $s->drive->slug, $s->media_type, $s->slug, $s->release_year]) }}" class="btn btn-outline-secondary">Already Exists</a>
                                        @endif
                                    </td>
                                </tr>
                            @else

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
