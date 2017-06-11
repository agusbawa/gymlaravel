<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon_1.ico">

        <title>Hawagym - @yield('title')</title>

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link href="/assets/css/app.css" rel="stylesheet" type="text/css" />
        <script src="/assets/js/Chart/Chart.min.js"></script>
        <script src="/assets/js/jquery.js"></script>
    </head>
    

    <body class="fixed-left widescreen">
        
                                    

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

                           
                            <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'1','1')==0) hidden="" @endif>
                             
                                <a href="/u/overview" class="waves-effect @if(request()->is('u/overview*')) active subdrop @endif"><i class="ti-home"></i> <span> Dashboard </span></a>
                            </li>
                            <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'9','1')==0 && \App\Permission::MenuRole(Auth::user()->role_id,'10','1')==0 && \App\Permission::MenuRole(Auth::user()->role_id,'11','1')==0
                            && \App\Permission::MenuRole(Auth::user()->role_id,'12','1')==0 && \App\Permission::MenuRole(Auth::user()->role_id,'13','1')==0) hidden="" @endif class="has_sub">
                                <a href="#" class="waves-effect @if(request()->is('u/transactions*') || request()->is('u/personaltrainer*') 
                                || request()->is('u/kantin*')|| request()->is('u/pengeluaran*') || 
                                request()->is('u/storan*')|| request()->is('u/gymharian*')) active @endif"><i class="ti-money"></i> <span> Transaksi </span></a>
                                <ul class="list-unstyled">
                                <li @if(\App\Permission::SubMenu('9',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/gymharian*'))active @endif">
                                    <a class="@if(request()->is('u/gymharian*')) active @endif" href="/u/gymharian">Member Gym Harian</a>
                                </li>
                                <li @if(\App\Permission::SubMenu('10',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/personaltrainer*')) active @endif">
                                     <a href="/u/personaltrainer">Pendapatan Personal Trainer</a>
                                </li>
                               
                                <li @if(\App\Permission::SubMenu('11',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/kantin*')) active @endif">
                                    <a href="/u/kantin">Pendapatan Kantin</a>
                                </li>
                                <li @if(\App\Permission::SubMenu('12',Auth::user()->role_id) == 0) hidden="" @endif  class="@if(request()->is('u/pengeluaran*')) active @endif">
                                    <a href="/u/pengeluaran">Pengeluaran</a>
                                </li>
                                <li  @if(\App\Permission::SubMenu('13',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/storan*')) active @endif">
                                    <a href="/u/storan">Setoran Ke Bank</a>
                                </li>
                                </ul>
                            </li>
                           <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'14',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'15',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'16',2)==0 
                           && \App\Permission::MenuRole(Auth::user()->role_id,'17',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'18',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'19',2)==0 
                           && \App\Permission::MenuRole(Auth::user()->role_id,'20',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'21',2)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'22',2)==0 
                           && \App\Permission::MenuRole(Auth::user()->role_id,'23',2)==0) hidden="" @endif class="has_sub">
                                <a href="#" class="waves-effect @if(request()->is('u/members*') ||
                                 request()->is('u/cards*') || request()->is('u/trial*')) active @endif"><i class="ti-user"></i> <span> <!-- Member --> Member </span> </a>
                                <ul class="list-unstyled">

                                    <li @if(\App\Permission::SubMenu('14',Auth::user()->role_id) == 0) hidden="" @endif  class="@if(request()->is('u/members*'))active @endif">
                                    
                                        <a  class="@if(request()->is('u/members'))active @endif" href="/u/members">Data Member</a>
                                    
                                    </li>
                                    <li @if(\App\Permission::CreatePer('14',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/create'))active @endif">
                                        <a class="@if(request()->is('u/members'))active @endif" href="/u/members/create">Member Baru</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('16',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/extend*'))active @endif">
                                        <a class="@if(request()->is('u/members/extend')) active @endif" href="/u/members/extend">Perpanjangan Member</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('17',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/activate'))active @endif">
                                        <a class="@if(request()->is('u/members/activate'))active @endif" href="/u/members/activate">Aktifasi Member</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('18',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/attendances'))active @endif">
                                        <a class="@if(request()->is('u/members/attendances'))active @endif" href="/u/members/attendances">Check-in / Check-Out</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('19',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/trial*'))active @endif">
                                        <a class="@if(request()->is('u/trial*')) active @endif" href="/u/trial">Free Trial</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('20',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/cards*'))active @endif">
                                        <a class="@if(request()->is('u/cards*'))active @endif" href="/u/cards">Data Kartu</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('21',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/upload'))active @endif">
                                        <a class="@if(request()->is('u/members/upload')) active @endif" href="/u/members/upload">Upload Member</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('22',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/ex_member'))active @endif">
                                        <a class="@if(request()->is('u/members/ex_member')) active @endif" href="/u/members/ex_member">Upload Perpanjangan Member</a>
                                    </li>
                                    <li @if(\App\Permission::SubMenu('23',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/members/attendances/upload'))active @endif">
                                        <a class="@if(request()->is('u/members/attendances/upload'))active @endif" href="/u/members/attendances/upload">Upload Check-in / Check-Out</a>
                                    </li>
                                    
                                    
                                    <!-- <li><a href="/u/members/activate">Aktifasi Member</a></li>
                                    <li><a href="/u/members/activate">Aktifasi Member</a></li>
                                    <li><a href="/u/members">Data Member</a></li>
                                    <li><a href="/u/card">Data Kartu</a></li> -->
                                </ul>
                            </li>


                           <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'24',3)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'25',3)==0 &&
                           \App\Permission::MenuRole(Auth::user()->role_id,'26',3)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'27',3)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'28',3)==0) hidden="" @endif class="has_sub">
                                <a href="#" class="waves-effect @if(request()->is('u/searchgym') || request()->is('u/gyms*')|| request()->is('u/searchinpackage') || request()->is('u/searchpackage') || request()->is('u/zonas*') || request()->is('u/packages*')
                                || request()->is('u/packageprices*') || request()->is('u/showgym*') || request()->is('u/schedule*')) active @endif"><i class="ti-map-alt"></i> <span> Gym</span> </a>
                                <ul class="list-unstyled">
                                    
                                    <li @if(\App\Permission::SubMenu('24',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/zonas*')) active @endif"><a class="@if(request()->is('u/zonas*')) active @endif" href="/u/zonas">Data Zona</a></li>
                                    <li @if(\App\Permission::SubMenu('25',Auth::user()->role_id) == 0) hidden="" @endif  class="@if(request()->is('u/gyms*') || request()->is('u/searchgym') || request()->is('u/showgym*')) active @endif"><a class="@if(request()->is('u/gyms*')) active @endif" href="/u/gyms">Data Gym</a></li>
                                    <li @if(\App\Permission::SubMenu('26',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/packages*') || request()->is('u/searchinpackage')) active @endif"><a href="/u/packages">Kategori Harga</a></li>
                                    <li @if(\App\Permission::SubMenu('27',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/packageprices*') || request()->is('u/searchpackage')) active @endif"><a href="/u/packageprices">Daftar Harga</a></li>
                                    <li @if(\App\Permission::SubMenu('28',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/schedule*') ) active @endif"><a href="/u/schedule">Jadwal Latihan</a></li>
                                </ul>
                            </li>

                            

                           <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'29',4)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'30',4)==0 && 
                           \App\Permission::MenuRole(Auth::user()->role_id,'31',4)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'31',4)==0 &&
                           \App\Permission::MenuRole(Auth::user()->role_id,'32',4)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'33',4)==0 &&
                           \App\Permission::MenuRole(Auth::user()->role_id,'223',4)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'224',4)==0 &&
                           \App\Permission::MenuRole(Auth::user()->role_id,'225',4)==0) hidden="" @endif class="has_sub">
                                <a href="#" class="waves-effect @if( request()->is('u/tiketsupport*')|| request()->is('u/templateemail') || request()->is('u/listemail*') || request()->is('u/promoinfo*') || request()->is('u/mail*') || request()->is('u/news*') || request()->is('u/events*') || request()->is('u/poolings*')) active @endif"><i class="ti-announcement"></i> <span> Komunitas </span> </a>
                                <ul class="list-unstyled">
                                    <li @if(\App\Permission::SubMenu('29',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/promoinfo*')) active @endif"><a href="/u/promoinfo">Promo Info</a></li>
                                    <li @if(\App\Permission::SubMenu('30',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/news*')) active @endif"><a href="/u/news">News</a></li>
                                    <li @if(\App\Permission::SubMenu('31',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/events*')) active @endif"><a href="/u/events">Events</a></li>
                                    <li @if(\App\Permission::SubMenu('32',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/poolings*')) active @endif"><a href="/u/poolings">Pooling</a></li>
                                     <li @if(\App\Permission::SubMenu('33',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/tiketsupport*')) active @endif"><a href="/u/tiketsupport">Tiket Support</a></li>
                                      <li @if(\App\Permission::SubMenu('223',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/listemail*')) active @endif"><a href="/u/listemail">List Email</a></li>
                                    <li @if(\App\Permission::SubMenu('224',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/mail*')) active @endif"><a href="/u/mail">Kirim Email</a></li>
                                    <li @if(\App\Permission::SubMenu('225',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/templateemail*')) active @endif"><a href="/u/templateemail">Template Email</a></li>
                                </ul>
                            </li>
                            <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'226',5)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'227',5)==0 &&
                            \App\Permission::MenuRole(Auth::user()->role_id,'228',5)==0) hidden="" @endif class="has_sub">
                                <a href="#" class="waves-effect @if(request()->is('u/target*') || request()->is('u/promos*') || request()->is('u/pettycash*') ) active @endif"><i class="ti-map-alt"></i> <span>  Akunting  </span> </a>
                                <ul class="list-unstyled">
                                    <li @if(\App\Permission::SubMenu('226',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/promos*')) active @endif"><a href="/u/promos">Code Promo</a></li>
                                    <li @if(\App\Permission::SubMenu('227',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/pettycash*')) active @endif"><a href="/u/pettycash">Petty Cash</a></li>
                                    <li @if(\App\Permission::SubMenu('228',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/target*')) active @endif"><a href="/u/target">Target Gym</a></li>
                                   
                                </ul>
                            </li>
                           <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'229',6)==0  && \App\Permission::MenuRole(Auth::user()->role_id,'230',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'231',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'232',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'233',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'234',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'235',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'236',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'237',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'238',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'240',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'241',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'242',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'243',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'244',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'245',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'246',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'247',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'248',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'249',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'250',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'251',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'252',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'253',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'254',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'255',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'256',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'257',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'258',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'259',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'260',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'261',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'262',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'263',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'264',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'265',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'266',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'267',6)==0
                           && \App\Permission::MenuRole(Auth::user()->role_id,'268',6)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'269',6)==0) hidden="" @endif class="has_sub">
                               <a href="#" class="waves-effect @if(request()->is('u/report*')) active @endif"><i class="ti-printer"></i> <span> Laporan </span> </a>
                                <ul class="list-unstyled">
                                   
                                            <li @if(\App\Permission::SubMenu('229',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/member*')) active @endif"><a href="/u/report/member">Member</a></li>
                                            <li @if(\App\Permission::SubMenu('230',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/memberbaru*')) active @endif"><a href="/u/report/memberbaru">Member Baru</a></li>
                                            <li @if(\App\Permission::SubMenu('231',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newmembervs*')) active @endif"><a href="/u/report/newmembervs">Member Baru Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('232',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newmemberyear*')) active @endif"><a href="/u/report/newmemberyear">Member Baru Tahun Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('233',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newmemberyearvs*')) active @endif"><a href="/u/report/newmemberyearvs">Member Baru Tahun Periodik Perbandingan</a></li>
                                            <li @if(\App\Permission::SubMenu('234',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/memberbaruvs*')) active @endif"><a href="/u/report/memberbaruvs">Member Baru Online vs CS</a></li>
                                            <li @if(\App\Permission::SubMenu('235',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/extends*')) active @endif"><a href="/u/report/extends">Member Perpanjangan</a></li>
                                            <li @if(\App\Permission::SubMenu('236',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newextendsvs*')) active @endif"><a href="/u/report/newextendsvs">Member Perpanjangan Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('237',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newextendsyear*')) active @endif"><a href="/u/report/newextendsyear">Member Perpanjangan Tahun Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('238',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newextendsyearvs*')) active @endif"><a href="/u/report/newextendsyearvs">Member Perpanjangan Tahun Periodik Perbandingan</a></li>
                                            <li @if(\App\Permission::SubMenu('239',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/extendsvs*')) active @endif"><a href="/u/report/extendsvs">Member Perpanjangan Online vs CS</a></li>
                                            <li @if(\App\Permission::SubMenu('240',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/expired*')) active @endif"><a href="/u/report/expired">Member Expired</a></li>
                                            <li @if(\App\Permission::SubMenu('241',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newexpiredvs*')) active @endif"><a href="/u/report/newexpiredvs">Member Expired Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('242',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newexpiredyear*')) active @endif"><a href="/u/report/newexpiredyear">Member Expired Tahun Periodik</a></li>
                                            <li @if(\App\Permission::SubMenu('243',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/newexpiredyearvs*')) active @endif"><a href="/u/report/newexpiredyearvs">Member Expired Tahun Periodik Perbandingan</a></li>
                                            <li @if(\App\Permission::SubMenu('244',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/expiredvs*')) active @endif"><a href="/u/report/expiredvs">Member Expired Online vs CS</a></li>
                                            <li @if(\App\Permission::SubMenu('245',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/extendvs*')) active @endif"><a href="/u/report/extendvs">Member Perpanjangan vs Tidak</a></li>
                                            <li @if(\App\Permission::SubMenu('246',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/extendlongvs*')) active @endif"><a href="/u/report/extendlongvs">Member Perpanjangan vs Tidak Perbandingan</a></li>
                                            <li @if(\App\Permission::SubMenu('247',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/longpacket*')) active @endif"><a href="/u/report/longpacket">Perpanjangan Paket yang Sama</a></li>
                                      
                                   
                                            <li @if(\App\Permission::SubMenu('248',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamember*')) active @endif"><a href="/u/report/usiamember"> Usia Member </a></li>
                                            <li @if(\App\Permission::SubMenu('249',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberbaru*')) active @endif"><a href="/u/report/usiamemberbaru"> Usia Member Baru</a></li>
                                            <li @if(\App\Permission::SubMenu('250',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberbarudetail*')) active @endif"><a href="/u/report/usiamemberbarudetail"> Usia Member Baru Detail</a></li>
                                            <li @if(\App\Permission::SubMenu('251',Auth::user()->role_id) == 0) hidden="" @endif fclass="@if(request()->is('u/report/usiamemberbaruvs*')) active @endif"><a href="/u/report/usiamemberbaruvs"> Usia Member Baru Online vs CS</a></li>
                                            <li @if(\App\Permission::SubMenu('252',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberlong*')) active @endif"><a href="/u/report/usiamemberlong"> Usia Member Perpanjangan</a></li>
                                            <li @if(\App\Permission::SubMenu('253',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberlongdetail*')) active @endif"><a href="/u/report/usiamemberlongdetail"> Usia Member Perpanjangan Detail</a></li>
                                            <li @if(\App\Permission::SubMenu('254',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberlongvs*')) active @endif"><a href="/u/report/usiamemberlongvs"> Usia Member Perpanjangan Online vs CS</a></li>
                                            <li @if(\App\Permission::SubMenu('255',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberext*')) active @endif"><a href="/u/report/usiamemberext"> Usia Member Expired</a></li>
                                            <li @if(\App\Permission::SubMenu('256',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberextdetail*')) active @endif"><a href="/u/report/usiamemberextdetail"> Usia Member Expired Detail</a></li>
                                            <li @if(\App\Permission::SubMenu('257',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/usiamemberextvs*')) active @endif"><a href="/u/report/usiamemberextvs"> Usia Member Expired Online vs CS</a></li>
                                      
                                    <li @if(\App\Permission::SubMenu('258',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/income*')) active @endif"><a href="/u/report/income">Pendapatan</a></li>
                                    <li @if(\App\Permission::SubMenu('259',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/pendapatannew*')) active @endif"><a href="/u/report/pendapatannew">Pendapatan Member Baru</a></li>
                                    <li @if(\App\Permission::SubMenu('260',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/pendapatanlong*')) active @endif"><a href="/u/report/pendapatanlong">Pendapatan Member Perpanjangan</a></li>
                                    <li @if(\App\Permission::SubMenu('261',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/pendapatanbayar*')) active @endif"><a href="/u/report/pendapatanbayar">Pendapatan By Cara Bayar</a></li>
                                    <li @if(\App\Permission::SubMenu('262',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/incomevs*')) active @endif"><a href="/u/report/incomevs">Perbandingan Pendapatan</a></li>
                                    <li @if(\App\Permission::SubMenu('263',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/reportkhusus*')) active @endif"><a href="/u/report/reportkhusus">Report Khusus</a></li>
                                    <li @if(\App\Permission::SubMenu('264',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/checkin*')) active @endif"><a href="/u/report/checkin">Check In / Check Out</a></li>
                                    <li @if(\App\Permission::SubMenu('265',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/analisapendapatan*')) active @endif"><a href="/u/report/analisapendapatan">Analisa Pendapatan</a></li>
                                     <li @if(\App\Permission::SubMenu('266',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/promo*')) active @endif"><a href="/u/report/promo">Promo</a></li>
                                    <li @if(\App\Permission::SubMenu('267',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/promovs*')) active @endif"><a href="/u/report/promovs">Perbandingan Promo</a></li>
                                    <li @if(\App\Permission::SubMenu('268',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/incomeday*')) active @endif"><a href="/u/report/incomeday">Laporan Pendapatan Harian</a></li>
                                    <li @if(\App\Permission::SubMenu('269',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/report/slipsetoran*')) active @endif"><a href="/u/report/slipsetoran">Rekap Slip Setoran Bank</a></li>
                                    
                                   <!-- <li><a href="">Member Expired</a></li>
                                    <li><a href="">Statistik Member Expired</a></li>
                                    <li><a href="">Member Extend</a></li>-->
                                    
                                    
                                    <!--<li><a href="">Dekade Kelahiran Member</a></li>-->
                                  <!--  <li><a href="">Member register Via </a></li>
                                    <li><a href="">Statistic Member register Via </a></li>
                                    <li><a href=""> Member extend Via </a></li>
                                    <li><a href="">Statistic Member extend Via </a></li>-->
                                    
                                   <!-- <li><a href="">Statistic Member usia Via </a></li>-->
                                    
                                   <!-- <li><a href="">Pendapatan berdasarkan Pembayaran </a></li>
                                    <li><a href="">Pendapatan Per Periode </a></li>
                                    <li><a href="">Pendapatan Paket Gym </a></li>
                                    <li><a href="">Statistik Pendapatan Paket Gym </a></li>
                                    <li><a href="">Statistik Pendapatan Paket Gym </a></li>-->
                                    
                                   
                                    
<!--                                    <li><a href="/u/transactions/create">Transaksi Baru</a></li>
                                    <li><a href="/u/transactions">Laporan</a></li>-->
                                </ul>
                            </li>
                           
                            <li @if(\App\Permission::MenuRole(Auth::user()->role_id,'271',7) == 0 && \App\Permission::MenuRole(Auth::user()->role_id,'270',7)==0 && \App\Permission::MenuRole(Auth::user()->role_id,'272',7)==0) hidden="" @endif class="has_sub">
                            
                            
                                <a href="#" class="waves-effect @if(request()->is('u/roles*') || request()->is('u/privileges*') || request()->is('u/profile*')) active @endif"><i class="ti-settings"></i> <span> <!-- Pengaturan -->Pengaturan </span> </a>
                                <ul class="list-unstyled">
                                    <li @if(\App\Permission::SubMenu('270',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/roles*')) active @endif"><a href="/u/roles">User</a></li>
                                    <li @if(\App\Permission::SubMenu('271',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/privileges*')) active @endif"><a href="/u/privileges">Role</a></li>
                                    <li @if(\App\Permission::SubMenu('272',Auth::user()->role_id) == 0) hidden="" @endif class="@if(request()->is('u/profile*')) active @endif"><a href="/u/profile">Profile</a></li>
                                    
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
        <script src="/assets/js/regym.js"></script>
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