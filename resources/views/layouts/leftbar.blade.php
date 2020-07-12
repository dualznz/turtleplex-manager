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

                @can('viewDeveloper')
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
