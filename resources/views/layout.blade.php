<!doctype html>
<html class="no-js " lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
@yield('css')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
    @include('css')
</head>

<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/loader.svg')}}" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
    <form>
        <input type="search" value="" placeholder="Search..." />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>


<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="/"><span class="m-l-10">प्लाज्मा डोनेसन</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="#"><img src="{{ asset('assets/images/nepal_logo.png')}}" alt="User"></a>
                    <div class="detail">

                        <h4>{{Auth::user()->name}}</h4>
                        <small>{{Auth::user()->email}}</small>                        
                    </div>
                </div>
            </li>
            <li><a href="/"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>News</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('admin.news-add')}}">Add New</a></li>
                    <li><a href="{{route('admin.news')}}">List</a></li>
                
                </ul>
            </li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-circle"></i><span>Users</span></a>
                <ul class="ml-menu">
                    {{-- <li><a href="{{route('admin.news-add')}}">Add New</a></li> --}}
                    <li><a href="{{route('admin.users')}}">List</a></li>
                    <li><a href="{{route('admin.user-add')}}">Add Donor</a></li>
                    <li><a href="">Near To Expire Donor List</a></li>

                
                </ul>
            </li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-bookmark"></i><span>Requests</span></a>
                <ul class="ml-menu">
                    {{-- <li><a href="{{route('admin.news-add')}}">Add New</a></li> --}}
                    <li><a href="{{route('admin.requests')}}">Current List</a></li>
                    <li><a href="{{route('admin.exrequests')}}">Expired List</a></li>
                    <li><a href="{{route('admin.request-add')}}">Add Request</a></li>
                
                </ul>
            </li>
            <li><a href="{{route('admin.donations')}}"><i class="zmdi zmdi-info"></i><span>Donations</span></a></li>

             
            <li><a href="{{route('admin.message')}}"><i class="zmdi zmdi-info"></i><span>Welcome Message</span></a></li>

            <li><a href="{{route('admin.about')}}"><i class="zmdi zmdi-email"></i><span>About</span></a></li>

            <li><a href="{{route('logout')}}"><i class="zmdi zmdi-sign-in"></i><span>Logout</span></a></li>

        </ul>
    </div>
</aside>



<!-- Main Content -->
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>@yield('title')</h2>
                    <ul class="breadcrumb">
                        @yield('breadcrumb')
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>@yield('header')</h2>
                        </div>
                        <div class="body">
                            <div class="pt-2 pb-2">
                                @yield('toolbar')
                            </div>
                            <div class="pt-2 pb-2">
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Jquery Core Js --> 
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
@yield('js')
<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>

</body>

</html>