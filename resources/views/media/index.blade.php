@section('title')
    Media
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Media: {{ $drive->drive_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item active"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</li>
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
                            <h5 class="card-title text-black">Media: {{ $drive->drive_name }} &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                            <h6 class="card-subtitle">
                                View / add media to selected drive which allows for backups of all media location in-case of a hard drive failure.
                            </h6>
                        </div>
                        <div class="pull-right">
                            @can ('viewDriveMediaImporter')<a href="{{ route('media-importer', [$server->slug, $drive->slug]) }}" class="btn btn-success"><i class="far fa-file-import"></i> Media Importer</a>@endcan
                            <a href="{{ route('media-add', [$server->slug, $drive->slug]) }}" class="btn btn-primary"><i class="far fa-plus"></i> Add New Media</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="col-md-12">
                            <div align="center">
                                @foreach (\App\DriveAssets::where('drive_id', $drive->id)->orderBy('asset_name', 'ASC')->get() as $asset)
                                    <a href="{{ route('media-asset', [$server->slug, $drive->slug, $asset->id]) }}" class="btn btn-lg btn-info"><i class="far fa-camera-movie"></i>&nbsp; {{ $asset->asset_name }}&nbsp;&nbsp;<b>({{ count(\App\Media::where('server_id', $asset->server_id)->where('drive_id', $asset->drive_id)->where('drive_asset_id', $asset->id)->get()) }})</b></a>&nbsp;&nbsp;
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12">&nbsp;</div>

                        @can ('searchDriveMedia')
                            <div class="col-md-12">
                                <div align="center">
                                    <a href="{{ route('media-search', [$server->slug, $drive->slug]) }}" class="btn btn-lg btn-success" style="width: 800px;"><b><i class="far fa-search"></i> Search For Media</b></a>
                                </div>
                            </div>

                            <div class="col-md-12">&nbsp;</div>
                        @endcan

                        <div class="col-lg-12">
                            <span style="font-size: 17px;">Recently Added Media</span>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="10%">&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th style="width: 200px;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($media) == 0)
                                    <tr>
                                        <td colspan="3"><div align="center"><i>There are no recently added media available!</i></div></td>
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
                </div>
                <!-- End Card -->
            </div>
            <!-- End Row Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End XP Contentbar -->
@endsection
