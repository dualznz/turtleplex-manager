@section('title')
    Permissions
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Permissions</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
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
                        <h5 class="card-title text-black">Permissions</h5>
                        <h6 class="card-subtitle"></h6>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <a href="{{ route('developer-permissions-roles-create') }}" class="btn btn-primary"><i class="far fa-plus"></i> Add Role</a>
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Num of Users</th>
                                <th>Last Updated</th>
                                <th style="width: 10px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td style="color: {{ $r->color }}">{{ $r->name }}</td>
                                    <td>{{ number_format(\App\User::role($r->name)->count(), 0) }}</td>
                                    <td>{{ \App\Timezone::getDate($r->created_at->getTimestamp()) }}</td>
                                    <td><a href="{{ route('developer-permissions-roles-edit', $r->id) }}" class="btn btn-round btn-info"><i class="far fa-pencil"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12">&nbsp;</div>

                        <div class="float-right">
                            <a href="{{ route('developer-permissions-categories-create') }}" class="btn btn-primary"><i class="far fa-plus"></i> Add Category</a>
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Num of Permissions</th>
                                <th>Last Updated</th>
                                <th style="width: 10px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ number_format($c->countPermissions(), 0) }}</td>
                                    <td>{{ \App\Timezone::getDate($c->created_at->getTimestamp()) }}</td>
                                    <td><a href="{{ route('developer-permissions-categories-edit', $c->id) }}" class="btn btn-round btn-info"><i class="far fa-pencil"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12">&nbsp;</div>

                        <div class="float-right">
                            <a href="{{ route('developer-permissions-permissions-create') }}" class="btn btn-primary"><i class="far fa-plus"></i> Add Permission</a>
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Last Updated</th>
                                <th style="width: 10px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($permissions as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ !is_null($p->category_id) ? App\PermissionCategories::find($p->category_id)->name : 'None' }}</td>
                                    <td>{{ \App\Timezone::getDate($p->created_at->getTimestamp()) }}</td>
                                    <td><a href="{{ route('developer-permissions-permissions-edit', $p->id) }}" class="btn btn-round btn-info"><i class="far fa-pencil"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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
