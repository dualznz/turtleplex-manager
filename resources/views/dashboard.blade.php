@section('title')
    Dashboard
@endsection
@extends('layouts.main')
@section('style')
    <!-- Chartist Chart CSS -->
    <link href="/static/assets/plugins/chartist-js/chartist.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('rightbar-content')
<!-- Start XP Breadcrumbbar -->
<div class="xp-breadcrumbbar text-center">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>
<!-- End XP Breadcrumbbar -->
<!-- Start XP Contentbar -->
<div class="xp-contentbar">
    <!-- End XP Row -->
    <div class="row">
        <!-- End XP Col -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="xp-widget-box">
                        <div class="float-left">
                            <h4 class="xp-counter text-primary">{{ count($media) }}</h4>
                            <p class="mb-0 text-muted">Total Added Media</p>
                        </div>
                        <div class="float-right">
                            <div class="xp-widget-icon xp-widget-icon-bg bg-primary-rgba">
                                <i class="mdi mdi-folder-key-network font-30 text-primary"></i>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End XP Col -->
    </div>
    <!-- End XP Row -->
</div>
<!-- End XP Contentbar -->
@endsection
@section('script')
    <!-- Chartist Chart JS -->
    <script src="/static/assets/plugins/chartist-js/chartist.min.js"></script>
    <script src="/static/assets/plugins/chartist-js/chartist-plugin-tooltip.min.js"></script>
    <!-- Dashboard JS -->
    <script src="/static/assets/js/init/dashborad.js"></script>
@endsection
