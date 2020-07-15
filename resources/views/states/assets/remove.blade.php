@section('title')
    Remove State Asset
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove State Asset</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('state-groups') }}"><i class="fal fa-cabinet-filing"></i> Media State Groups</a></li>
            <li class="breadcrumb-item"><a href="{{ route('state-assets', [$group->slug]) }}"></a><i class="fad fa-books"></i> Assets: {{ $group->group_name }}</li>
            <li class="breadcrumb-item active">Remove State Asset</li>
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
                        <h5 class="card-title text-black">Remove State Asset</h5>
                        <h6 class="card-subtitle">Remove existing state asset from the database.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('state-assets-remove-store', [$group->slug, $asset->id]) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Asset Name</label>
                                    <div class="col-lg-5">
                                        {{ $asset->asset_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Badge</label>
                                    <div class="col-lg-5">
                                        {!! \App\Helpers\AccentHelper::accent($asset->asset_name, $asset->text_color, $asset->background_color) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Group Name</label>
                                    <div class="col-lg-5">
                                        {{ $group->group_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('confirmation') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Confirmation</label>
                                    <div class="col-lg-8">
                                        <div align="center">
                                            <p>
                                                <b>Warning:</b> please confirm that you wish to remove this stage group,<br>
                                                This operation cannot be reversed and any associated data <b>will</b> be removed!
                                            </p>
                                            <p style="font-size: 15px;">
                                                To remove this state group asset please type <b>{{ $asset->asset_name }}</b> in the box below.
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
                                        <a class="btn btn-warning" href="{{ route('state-assets', [$group->slug]) }}">Cancel</a> &nbsp;
                                        <button class="btn btn-danger" type="submit">Remove State Asset</button>
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <input type="hidden" name="asset_id" value="{{ $asset->id }}">
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
