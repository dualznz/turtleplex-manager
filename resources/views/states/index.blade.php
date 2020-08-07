@section('title')
    Media State Groups
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Media State Groups</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item active"><i class="fal fa-cabinet-filing"></i> Media State Groups</li>
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
                            <h5 class="card-title text-black">Media State Groups</h5>
                            <h6 class="card-subtitle">Add / view media state groups in which you can assign assets that can be used in various areas on the management portal.</h6>
                        </div>
                        <div class="pull-right">
                            @can('addServer')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#addStateGroup" class="btn btn-primary"><i class="far fa-plus"></i> Add State Group</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="20%">Group Name</th>
                                <th width="20%">Slug</th>
                                <th width="30%">Assets</th>
                                <th>Created At</th>
                                <th style="width: 190px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($groups) == 0)
                                <tr>
                                    <td colspan="6"><div align="center"><i>There are currently no state groups available!</i></div></td>
                                </tr>
                            @else
                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{ $group->id }}</td>
                                        <td><a href="javascript:void(0);">{{ $group->group_name }}</a></td>
                                        <td>{{ $group->slug }}</td>
                                        <td>
                                            <?php
                                            $arr = array();
                                            $a = \App\StateAssets::where('group_id', $group->id)
                                                ->orderBy('asset_name', 'ASC')->get();

                                            foreach ($a as $asset) {
                                                array_push($arr, \App\Helpers\AccentHelper::accent($asset->asset_name, $asset->text_color, $asset->background_color));
                                            }
                                            $sliced_assets = implode(' | ', $arr);
                                            ?>
                                            @if (count($a) == 0)
                                                <i>There are no assets available</i>
                                            @else
                                                {!! $sliced_assets !!}
                                            @endif
                                        </td>
                                        <td>{{ \App\Helpers\Timezone::getDate($group->created_at->getTimestamp()) }}</td>
                                        <td>
                                            @can ('viewStateAssets')
                                                <a href="{{ route('state-assets', $group->slug) }}" class="btn btn-round btn-info"><i class="fad fa-books"></i></a>
                                            @endcan
                                            @can('editStateGroup')
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#editStateGroup_{{ $group->state }}" class="btn btn-round btn-primary"><i class="fal fa-edit"></i></a>
                                            @endcan
                                            @can('removeStateGroup')
                                                <a href="{{ route('state-groups-remove', $group->slug) }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
                                            @endcan
                                            &nbsp;
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

    <!-- Start Add State Group -->
    <div class="modal fade" id="addStateGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ route('state-groups-store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">Add State Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="form-group {{ $errors->first('group_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-3 control-label label-right my-auto">Group Name</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required="" placeholder="State group name" />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the state group name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add State Group</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Add State Group -->

    <!-- Start Edit State Group -->
    @foreach ($groups as $group)
        <div class="modal fade" id="editStateGroup_{{ $group->state }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="form-horizontal" method="POST" action="{{ route('state-groups-edit-store', $group->slug) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleLargeModalLabel">Edit State Group</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group {{ $errors->first('group_name') ? 'has-error' : ''}}">
                                    <div class="row">
                                        <label class="col-lg-3 control-label label-right my-auto">Group Name</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="group_name" value="{{ $group->group_name }}" required="" placeholder="State group name" />
                                            <div class="help-block margin-bottom-none">
                                                <small>Please provide the state group name.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update State Group</button>
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <!-- End Edit State Group -->
@endsection
