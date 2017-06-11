<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon_1.ico">

        <title>{{config('app.name')}} - @yield('title')</title>

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link href="/assets/css/app.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/assets/css/select2.css">
        <script src="/assets/js/jquery-1.11.2.min.js"></script>
        <script src="/assets/js/select2.js"></script>
        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/Chart/Chart.min.js"></script>
    </head>


    <body class="fixed-left">

                                    

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="/u/overview" class="logo"><span>Hawagym</span></a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            


                            <ul class="nav navbar-nav navbar-right pull-right">
                                
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light" title="Help"><i class="md  md-help"></i></a>
                                </li>
                                <li class="dropdown">
                             
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">{{Auth::user()->username}} <img @if(Auth::user()->avatar!="") src="/images/avatar/{{Auth::user()->avatar}}" @else src="/images/avatar/default.png" @endif alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/u/profile"><i class="ti-user m-r-5"></i> Akunku</a></li>
                                        <li><a href="/auth/logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                        	<li class="text-muted menu-title">Navigation</li>

                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "dashboard")
                                  <li >
                                  @break
                                @else
                                  <li hidden="">
                                @endif
                             @endforeach
                                <a href="/u/overview" class="waves-effect @if(request()->is('u/overview*')) active subdrop @endif"><i class="ti-home"></i> <span> Dashboard </span></a>
                            </li>

                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "Transaksi")
                                  <li class="has_sub">
                                  @break
                                @else
                                  <li hidden="" class="has_sub">
                                @endif
                             @endforeach
                                <a href="/u/transactions" class="waves-effect @if(request()->is('u/transactions*') || request()->is('u/personaltrainer*') 
                                || request()->is('u/kantin*')|| request()->is('u/pengeluaran*') || 
                                request()->is('u/storan*')|| request()->is('u/gymharian*')) active @endif"><i class="ti-money"></i> <span> Transaksi </span></a>
                                <ul class="list-unstyled">
                                <li class="@if(request()->is('u/gymharian'))active @endif"><a class="@if(request()->is('u/gymharian')) active @endif" href="/u/gymharian">Member Gym Harian</a></li>
                                     <li class="@if(request()->is('u/personaltrainer*')) active @endif"><a href="/u/personaltrainer">Pendapatan Personal Trainer</a></li>
                                    <li class="@if(request()->is('u/kantin*')) active @endif"><a href="/u/kantin">Pendapatan Kantin</a></li>
                                    <li class="@if(request()->is('u/pengeluaran*')) active @endif"><a href="/u/pengeluaran">Pengeluaran</a></li>
                                    <li class="@if(request()->is('u/storan*')) active @endif"><a href="/u/storan">Setoran Ke Bank</a></li>
                                </ul>
                            </li>

                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "member")
                                  <li class="has_sub">
                                  @break
                                @else
                                  <li hidden="" class="has_sub">
                                @endif
                             @endforeach
                                <a href="#" class="waves-effect @if(request()->is('u/members*') ||
                                 request()->is('u/cards*') || request()->is('u/trial*')) active @endif"><i class="ti-user"></i> <span> <!-- Member --> Member </span> </a>
                                <ul class="list-unstyled">
                                    <li class="@if(request()->is('u/members'))active @endif"><a class="@if(request()->is('u/members'))active @endif" href="/u/members">Data Member</a></li>
                                    <li class="@if(request()->is('u/members/create'))active @endif"><a class="@if(request()->is('u/members'))active @endif" href="/u/members/create">Member Baru</a></li>
                                    <li class="@if(request()->is('u/members/extend'))active @endif"><a class="@if(request()->is('u/members/extend')) active @endif" href="/u/members/extend">Perpanjangan Member</a></li>
                                    <li class="@if(request()->is('u/members/activate'))active @endif"><a class="@if(request()->is('u/members/activate'))active @endif" href="/u/members/activate">Aktifasi Member</a></li>
                                    <li class="@if(request()->is('u/members/attendances'))active @endif"><a class="@if(request()->is('u/members/attendances'))active @endif" href="/u/members/attendances">Check-in / Check-Out</a></li>
                                    <li class="@if(request()->is('u/trial'))active @endif"><a class="@if(request()->is('u/trial')) active @endif" href="/u/trial">Free Trial</a></li>
                                    <li class="@if(request()->is('u/cards'))active @endif"><a class="@if(request()->is('u/cards'))active @endif" href="/u/cards">Data Kartu</a></li>
                                    <li class="@if(request()->is('u/members/upload'))active @endif"><a class="@if(request()->is('u/members/upload')) active @endif" href="/u/members/upload">Upload Member</a></li>
                                    <li class="@if(request()->is('u/members/ex_member'))active @endif"><a class="@if(request()->is('u/members/ex_member')) active @endif" href="/u/members/ex_member">Upload Perpanjangan Member</a></li>
                                    <li class="@if(request()->is('u/members/attendances/upload'))active @endif"><a class="@if(request()->is('u/members/attendances/upload'))active @endif" href="/u/members/attendances/upload">Upload Check-in / Check-Out</a></li>
                                    
                                    
                                    <!-- <li><a href="/u/members/activate">Aktifasi Member</a></li>
                                    <li><a href="/u/members/activate">Aktifasi Member</a></li>
                                    <li><a href="/u/members">Data Member</a></li>
                                    <li><a href="/u/card">Data Kartu</a></li> -->
                                </ul>
                            </li>


                           @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "gym")
                                  <li class="has_sub" >
                                  @break
                                @else
                                  <li hidden="">
                                @endif
                             @endforeach
                                <a href="#" class="waves-effect @if(request()->is('u/searchgym') || request()->is('u/gyms*')|| request()->is('u/searchinpackage') || request()->is('u/searchpackage') || request()->is('u/zonas*') || request()->is('u/packages*')
                                || request()->is('u/packageprices*') || request()->is('u/showgym*') || request()->is('u/schedule*')) active @endif"><i class="ti-map-alt"></i> <span> Gym</span> </a>
                                <ul class="list-unstyled">
                                    
                                    <li class="@if(request()->is('u/zonas*')) active @endif"><a class="@if(request()->is('u/zonas*')) active @endif" href="/u/zonas">Data Zona</a></li>
                                    <li  class="@if(request()->is('u/gyms*') || request()->is('u/searchgym') || request()->is('u/showgym*')) active @endif"><a class="@if(request()->is('u/gyms*')) active @endif" href="/u/gyms">Data Gym</a></li>
                                    <li class="@if(request()->is('u/packages*') || request()->is('u/searchinpackage')) active @endif"><a href="/u/packages">Kategori Harga</a></li>
                                    <li class="@if(request()->is('u/packageprices*') || request()->is('u/searchpackage')) active @endif"><a href="/u/packageprices">Daftar Harga</a></li>
                                    <li class="@if(request()->is('u/schedule*') ) active @endif"><a href="/u/schedule">Jadwal Latihan</a></li>
                                </ul>
                            </li>

                            

                           @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "komuniti")
                                  <li  class="has_sub">
                                  @break
                                @else
                                  <li hidden="">
                                @endif
                             @endforeach
                                <a href="#" class="waves-effect @if( request()->is('u/tiketsupport*') || request()->is('u/promoinfo*') || request()->is('u/mail*') || request()->is('u/news*') || request()->is('u/events*') || request()->is('u/poolings*')) active @endif"><i class="ti-announcement"></i> <span> Komunitas </span> </a>
                                <ul class="list-unstyled">
                                    <li class="@if(request()->is('u/promoinfo*')) active @endif"><a href="/u/promoinfo">Promo Info</a></li>
                                    <li class="@if(request()->is('u/news*')) active @endif"><a href="/u/news">News</a></li>
                                    <li class="@if(request()->is('u/events*')) active @endif"><a href="/u/events">Events</a></li>
                                    <li class="@if(request()->is('u/poolings*')) active @endif"><a href="/u/poolings">Pooling</a></li>
                                     <li class="@if(request()->is('u/tiketsupport*')) active @endif"><a href="/u/tiketsupport">Tiket Support</a></li>
                                      <li class="@if(request()->is('u/listemail*')) active @endif"><a href="/u/listemail">List Email</a></li>
                                    <li class="@if(request()->is('u/mail*')) active @endif"><a href="/u/mail">Promo Blast</a></li>
                                    <li class="@if(request()->is('u/emailtemplate*')) active @endif"><a href="/u/templateemail">Template Email</a></li>
                                </ul>
                            </li>
                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "accounting")
                                  <li class="has_sub">
                                  @break
                                @else
                                  <li hidden="" class="has_sub">
                                @endif
                             @endforeach
                                <a href="#" class="waves-effect @if(request()->is('u/target*') || request()->is('u/promos*') || request()->is('u/pettycash*') ) active @endif"><i class="ti-map-alt"></i> <span>  Akunting  </span> </a>
                                <ul class="list-unstyled">
                                    <li class="@if(request()->is('u/promos*')) active @endif"><a href="/u/promos">Code Promo</a></li>
                                    <li class="@if(request()->is('u/pettycash*')) active @endif"><a href="/u/pettycash">Petty Cash</a></li>
                                    <li class="@if(request()->is('u/target*')) active @endif"><a href="/u/target">Target Gym</a></li>
                                   
                                </ul>
                            </li>
                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "report")
                                  <li class="has_sub">
                                  @break
                                @else
                                  <li hidden="">
                                @endif
                             @endforeach
                                <a href="#" class="waves-effect @if(request()->is('u/report*')) active @endif"><i class="ti-printer"></i> <span> Laporan </span> </a>
                                <ul class="list-unstyled">
                                    <li class="@if(request()->is('u/report/member*')) active @endif"><a href="/u/report/member">Member</a></li>
                                    <li class="@if(request()->is('u/report/memberbaru*')) active @endif"><a href="/u/report/memberbaru">Member Baru</a></li>
                                    <li class="@if(request()->is('u/report/newmembervs*')) active @endif"><a href="/u/report/newmembervs">Member Baru Periodik</a></li>
                                    <li class="@if(request()->is('u/report/newmemberyear*')) active @endif"><a href="/u/report/newmemberyear">Member Baru Tahun Periodik Perbandingan</a></li>
                                    <li class="@if(request()->is('u/report/registermember*')) active @endif"><a href="/u/report/registermember">Member Registrasi Baru</a></li>
                                    
                                   <!-- <li><a href="">Member Expired</a></li>
                                    <li><a href="">Statistik Member Expired</a></li>
                                    <li><a href="">Member Extend</a></li>-->
                                    <li class="@if(request()->is('u/report/extendvs*')) active @endif"><a href="/u/report/extendvs">Perbandingan Perpanjangan Member</a></li>
                                    <li class="@if(request()->is('u/report/promovs*')) active @endif"><a href="/u/report/promovs">Perbandingan Promo</a></li>
                                    <ul class="list-unstyled">
                                    
                                    <li class="@if(request()->is('u/report/longpacket*')) active @endif"><a href="/u/report/longpacket">Perbandingan Paket</a></li>
                                    <li class="@if(request()->is('u/report/extendlongvs*')) active @endif"><a href="/u/report/extendlongvs">Perbandingan Member Perpanjangan vs Tidak</a></li>
                                    <li class="@if(request()->is('u/report/incomevs*')) active @endif"><a href="/u/report/incomevs">Perbandingan Pendapatan</a></li>
                                    
                                    <!--<li><a href="">Dekade Kelahiran Member</a></li>-->
                                    <li class="@if(request()->is('u/report/checkin*')) active @endif"><a href="/u/report/checkin">Member  Check In Check Out</a></li>
                                  <!--  <li><a href="">Member register Via </a></li>
                                    <li><a href="">Statistic Member register Via </a></li>
                                    <li><a href=""> Member extend Via </a></li>
                                    <li><a href="">Statistic Member extend Via </a></li>-->
                                    <li class="@if(request()->is('u/report/usiamember*')) active @endif"><a href="/u/report/usiamember"> Usia Member </a></li>
                                   <!-- <li><a href="">Statistic Member usia Via </a></li>-->
                                    <li class="@if(request()->is('u/report/pendapatan*')) active @endif"><a href="/u/report/pendapatan">Pendapatan </a></li>
                                   <!-- <li><a href="">Pendapatan berdasarkan Pembayaran </a></li>
                                    <li><a href="">Pendapatan Per Periode </a></li>
                                    <li><a href="">Pendapatan Paket Gym </a></li>
                                    <li><a href="">Statistik Pendapatan Paket Gym </a></li>
                                    <li><a href="">Statistik Pendapatan Paket Gym </a></li>-->
                                    <li class="@if(request()->is('u/report/incomeday*')) active @endif"><a href="/u/report/incomeday">Pendapatan Harian</a></li>
                                     <li class="@if(request()->is('u/report/reportkhusus*')) active @endif"><a href="/u/report/reportkhusus">Report Khusus</a></li>
                                    <li class="@if(request()->is('u/report/promo*')) active @endif"><a href="/u/report/promo">Promo</a></li>
                                    <li class="@if(request()->is('u/report/analisapendapatan*')) active @endif"><a href="/u/report/analisapendapatan">Analisa Pendapatan</a></li>
                                    <li class="@if(request()->is('u/report/slipsetoran*')) active @endif"><a href="/u/report/slipsetoran">Slip Setoran</a></li>
