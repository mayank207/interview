<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Error 404</title>
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vertical-menu.min.css')}}">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- error 404 -->
                <section class="row flexbox-container">
                    <div class="col-xl-6 col-md-7 col-9">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <h1 class="error-title">Page Not Found :(</h1>
                                    <p class="pb-3">
                                        we couldn't find the page you are looking for</p>
                                    <img class="img-fluid" src="{{asset('image/404.png')}}" alt="403 error">
                                    <a href="{{route('home')}}" class="btn btn-primary round glow mt-3">BACK
                                        TO
                                        HOME</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- error 404 end -->
            </div>
        </div>
    </div>
     <script src="{{asset('js/vendors.min.js')}}"></script>
    <script src="{{asset('js/app-menu.min.js')}}"></script>
</body>
</html>

