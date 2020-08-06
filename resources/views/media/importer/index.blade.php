@section('title')
    Media Importer
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Media Importer</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item active">Media Importer</li>
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
                        <h5 class="card-title text-black">Media Importer &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                        <h6 class="card-subtitle">
                            Import media from a <b>text</b> file & search for media results.
                            <div class="pull-right">
                                @can ('uploadDriveMediaImporter')
                                    <a href="{{ route('media-importer-uploader', [$server->slug, $drive->slug]) }}" class="btn btn-primary"><i class="far fa-upload"></i>&nbsp; Import File</a>
                                @endcan
                            </div>
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="pull-right">
                            <span class="badge badge-info">Total Records: {!! number_format(\App\MediaImporter::where('server_id', $server->id)->where('drive_id', $drive->id)->count(), 0) !!}</span>
                        </div>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th width="60%">Media Title</th>
                                <th>Media Folder</th>
                                <th style="width: 170px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if (count($media) == 0)
                                    <tr>
                                        <td colspan="3"><div align="center"><i>There are currently no imported media available.</i></div></td>
                                    </tr>
                                @else
                                    @foreach ($media as $i)
                                        <tr>
                                            <td>{{ $i->media_title }}</td>
                                            <td>{{ $i->asset->asset_name }}</td>
                                            <td>
                                                <div class="pull-right">
                                                    @can ('searchImportedMedia')
                                                        <a href="" class="btn btn-round btn-success"><i class="fal fa-search-plus"></i></a>
                                                    @endcan
                                                    @can ('removeImportedMedia')
                                                        <a href="" class="btn btn-round btn-danger"><i class="fal fa-trash-alt"></i></a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="col-lg-12">&nbsp;</div>

                        <div style="display: flex; justify-content: center; align-items: center;">
                            {{ $media->links() }}
                        </div>

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
