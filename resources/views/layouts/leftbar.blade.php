<div class="xp-leftbar">
    <!-- Start XP Sidebar -->
    <div class="xp-sidebar">
        <!-- Start XP Logobar -->
        <div class="xp-logobar text-center">
            <a href="{{ route('dashboard') }}" class="xp-logo"><img src="/static/assets/images/turtle-plex-logo.png" class="img-fluid" alt="logo"></a>
        </div>
        <!-- End XP Logobar -->
        <!-- Start XP Navigationbar -->
        <div class="xp-navigationbar">
            <ul class="xp-vertical-menu">
                <li class="xp-vertical-header">Navigation</li>

                <li {{ (request()->is('*dashboard') ? 'class=active' : '') }}>
                    <a href="{{ route('dashboard') }}"><i class="far fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>

                @can ('viewMediaIssues')
                    <li {{ request()->is('*media-issues') ? 'class=active' : '' }}>
                        <a href="{{ route('media-issue') }}"><i class="fal fa-plug"></i> <span>Submission Issues</span>
                            {!! \App\MediaIssues::where('state_asset_id', env('MEDIA_ISSUES_PENDING_ID'))->count() == 0 ? '' : '&nbsp;&nbsp;<span class="badge badge-danger">'.count(\App\MediaIssues::where('state_asset_id', env('MEDIA_ISSUES_PENDING_ID'))->get()).'</span>' !!}
                        </a>
                    </li>
                @endcan

                @if (count(\App\Drives::all()) != 0)
                    @can ('viewMedia')
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fal fa-photo-video"></i> <span>Media</span><i class="mdi mdi-chevron-right pull-right"></i>
                            </a>
                            <ul class="xp-vertical-submenu">
                                @foreach (\App\Drives::orderBy('drive_name', 'ASC')->get() as $drive)
                                    <li {{ (request()->is('*media/'.$drive->server->server_name.'/'.$drive->slug.'/*') ? 'class=active' : '') }}><a href="{{ route('media', [$drive->server->slug, $drive->slug]) }}"><i class="fal fa-tv-retro"></i> <span>{{ $drive->drive_name }}</span></a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endcan
                @endif

                @can ('viewHardware')
                    <li>
                        <a href="javascript:void(0);">
                            <i class="fal fa-garage"></i> <span>Hardware</span><i class="mdi mdi-chevron-right pull-right"></i>
                        </a>
                        <ul class="xp-vertical-submenu">
                            @can ('viewServers')
                                <li {{ (request()->is('*servers') ? 'class=active' : '') }}><a href="{{ route('servers') }}"><i class="fal fa-server"></i> <span>Servers</span></a></li>
                            @endcan
                            @can('viewDrives')
                                <li {{ (request()->is('*drive*') ? 'class=active' : '') }}><a href="{{ route('drives') }}"><i class="fal fa-hdd"></i> <span>Hard Drives</span></a></li>
                            @endcan
                            @can ('viewStateGroups')
                                    <li {{ (request()->is('*state*') ? 'class=active' : '') }}><a href="{{ route('state-groups') }}"><i class="fal fa-cabinet-filing"></i> <span>Media State Groups</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can ('viewDeveloper')
                    <li>
                        <a href="javaScript:void(0);">
                            <i class="far fa-terminal"></i> <span>Developer</span><i class="mdi mdi-chevron-right pull-right"></i>
                        </a>
                        <ul class="xp-vertical-submenu">
                            <li><a href="/horizon" target="_blank"><i class="far fa-tasks"></i> <span>Horizon</span></a></li>
                            <li {{ (request()->is('*developer/invites*') ? 'class=active' : '') }}><a href="{{ route('developer-invites') }}"><i class="far fa-envelope-open"></i> <span>Invites</span></a></li>
                            <li {{ (request()->is('*developer/permissions*') ? 'class=active' : '') }}><a href="{{ route('developer-permissions') }}"><i class="far fa-key"></i> <span>Permissions</span></a></li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- End XP Navigationbar -->
    </div>
    <!-- End XP Sidebar -->
</div>
<!-- End XP Leftbar -->
