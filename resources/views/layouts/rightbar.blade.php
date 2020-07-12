<div class="xp-rightbar">
    <!-- Start XP Topbar -->
    <div class="xp-topbar">
        <!-- Start XP Row -->
        <div class="row">
            <!-- Start XP Col -->
            <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                <div class="xp-menubar">
                    <a class="xp-menu-hamburger" href="javascript:void(0);">
                       <i class="mdi mdi-sort-variant font-24 text-white"></i>
                     </a>
                 </div>
            </div>
            <!-- End XP Col -->
            <!-- Start XP Col -->
            <div class="col-md-5 col-lg-3 order-3 order-md-2">
                <div class="xp-searchbar">
                    &nbsp;
                </div>
            </div>
            <!-- End XP Col -->
            <!-- Start XP Col -->
            <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                <div class="xp-profilebar text-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="dropdown xp-message mr-3">
                                <a class="dropdown-toggle user-profile-img text-white" href="#" role="button" id="xp-message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-message font-18 v-a-m"></i>
                                    <span class="badge badge-pill badge-success xp-badge-up">8</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-message">
                                    <ul class="list-unstyled">
                                      <li class="media">
                                        <div class="media-body">
                                          <h5 class="mt-0 mb-0 my-3 text-dark text-center font-15">8 New Messages</h5>
                                        </div>
                                      </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="dropdown xp-notification mr-3">
                                <a class="dropdown-toggle user-profile-img text-white" href="#" role="button" id="xp-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-bell-ring font-18 v-a-m"></i>
                                    <span class="badge badge-pill badge-danger xp-badge-up">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-notification">
                                    <ul class="list-unstyled">
                                      <li class="media">
                                        <div class="media-body">
                                          <h5 class="mt-0 mb-0 my-3 text-dark text-center font-15">3 New Notification</h5>
                                        </div>
                                      </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item mr-0">
                            <div class="dropdown xp-userprofile">
                                <a class="dropdown-toggle user-profile-img" href="#" role="button" id="xp-userprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ auth()->user()->avatar() }}" alt="user-profile" class="rounded-circle img-fluid"><span class="xp-user-live"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-userprofile">
                                    <a class="dropdown-item" href="#">Welcome, {{ auth()->user()->username }}</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-settings mr-2"></i> Settings</a>
                                    <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mdi mdi-logout mr-2"></i> Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End XP Col -->
        </div>
        <!-- End XP Row -->
    </div>
    <!-- End XP Topbar -->
    @yield('rightbar-content')
    <!-- Start XP Footerbar -->
    <div class="xp-footerbar">
        <footer class="footer">
            <p class="mb-0">© 2020 Booster - All Rights Reserved.</p>
        </footer>
    </div>
    <!-- End XP Footerbar -->
</div>
