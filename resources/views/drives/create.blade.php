@section('title')
    Add Drive
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Add Hard Drive</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hardware</li>
            <li class="breadcrumb-item"><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> Hard Drives</a></li>
            <li class="breadcrumb-item active">Add Drive</li>
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
                        <h5 class="card-title text-black">Add Drive</h5>
                        <h6 class="card-subtitle">Add a new hard drive to a selected server which will allow media to be added via assets.</h6>
                    </div>
                    <div class="card-body">


                        <form class="form-horizontal" method="POST" action="{{ route('drives-store') }}">
                            @csrf

                            <div class="form-group {{ $errors->first('drive_name') ? 'has-error' : ''}}">
                                <div class="row">
                                    <label class="col-lg-2 control-label label-right my-auto">Drive Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="drive_name" value="{{ old('drive_name') }}" required="" placeholder="drive name" />
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
                                            <option selected disabled>Please select a server...</option>
                                            @foreach (\App\Servers::orderBy('server_name', 'ASC')->get() as $s)
                                                <option value="{{ $s->id }}">{{ $s->server_name }}</option>
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
                                        <input type="text" class="form-control" name="drive_folder" value="{{ old('drive_folder') }}" required="" placeholder="/drive folder name..." />
                                        <div class="help-block margin-bottom-none">
                                            <small>Please provide the drive folder path.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1 control-label"></div>
                                    <div class="col-lg-5">
                                        <a class="btn btn-warning" href="{{ route('drives') }}">Cancel</a> &nbsp;
                                        <button class="btn btn-primary" type="submit">Add Drive</button>
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
