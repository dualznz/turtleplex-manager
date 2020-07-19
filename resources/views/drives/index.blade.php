@section('title')
    Hard Drives
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Hard Drives</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item active"><i class="fal fa-hdd"></i> Hard Drives</li>
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
                        <h5 class="card-title text-black">Hard Drives</h5>
                        <h6 class="card-subtitle">Hard drives that are attached to servers which allows media to be added to them via assets.</h6>
                    </div>
                    <div class="card-body">

                        <div class="float-right">
                            @can('addServer')
                                <a href="{{ route('drives-add') }}" class="btn btn-primary"><i class="far fa-plus"></i> Add Hard Drive</a>
                                <p>&nbsp;</p>
                            @endcan
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th width="15%">Drive Name</th>
                                <th width="15%">Server Name</th>
                                <th width="30%">Assets</th>
                                <th width="10%">No. of Media</th>
                                <th>Created At</th>
                                <th style="width: 190px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($drives) == 0)
                                <tr>
                                    <td colspan="6"><div align="center"><i>There are currently no hard drives available!</i></div></td>
                                </tr>
                            @else
                                @foreach ($drives as $drive)
                                    <tr>
                                        <td><a href="javascript:void(0);">{{ $drive->drive_name }}</a></td>
                                        <td>{{ $drive->server->server_name }}</td>
                                        <td>
                                            <?php
                                            $arr = array();
                                            $a = \App\DriveAssets::where('server_id', $drive->server->id)
                                                ->where('drive_id', $drive->id)
                                                ->orderBy('asset_name', 'ASC')->get();
                                            foreach ($a as $asset) {
                                                array_push($arr, $asset->asset_name);
                                            }
                                            $sliced_assets = implode(', ', $arr);
                                            ?>
                                            @if (count($a) == 0)
                                                <i>There are no assets available</i>
                                            @else
                                                {{ $sliced_assets }}
                                            @endif
                                            <br><small>{{ $drive->server->network_path.$drive->drive_folder }}</small>
                                        </td>
                                        <td><span class="badge badge-info">{{ count(\App\Media::where('server_id', $drive->server->id)->where('drive_id', $drive->id)->get()) }}</span></td>
                                        <td>{{ \App\Helpers\Timezone::getDate($drive->created_at->getTimestamp()) }}</td>
                                        <td>
                                                <span class="float-right">
                                                    @can ('viewDriveAssets')
                                                        <a href="{{ route('drive-assets', $drive->slug) }}" class="btn btn-round btn-info"><i class="fad fa-books"></i></a>
                                                    @endcan
                                                    @can('editDrive')
                                                        <a href="{{ route('drives-edit', $drive->slug) }}" class="btn btn-round btn-primary"><i class="fal fa-edit"></i></a>
                                                    @endcan
                                                    @can('removeDrive')
                                                        <a href="{{ route('drives-remove', $drive->slug) }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
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
@endsection
