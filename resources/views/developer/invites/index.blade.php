@section('title')
    Invites
@endsection
@extends('layouts.main')
@section('rightbar-content')
    <!-- Start XP Breadcrumbbar -->
    <div class="xp-breadcrumbbar text-center">
        <h4 class="page-title">Invites</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Developer</li>
            <li class="breadcrumb-item active"><i class="far fa-envelope-open"></i> Invites</li>
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
                        <h5 class="card-title text-black">Invites</h5>
                        <h6 class="card-subtitle">Invite other members to be able to access the management portal</h6>
                    </div>
                    <div class="card-body">

                        <div class="float-right">
                            <a href="{{ route('developer-invites-create') }}" class="btn btn-primary"><i class="far fa-envelope-open"></i> Create Invite</a>
                            <p>&nbsp;</p>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th width="17%">Made By</th>
                                <th width="17%">Claimed By</th>
                                <th>Last Updated</th>
                                <th style="width: 10px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invites as $i)
                                <tr>
                                    <td>{{ $i->id }}</td>
                                    <td>{{ $i->token }}</td>
                                    <td>
                                        @if (is_null($i->made_by))
                                            <em>System</em>
                                        @else
                                            {{ $i->user->username }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($i->claimed_by))
                                            <em class="text-warning">Not Claimed</em>
                                        @else
                                            {{ $i->claimed->username }}
                                        @endif
                                    </td>
                                    <td>{{ \App\Helpers\Timezone::getDate($i->created_at->getTimestamp()) }}</td>
                                    <td>
                                        @if (!is_null($i->claimed_by))
                                            <a class="btn btn-round btn-danger" role="button" href="javascript:void(0);" disabled><i class="far fa-trash"></i></a>
                                        @else
                                            <a class="btn btn-round btn-danger" role="button" href="{{ route('developer-invites-destroy', $i->id) }}" onclick="event.preventDefault();document.getElementById('delete-form-{{ $i->id }}').submit();"><i class="far fa-trash"></i></a>
                                            <form id="delete-form-{{ $i->id }}" action="{{ route('developer-invites-destroy', $i->id) }}" method="POST" style="display: none;">@csrf</form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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
