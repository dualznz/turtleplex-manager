@section('title')
    Viewing Media
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
            <li class="breadcrumb-item active">Viewing Media: {{ $media->media_title }} ({{ $media->release_year }})</li>
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
                        <h5 class="card-title text-black">Viewing Media: {{ $media->media_title }} ({{ $media->release_year }})</h5>
                        <h6 class="card-subtitle">View selected media information and various available options.</h6>
                    </div>
                    <div class="card-body">

                        <div class="jumbotron" style="background-image:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $media->backdrop_path }}'); background-size: cover; background-repeat: no-repeat; color: black;">
                            <div class="col-md-12" style="color: white;">
                                <div class="row">
                                    <div class="col-md-2">
                                        @if ($media->poster_154_path != 'https://image.tmdb.org/t/p/w154')
                                            <img src="{{ $media->poster_154_path }}" class="img-thumbnail">
                                        @else
                                            <img src="/static/assets/images/noposter_154.jpg" class="img-thumbnail">
                                        @endif
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
                                <label class="col-lg-2 control-label label-right my-auto">Server Name</label>
                                <div class="col-lg-5">
                                    {{ $server->server_name }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label label-right my-auto">Drive Name</label>
                                <div class="col-lg-5">
                                    {{ $drive->drive_name }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label label-right my-auto">Media Folder</label>
                                <div class="col-lg-5">
                                    {{ $media->asset->asset_name }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label label-right my-auto">Full Media Path</label>
                                <div class="col-lg-5">
                                    <span class="text-green"><i class="fa fa-folder-open"></i> {{ $media->server->network_path.$media->drive->drive_folder.$media->asset->asset_folder.'/'.$media->media_title.' ('.$media->release_year.')' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label label-right my-auto">Media State</label>
                                <div class="col-lg-5">
                                    {!! \App\Helpers\AccentHelper::accent($media->stateAsset->asset_name, $media->stateAsset->text_color, $media->stateAsset->background_color) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-lg-2 control-label label-right my-auto">Media Options</label>
                                <div class="col-lg-8">
                                    @can ('editDriveMedia')
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMedia"><i class="fal fa-edit"></i> Edit Media</a>&nbsp;&nbsp;
                                    @endcan
                                    @can ('moveDriveMedia')
                                        <a href="{{ route('media-move-step1', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}" class="btn btn-sm btn-success"><i class="fal fa-compress-alt"></i> Move Media</a>&nbsp;&nbsp;
                                    @endcan
                                    @can ('removeDriveMedia')
                                        <a href="{{ route('media-remove', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}" class="btn btn-sm btn-danger"><i class="fal fa-trash-alt"></i> Remove Media</a>
                                    @endcan
                                </div>
                            </div>
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

    <!-- Start Edit Media -->
    <div class="modal fade" id="editMedia" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ route('media-view-store', [$server->slug, $drive->slug, $media->media_type, $media->slug, $media->release_year]) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Edit Media</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="form-group {{ $errors->first('drive_assets') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Media Folder</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="drive_assets" id="drive_assets" required>
                                            @foreach (\App\DriveAssets::where('server_id', $server->id)->where('drive_id', $drive->id)->orderBy('asset_name', 'ASC')->get() as $a)
                                                <option value="{{ $a->id }}" {{ $a->id == $media->asset->id ? 'selected' : '' }}>{{ $a->asset_name }}</option>
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
                                    <label class="col-lg-3 control-label label-right my-auto">Media State</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="media_state" id="media_state" required>
                                            @foreach (\App\StateAssets::where('group_id', $media_state_group)->orderBy('asset_name', 'ASC')->get() as $s)
                                                <option value="{{ $s->id }}" {{ $s->id == $media->state_asset_id ? 'selected' : '' }}>{{ $s->asset_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select which state this media is in.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Media</button>
                        <input type="hidden" name="server_id" value="{{ $server->id }}">
                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                        <input type="hidden" name="media_id" value="{{ $media->id }}">
                    </div>
                </div>
            </form>
        </div>
    <!-- End Edit Media -->
@endsection
