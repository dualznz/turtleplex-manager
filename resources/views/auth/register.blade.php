@section('title')
    TURTLE-Plex Media Manager - Register
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
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center mt-0 m-b-15">
                                <img src="/static/assets/images/turtle-media-manager-logo.png" height="150" alt="logo">
                            </h3>
                            <div class="p-3">
                                <form role="form" method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="text-center mb-3">
                                        <h4 class="text-black">Create New Account</h4>
                                    </div>

                                    <div class="form-group {{ $errors->has('invite') ? 'has-error' : '' }}">
                                        <input id="invite" type="text" class="form-control" name="invite" placeholder="Invite" value="{{ $invite }}" readonly>
                                        @if ($errors->has('invite'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('invite') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                                        <input id="username" type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                        @if ($errors->has('username'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-rounded btn-lg btn-block">Create an Account</button>
                                </form>
                            </div>
                        </div>
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
