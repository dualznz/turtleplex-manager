@section('title')
    Edit Drive
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Edit Drive</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> Hard Drives</a></li>
            <li class="breadcrumb-item active"><i class="fal fa-edit"></i> Edit Drive</li>
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
                        <h5 class="card-title text-black">Edit Drive</h5>
                        <h6 class="card-subtitle">Edit existing hard drive details which is used to bind media & assets to.</h6>
                    </div>
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('drives-edit-store', $drive->slug) }}">
                            @csrf

                            <div class="form-group {{ $errors->first('drive_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="drive_name" value="{{ $drive->drive_name }}" readonly />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the drive name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('attached_server') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Attached Server</label>
                                    <div class="col-lg-3">
                                        <select class="form-control" name="attached_server" id="attached_server" required>
                                            @foreach (\App\Servers::orderBy('server_name', 'ASC')->get() as $s)
                                                <option value="{{ $s->id }}" {{ $drive->server_id == $s->id ? 'selected' : '' }}>{{ $s->server_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block margin-bottom-none">
                                            <small>Please select the server to attach this drive to.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->first('drive_folder') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive Folder</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="drive_folder" value="{{ $drive->drive_folder }}" required="" placeholder="/drive folder name..." />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the drive folder name.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Edit Drive</button>
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <input type="hidden" name="server_id" value="{{ $drive->server->id }}">
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
