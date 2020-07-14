@section('title')
    Drive Assets
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Drive Assets: {{ $drive->drive_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> Hard Drives</a></li>
            <li class="breadcrumb-item active"><i class="fad fa-books"></i> Drive Assets: {{ $drive->drive_name }}</li>
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
                        <h5 class="card-title text-black">Drive Assets &nbsp;&nbsp;&nbsp;<small class="text-green"><i class="fa fa-folder-open"></i> {{ $drive->server->network_path.$drive->drive_folder }}</small></h5>
                        <h6 class="card-subtitle">View / add asset folder(s) to the selected drive, which can then be used to add media into.</h6>
                    </div>
                    <div class="card-body">

                        <div class="float-right">
                            @can('addDriveAsset')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#addAsset" class="btn btn-primary"><i class="far fa-plus"></i> Add Drive Asset</a>
                                <p>&nbsp;</p>
                            @endcan
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Asset Name</th>
                                <th>Asset Folder</th>
                                <th>No. of Media</th>
                                <th>Created At</th>
                                <th style="width: 180px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($assets) == 0)
                                <tr>
                                    <td colspan="5"><div align="center"><i>There are currently no assets attached to this drive!</i></div></td>
                                </tr>
                            @else
                                @foreach ($assets as $asset)
                                    <tr>
                                        <td><a href="javascript:void(0);">{{ $asset->asset_name }}</a></td>
                                        <td>{{ $asset->asset_folder }}</td>
                                        <td><span class="badge badge-info">{{ count(\App\Media::where('server_id', $drive->server->id)->where('drive_id', $drive->id)->where('drive_asset_id', $asset->id)->get()) }}</span></td>
                                        <td>{{ \App\Timezone::getDate($asset->created_at->getTimestamp()) }}</td>
                                        <td>
                                                <span class="float-right">
                                                    @can('editDriveAsset')
                                                        &nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#editAsset_{{ $asset->id }}" class="btn btn-round btn-primary"><i class="fal fa-edit"></i></a>
                                                    @endcan
                                                    @can('removeDriveAsset')
                                                        <a href="{{ route('drive-assets-remove', [$drive->slug, $asset->id]) }}" class="btn btn-round btn-danger" id="removeAsset"><i class="far fa-trash-alt"></i></a>
                                                    @endcan
                                                </span>
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

    <!-- Start Add Asset Model -->
    <div class="modal fade" id="addAsset" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ route('drive-assets-store', $drive->slug) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Add Asset Folder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="form-group {{ $errors->first('asset_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Asset Name</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="asset_name" value="{{ old('asset_name') }}" required="" placeholder="Asset name..." />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the asset folder name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('asset_folder') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Asset Folder</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="asset_folder" value="{{ old('asset_folder') }}" required="" placeholder="/asset folder name..." />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the asset folder path.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Server Name</label>
                                    <div class="col-lg-9">
                                        {{ $drive->server->server_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Drive Name</label>
                                    <div class="col-lg-9">
                                        {{ $drive->drive_name }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Asset</button>
                        <input type="hidden" name="server_id" value="{{ $drive->server->id }}">
                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Add Asset Model -->

    <!-- Start Edit Asset Model -->
    @foreach ($assets as $asset)
        <div class="modal fade" id="editAsset_{{ $asset->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="form-horizontal" method="POST" action="{{ route('drive-assets-edit-store', $asset->id) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleLargeModalLabel">Edit Asset Folder</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group {{ $errors->first('asset_name') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Asset Name</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="asset_name" value="{{ $asset->asset_name }}" required="" placeholder="Asset name..." />
                                            <div class="help-block margin-bottom-none">
                                                <small>Please provide the asset folder name.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('asset_folder') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Asset Folder</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="asset_folder" value="{{ $asset->asset_folder }}" required="" placeholder="/asset folder name..." />
                                            <div class="help-block margin-bottom-none">
                                                <small>Please provide the asset folder path.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Server Name</label>
                                        <div class="col-lg-9">
                                            {{ $drive->server->server_name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Drive Name</label>
                                        <div class="col-lg-9">
                                            {{ $drive->drive_name }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Asset</button>
                            <input type="hidden" name="server_id" value="{{ $drive->server->id }}">
                            <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                            <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <!-- End Edit Asset Movel -->

@endsection
