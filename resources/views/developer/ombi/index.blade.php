@section('title')
    Ombi Users
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Ombi Users</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item active">Ombi Users</li>
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
                            <h5 class="card-title text-black">Ombi Users</h5>
                            <h6 class="card-subtitle">View / edit or delete imported ombi users which is used to incoming requests, issues and so forth</h6>
                        </div>
                        <div class="pull-right">
                            <a href="" class="btn btn-primary">Manual Import</a>
                        </div>
                    </div>
                    <div class="card-body">



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
