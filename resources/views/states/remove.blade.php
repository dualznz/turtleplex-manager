@section('title')
    Remove State Group
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Remove State Group</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('state-groups') }}"><i class="fal fa-cabinet-filing"></i> Media State Groups</a></li>
            <li class="breadcrumb-item active">Remove State Group</li>
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
                        <h5 class="card-title text-black">Remove State Group</h5>
                        <h6 class="card-subtitle">Remove existing media state group from the management portal.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('state-groups-remove-store', $group->slug) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Group Name</label>
                                    <div class="col-lg-5">
                                        {{ $group->group_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Slug</label>
                                    <div class="col-lg-5">
                                        {{ $group->slug }}
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
                                                To remove this drive please type <b>{{ $group->slug }}</b> in the box below.
                                            </p>
                                            <input type="text" class="form-control col-md-3" name="confirmation" value="{{ old('confirmation') }}" placeholder="Confirm Code....">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-7">
                                        @if (count($assets) > 0)
                                            <b>Warning:</b> there are assets assigned to this state group <i class="fas fa-share"></i>&nbsp;&nbsp;<a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;<button class="btn btn-danger" type="submit" title="Action has been disabled, please remove or move all assets first!" disabled>Remove State Group</button>
                                        @else
                                            <a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;
                                            <button class="btn btn-danger" type="submit">Remove State Group</button>
                                        @endif
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
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
