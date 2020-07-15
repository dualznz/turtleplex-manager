@section('title')
    Assets
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Assets: {{ $group->group_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('state-groups') }}"><i class="fal fa-cabinet-filing"></i> Media State Groups</a></li>
            <li class="breadcrumb-item active"><i class="fad fa-books"></i> Assets: {{ $group->group_name }}</li>
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
                        <h5 class="card-title text-black">Assets: {{ $group->group_name }}</h5>
                        <h6 class="card-subtitle">View / add assets to the selected state group which will contain the color spectrum and scopes within the media group.</h6>
                    </div>
                    <div class="card-body">

                        <div class="float-right">
                            @can('addStateAsset')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#addStateAsset" class="btn btn-primary"><i class="far fa-plus"></i> Add Asset</a>
                                <p>&nbsp;</p>
                            @endcan
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="30%">Asset Name</th>
                                <th width="30%">Accent</th>
                                <th>Created At</th>
                                <th style="width: 150px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($assets) == 0)
                                <tr>
                                    <td colspan="5"><div align="center"><i>There are currently no assets attached to this state group!</i></div></td>
                                </tr>
                            @else
                                @foreach ($assets as $asset)
                                    <tr>
                                        <td>{{ $asset->id }}</td>
                                        <td><a href="javascript:void(0);">{{ $asset->asset_name }}</a></td>
                                        <td>{!! \App\Helpers\AccentHelper::accent($asset->asset_name, $asset->text_color, $asset->background_color) !!}</td>
                                        <td>{{ \App\Timezone::getDate($asset->created_at->getTimestamp()) }}</td>
                                        <td>
                                                <span class="float-right">
                                                    @can('editStateAsset')
                                                        &nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#editStateAsset_{{ $asset->id }}" class="btn btn-round btn-primary"><i class="fal fa-edit"></i></a>
                                                    @endcan
                                                    @can('removeStateAsset')
                                                        <a href="{{ route('state-assets-remove', [$group->slug, $asset->id]) }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
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

    <!-- Start Add Asset -->
    <div class="modal fade" id="addStateAsset" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ route('state-assets-store', [$group->slug]) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Add Asset</h5>
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
                                            <small>Please provide the asset state name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">State Group</label>
                                    <div class="col-lg-9">
                                        {{ $group->group_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('text_color') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Text Color</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="text_color" value="{{ old('text_color') }}" required="" placeholder="#ABC123" />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the asset text color, <a href="https://htmlcolorcodes.com/" id="accentColor" target="_blank">choose html color here</a>.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('background_color') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Background Color</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="background_color" value="{{ old('background_color') }}" required="" placeholder="#ABC123" />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the asset background color, <a href="https://htmlcolorcodes.com/" id="accentColor" target="_blank">choose html color here</a>.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Asset</button>
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Add Asset -->

    <!-- Start Edit Asset -->
    @foreach ($assets as $asset)
        <div class="modal fade" id="editStateAsset_{{ $asset->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="form-horizontal" method="POST" action="{{ route('state-assets-edit-store', [$group->id, $asset->id]) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleLargeModalLabel">Edit Asset</h5>
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
                                                <small>Please provide the asset state name.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">State Group</label>
                                        <div class="col-lg-9">
                                            {{ $group->group_name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('text_color') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Text Color</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="text_color" value="{{ $asset->text_color }}" required="" placeholder="#ABC123" />
                                            <div class="help-block margin-bottom-none">
                                                <small>Please provide the asset text color, <a href="https://htmlcolorcodes.com/" id="accentColor" target="_blank">choose html color here</a>.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('background_color') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Background Color</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="background_color" value="{{ $asset->background_color }}" required="" placeholder="#ABC123" />
                                            <div class="help-block margin-bottom-none">
                                                <small>Please provide the asset background color, <a href="https://htmlcolorcodes.com/" id="accentColor" target="_blank">choose html color here</a>.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit Asset</button>
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <!-- End Edit Asset -->

@endsection