<!--                                    <li><a href="/u/transactions/create">Transaksi Baru</a></li>
                                    <li><a href="/u/transactions">Laporan</a></li>-->
                                </ul>
                            </li>
                           
                            @foreach (\App\Permission::MenuRole(Auth::user()->role_id) as $menu)
                                @if(\App\Permission::IdMenu($menu->permission_id)->name == "pengaturan")
                                  <li class="has_sub">
                                  @break
                                @else
                                  <li hidden>
                                @endif
                             @endforeach
                            
                                <a href="#" class="waves-effect @if(request()->is('u/roles*') || request()->is('u/privileges*') || request()->is('u/profile*')) active @endif"><i class="ti-settings"></i> <span> <!-- Pengaturan -->Pengaturan </span> </a>
                                <ul class="list-unstyled">
                                    <li class="@if(request()->is('u/roles*')) active @endif"><a href="/u/roles">User</a></li>
                                    <li class="@if(request()->is('u/privileges*')) active @endif"><a href="/u/privileges">Role</a></li>
                                    <li class="@if(request()->is('u/profile*')) active @endif"><a href="/u/Profile">Profile</a></li>
                                    
                                </ul>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">@yield('page-title')</h4>
                                @yield('page-breadcrumb')
                                <p class="text-muted page-title-alt">@yield('page-subtitle')</p>
                            </div>
                        </div>

                        @yield('content')

                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    Developed by <a href="https://www.marketbiz.net">Marketbiz </a>
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->
        
        <script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCxtzVR8BAw-AW0GsI8-hPiONtcPYyt23Q"></script>
        <script src="/assets/js/component.js"></script>
        <script src="/assets/js/app.js"></script>
        <script src="/assets/js/bootstrap-datepicker.js"></script>
        
        @foreach (['danger', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <script>
                    $.Notification.notify('{{$msg}}','top right','', '{{ Session::get('alert-' . $msg) }}');
                </script>
            @endif
        @endforeach
         @foreach (['error'] as $msg)
            @if(Session::has('alert-' . $msg))
                <script>
                    $.Notification.notify('{{$msg}}','top center','', '{{ Session::get('alert-' . $msg) }}');
                </script>
            @endif
        @endforeach
       
    </body>
</html>