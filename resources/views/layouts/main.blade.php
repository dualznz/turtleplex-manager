<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title> @yield('title') - TURTLE-Plex Manager </title>
        <!-- Fevicon -->
        <link rel="shortcut icon" href="/static/assets/images/favicon.ico">
        <!-- Start CSS -->
        @yield('style')
        <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/static/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="/static/assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="/static/css/app.css?v={{ hash_file('crc32b', public_path().'/static/assets/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-IIED/eyOkM6ihtOiQsX2zizxFBphgnv1zbe1bKA+njdFzkr6cDNy16jfIKWu4FNH" crossorigin="anonymous">
        <livewire:styles>
        <!-- End CSS -->
    </head>
    <body class="xp-vertical">
        <!-- Start XP Container -->
        <div id="xp-container">
            <!-- Start XP Leftbar -->
            @include('layouts.leftbar')
            <!-- End XP Leftbar -->
            <!-- Start XP Rightbar -->
            @include('layouts.rightbar')
            @yield('content')
            <!-- End XP Rightbar -->
        </div>
        <!-- End XP Container -->
        <!-- Start JS -->
        <script src="/static/assets/js/jquery.min.js"></script>
        <script src="/static/assets/js/popper.min.js"></script>
        <script src="/static/assets/js/bootstrap.min.js"></script>
        <script src="/static/assets/js/modernizr.min.js"></script>
        <script src="/static/assets/js/detect.js"></script>
        <script src="/static/assets/js/jquery.slimscroll.js"></script>
        <script src="/static/assets/js/sidebar-menu.js"></script>
        @yield('script')
        <!-- Main JS -->
        <script src="/static/assets/js/main.js"></script>
        <livewire:scripts>
        <!-- End JS -->
    </body>
</html>
