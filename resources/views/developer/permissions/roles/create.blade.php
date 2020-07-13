@section('title')
    New Role
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Permissions</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item"><a href="{{ route('developer-permissions') }}"><i class="far fa-key"></i> Permissions</a></li>
            <li class="breadcrumb-item active"><i class="far fa-plus"></i> New Role</li>
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
                        <h5 class="card-title text-black">New Role</h5>
                        <h6 class="card-subtitle"></h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('developer-permissions-roles-store') }}">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label label-right my-auto">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required="" placeholder="" />
                                        <div class="help-block margin-bottom-none">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-sm-10">
                                        @foreach ($categories as $c)
                                            <table class="table text-center">
                                                <thead>
                                                <tr>
                                                    <th class="text-left"><h4>{{ $c->name }} - <span class="text-muted">{{ $c->description }}</span></h4></th>
                                                    <th class="text-center" style="width: 80px;background-color: #de6464">Deny</th>
                                                    <th class="text-center" style="width: 80px;background-color: #daffda">Allow</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($c->permissions() as $p)
                                                    <tr>
                                                        <td class="text-left"><b>{{ $p->name }}</b> <span class="float-right">{{ $p->description }}</span></td>
                                                        <td style="background-color: #de6464"><div class="i-checks"><input type="radio" title="{{ $p->name }}" name="{{ $p->name }}" {{ old($p->name) == 0 ? 'checked=checked' : '' }} value="0"></div></td>
                                                        <td style="background-color: #daffda"><div class="i-checks"><input type="radio" title="{{ $p->name }}" name="{{ $p->name }}" {{ old($p->name) == 1 ? 'checked=checked' : '' }} value="1"></div></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label">&nbsp;</div>
                                    <div class="col-sm-10">
                                        <a class="btn btn-warning" href="{{ route('developer-permissions') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Create Role</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End XP Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End XP Contentbar -->
@endsection
