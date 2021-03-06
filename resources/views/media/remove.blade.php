@section('title')
    Remove Media
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Viewing Media: {{ $media->media_title }} ({{ $media->release_year }})</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><i class="fal fa-photo-video"></i> Media</li>
            <li class="breadcrumb-item "><a href="{{ route('media', [$server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> {{ $drive->drive_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-view', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}"></a> Viewing Media: {{ $media->media_title }} ({{ $media->release_year }})</li>
            <li class="breadcrumb-item active">Remove Media</li>
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
                        <h5 class="card-title text-black">Remove Media</h5>
                        <h6 class="card-subtitle">Remove selected media information from the database.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('media-remove-store', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}">
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

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Server</label>
                                    <div class="col-lg-5">
                                        {{ $server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Attached Drive</label>
                                    <div class="col-lg-5">
                                        {{ $drive->drive_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Asset Folder</label>
                                    <div class="col-lg-5">
                                        {{ $media->asset->asset_folder }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Full Path Location</label>
                                    <div class="col-lg-5">
                                        <span class="text-green"><i class="far fa-folder"></i>&nbsp; {{ $server->network_path.$drive->drive_folder.$media->asset->asset_folder.'/'.$media->media_title.' ('.$media->release_year.')' }}</span>
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
                                                To remove this server please type <b>{{ $media->slug }}</b> in the box below.
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
                                        <a href="{{ route('media-view', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-danger" type="submit">Remove Media</button>
                                        <input type="hidden" name="server_id" value="{{ $server->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
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
