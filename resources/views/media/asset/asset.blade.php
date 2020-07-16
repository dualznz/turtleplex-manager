@section('title')
    Media List
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Media List: {{ $asset->asset_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item"><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item active">Media List: {{ $asset->asset_name }}</li>
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
                        <h5 class="card-title text-black">Media List &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder.$asset->asset_folder }}</small></h5>
                        <h6 class="card-subtitle">View media contained within the selected asset folder.</h6>
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
                            @if (count($media) == 0)
                                <tr>
                                    <td colspan="3"><div align="center"><i>There are currently no <b>{{ $asset->asset_name }}</b> available in <b>{{ $drive->drive_name.$asset->asset_folder }}</b> !</i></div></td>
                                </tr>
                            @else
                                @foreach ($media as $m)
                                    <tr>
                                        <td><img src="{{ $m->poster_92_path }}" class="img-thumbnail"></td>
                                        <td>
                                            <a href="https://www.themoviedb.org/movie/{{ $m->tmdb_id }}" target="_blank"><span style="font-size: 22px;">{{ $m->media_title }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #888888;">({{ $m->release_year }})</span></a><br>
                                            <i class="fas fa-video"></i> <b>Type:</b> {{ $m->asset->asset_name }} &nbsp;&nbsp;
                                            <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $m->vote_average }} / 10 &nbsp;&nbsp;
                                            {!! \App\Helpers\AccentHelper::accent($m->stateAsset->asset_name, $m->stateAsset->text_color, $m->stateAsset->background_color) !!} &nbsp;&nbsp;
                                            <span class="badge" style="background-color: #E5A00D; color: black;"><i class="far fa-folder"></i> {{ $m->server->network_path.$m->drive->drive_folder.$m->asset->asset_folder.'/'.$m->media_title.' ('.$m->release_year.')' }}</span>
                                            <br>
                                            <br>
                                            {{ $m->overview }}
                                        </td>
                                        <td style="vertical-align: middle;" align="center">
                                            <a href="{{ route('media-view', [$server->slug, $drive->slug, $m->media_type, $m->slug, $m->release_year]) }}" class="btn btn-sm btn-default" id="viewMedia"><i class="far fa-eye"></i> View Media</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>

                    <div class="col-lg-12">&nbsp;</div>

                    <div style="margin: 0 auto;">
                        {{ $media->links() }}
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
