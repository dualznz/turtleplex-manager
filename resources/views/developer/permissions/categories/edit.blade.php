@section('title')
    Edit Category
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Edit Category: {{ $c->name }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item"><a href="{{ route('developer-permissions') }}"><i class="far fa-key"></i> Permissions</a></li>
            <li class="breadcrumb-item active"><i class="far fa-pencil"></i> <strong>Edit Category: {{ $c->name }}</strong></li>
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
                        <h5 class="card-title text-black">Edit Category</h5>
                        <h6 class="card-subtitle">Edit permission category groups where you can assign permissions to.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('developer-permissions-categories-update', $c->id) }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Order</label>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" name="order" id="order" value="{{ $c->order }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('order') }}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Name</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $c->name }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Description</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="description" id="description" value="{{ $c->description }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('description') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <div class="float-right">
                                            @if ($c->countPermissions() > 0)
                                                <button type="button" class="btn btn-danger disabled" data-toggle="tooltip" data-placement="top" title="There are permissions under this category"><i class="far fa-trash"></i> Delete</button>
                                            @else
                                                <a class="btn btn-danger" href="{{ route('developer-permissions-categories-destroy', $c->id) }}"><i class="far fa-trash"></i> Delete</a>
                                            @endif
                                        </div>
                                        <a class="btn btn-warning" href="{{ route('developer-permissions') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Edit Category</button>
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
