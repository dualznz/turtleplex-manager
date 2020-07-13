@section('title')
    New Permission
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">New Permission</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item"><a href="{{ route('developer-permissions') }}"><i class="far fa-key"></i> Permissions</a></li>
            <li class="breadcrumb-item active"><i class="far fa-plus"></i> New Permission</li>
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
                        <h5 class="card-title text-black">New Permission</h5>
                        <h6 class="card-subtitle">Create permission(s) which can then be assigned to permission categories.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('developer-permissions-permissions-store') }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Name</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required="" placeholder="" />
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
                                        <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('description') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Category</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="category" title="Category">
                                            <option value="none" {{ old('category') == 'none' ? 'selected=selected' : '' }}>None</option>
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}" {{ old('category') == $c->id ? 'selected=selected' : '' }}>{{ $c->name }} - {{ $c->description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('category') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-5">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="add_new_row" id="NewRowSelection">
                                            <label class="custom-control-label" for="NewRowSelection">Add new row after submission?</label>
                                        </div>
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('add_new_row') }}
                                            <small>Select if you would like to add another permission once you have submitted this one.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <a class="btn btn-warning" href="{{ route('developer-permissions') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Create Permission</button>
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
