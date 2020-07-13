@section('title')
    Create Invite
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Create Invite</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item "><a href="{{ route('developer-invites') }}"><i class="far fa-envelope-open"></i> Invites</a></li>
            <li class="breadcrumb-item active"><i class="far fa-plus"></i> Create Invite</li>
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
                        <h5 class="card-title text-black">Create Invite</h5>
                        <h6 class="card-subtitle">Create new invite to send to a member you with to allow access to the management portal.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="post" action="javascript:void(0);">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Token</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="token" title="Token" value="{{ $i->token }}" readonly>
                                        <div class="help-block margin-bottom-none">
                                            <small>Generated invite token.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Token URL</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="url" title="URL" value="{{ route('invite', $i->token) }}">
                                        <div class="help-block margin-bottom-none">
                                            <small>Generated invite url.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-primary" href="{{ route('developer-invites') }}">Back to Invites</a>
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
