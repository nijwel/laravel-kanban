<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>Fox Admin - Dashboard</title>

    <!-- Bootstrap v4.1.3.stable -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/assets/vendor_components/bootstrap/dist/css/bootstrap.css">

    <!-- Bootstrap extend-->
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/bootstrap-extend.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/assets/vendor_components/font-awesome/css/font-awesome.css">

    <!-- ionicons -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/assets/vendor_components/Ionicons/css/ionicons.css">

    <!-- theme style -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/master_style.css">

    <!-- fox_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/skins/_all-skins.css">

    <!-- weather weather -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/assets/vendor_components/weather-icons/weather-icons.css">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/assets/vendor_components/jvectormap/jquery-jvectormap.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet"
        href="{{ asset('backend/') }}/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">


</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('layouts.includes.header')
        <!-- Control Sidebar Toggle Button -->
        <div>
            <button class="control-sidebar-btn btn btn-dark" data-toggle="control-sidebar"><i
                    class="fa fa-cog fa-spin"></i></button>
        </div>
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            @include('layouts.includes.breadcrumb')
            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right d-none d-sm-inline-block">
                <b>Version</b> 2.0
            </div>Copyright &copy; 2020 <a href="https://www.multipurposethemes.com/">Multi-Purpose Themes</a>. All
            Rights Reserved.
        </footer>

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->



    <!-- jQuery 3 -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/jquery/dist/jquery-3.3.1.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/jquery-ui/jquery-ui.js"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- popper -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/popper/dist/popper.min.js"></script>

    <!-- Bootstrap v4.1.3.stable -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/bootstrap/dist/js/bootstrap.js"></script>

    <!-- ChartJS -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/chart-js/chart.js"></script>

    <!-- Sparkline -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.js"></script>

    <!-- jvectormap -->
    <script src="{{ asset('backend/') }}/assets/vendor_plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/vendor_plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/jquery-knob/js/jquery.knob.js"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('backend/') }}/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- FastClick -->
    <script src="{{ asset('backend/') }}/assets/vendor_components/fastclick/lib/fastclick.js"></script>

    <!-- fox_admin App -->
    <script src="{{ asset('backend/') }}/js/template.js"></script>

    <!-- fox_admin dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend/') }}/js/pages/dashboard.js"></script>

    <!-- fox_admin for demo purposes -->
    <script src="{{ asset('backend/') }}/js/demo.js"></script>

    <!-- weather for demo purposes -->
    <script src="{{ asset('backend/') }}/assets/vendor_plugins/weather-icons/WeatherIcon.js"></script>

    <script type="text/javascript">
        WeatherIcon.add('icon1', WeatherIcon.SLEET, {
            stroke: false,
            shadow: false,
            animated: true
        });
        WeatherIcon.add('icon2', WeatherIcon.SNOW, {
            stroke: false,
            shadow: false,
            animated: true
        });
        WeatherIcon.add('icon3', WeatherIcon.LIGHTRAINTHUNDER, {
            stroke: false,
            shadow: false,
            animated: true
        });
    </script>


</body>

</html>
