@section('title')
    Submission Issues
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Submission Issues: {{ $asset->asset_name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('media-issue') }}"><i class="fal fa-plug"></i> Submission Issues</a></li>
            <li class="breadcrumb-item active">{{ $asset->asset_name }}</li>
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
                            <h5 class="card-title text-black">Media Issues: {{ $asset->asset_name }}</h5>
                            <h6 class="card-subtitle">Assess media submission issues and manually update them via <a href="https://www.postman.com/" target="_blank">Postman</a>.</h6>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('media-issue') }}" class="btn btn-primary"><i class="fas fa-chevron-double-left"></i> Back To Issues</a>
                        </div>
                    </div>
                    <div class="card-body">

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

                        <div class="col-lg-12">&nbsp;</div>

                        <div style="display: flex; justify-content: center; align-content: center;">
                            {{ $issues->links() }}
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
