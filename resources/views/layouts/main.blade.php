<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title> @yield('title') </title>
        <!-- Fevicon -->
        <link rel="shortcut icon" href="/static/assets/images/favicon.ico">
        <!-- Start CSS -->
        @yield('style')
        <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/static/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="/static/assets/css/style.css" rel="stylesheet" type="text/css">
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
        <!-- End JS -->
    </body>
</html>
