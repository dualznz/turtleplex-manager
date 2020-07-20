@section('title')
    Submission Issues
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Submission Issues</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><i class="fal fa-plug"></i> Submission Issues</li>
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
                        <h5 class="card-title text-black">Media Submission Issues</h5>
                        <h6 class="card-subtitle">Assess media submission issues and manually update them via <a href="https://www.postman.com/" target="_blank">Postman</a>.</h6>
                    </div>
                    <div class="card-body">

                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="control-label my-auto"><b>Filter Status</b></span>&nbsp;&nbsp;&nbsp;
                                @foreach (\App\StateAssets::where('group_id', env('STATE_MEDIA_ISSUES_ASSET_GROUP'))->get() as $sa)
                                    <a href="{{ route('media-issues-sorting', [$sa->id]) }}"  class="btn btn-lg btn-success"><i class="far fa-filter"></i>&nbsp; {{ $sa->asset_name }}&nbsp;&nbsp;<b>({{ count(\App\MediaIssues::where('state_asset_id', $sa->id)->get()) }})</b></a>&nbsp;&nbsp;
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th width="6%">Tmdb ID</th>
                                <th>Tmdb Media Type</th>
                                <th width="47%">Tmdb URL</th>
                                <th width="13%">Status</th>
                                <th>Created At</th>
                                <th style="width: 170px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($issues) == 0)
                                <tr>
                                    <td colspan="6"><div align="center"><i>There are currently no submission issues available!</i></div></td>
                                </tr>
                            @else
                                @foreach ($issues as $issue)
                                    <tr>
                                        <td>{{ $issue->tmdb_id == 0 ? 'N/A' : $issue->tmdb_id }}</td>
                                        <td>{{ $issue->tmdb_media_type }}</td>
                                        <td><a href="{{ $issue->tmdb_url }}" target="_blank" id="viewTMDBUrl">{{ $issue->tmdb_url }}</a></td>
                                        <td>{!! \App\Helpers\AccentHelper::accent($issue->stateAsset->asset_name, $issue->stateAsset->text_color, $issue->stateAsset->background_color) !!}</td>
                                        <td>{{ \App\Helpers\Timezone::getDate($issue->created_at->getTimestamp()) }}</td>
                                        <td>
                                            <span class="float-right">
                                                @can ('updateMediaIssue')
                                                    <a href="{{ route('media-issues-updater-step1', [$issue->id]) }}" class="btn btn-round btn-info"><i class="far fa-comment-alt-edit"></i></a>
                                                @endcan
                                                @can ('removeMediaIssue')
                                                    <a href="{{ route('media-issues-remove', [$issue->id]) }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
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
