@section('title')
    TURTLE-Plex Media Manager - 403
@endsection
@extends('layouts.login')
@section('style')

@endsection
<div class="xp-authenticate-bg"></div>
<!-- Start XP Container -->
<div id="xp-container" class="xp-container">

    <!-- Start Container -->
    <div class="container">

        <!-- Start XP Row -->
        <div class="row vh-100 align-items-center">
            <!-- Start XP Col -->
            <div class="col-lg-12 ">

                <!-- Start XP Auth Box -->
                <div class="xp-auth-box">

                    <div class="xp-error-box text-center">
                        <h1 class="xp-error-title mb-3"><span class="text-white">4</span><span class="text-white">0</span><span class="text-white">3</span>
                        </h1>
                        <h4 class="xp-error-subtitle text-white m-b-30">F<i class="mdi mdi-emoticon-sad text-danger font-32"></i>rbidden</h4>
                        <p class="text-white m-b-30">You're not permitted to see this. <br>If you feel this is a mistake, contact your admin. </p>
                        <a href="{{ route('index') }}" class="btn btn-success btn-rounded mb-3"><i class="mdi mdi-home"></i> Take Me Home</a>
                    </div>


                </div>
                <!-- End XP Auth Box -->

            </div>
            <!-- End XP Col -->
        </div>
        <!-- End XP Row -->
    </div>
    <!-- End Container -->
</div>
<!-- End XP Container -->
@section('script')

@endsection
