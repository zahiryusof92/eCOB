<!-- BEGIN TOP NAVIGATION -->
<?php
$company = Company::first();
?>

<nav class="top-menu">
    <div class="menu-icon-container hidden-md-up">
        <div class="animate-menu-button left-menu-toggle">
            <div><!-- --></div>
        </div>
    </div>
    <div class="menu">
        <div class="menu-user-block margin-top-5">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle dropdown-inline-button" data-toggle="dropdown" aria-expanded="false">
                    <i class="dropdown-inline-button-icon fa fa-globe"></i>
                    <span class="hidden-lg-down">Bahasa Melayu</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                    <a class="dropdown-item active" href="{{URL::action('UserController@changeLanguage',['my'])}}">Bahasa Melayu</a>
                    <a class="dropdown-item" href="{{URL::action('UserController@changeLanguage',['en'])}}">English</a>                    
                </ul>
            </div>
            <div class="menu-user-block">
                <div class="dropdown dropdown-avatar">
                    <a href="javascript: void(0);" class="dropdown-toggle dropdown-inline-button" data-toggle="dropdown" aria-expanded="false">
                        <i class="dropdown-inline-button-icon icmn-user"></i>
                        <span class="hidden-lg-down">{{Auth::user()->full_name}}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                        <a class="dropdown-item" href="{{URL::action('AdminController@home')}}"><i class="dropdown-icon icmn-home2"></i> Laman Utama</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{URL::action('UserController@editProfile')}}"><i class="dropdown-icon icmn-profile"></i> Profil Penyelaras</a>
                        <a class="dropdown-item" href="{{URL::action('UserController@changePassword')}}"><i class="dropdown-icon fa fa-key"></i> Tukar Kata Laluan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{URL::action('UserController@logout')}}"><i class="dropdown-icon icmn-exit"></i> Daftar Keluar</a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu-info-block">
            <div class="row">
<!--                <div class="logo-container">
                    <div class="logo">
                        <img src="{{$company->image_url}}" alt="" style="width: 40px;"/>
                    </div>
                </div>          -->
                <h6 class="margin-top-10">Sistem eCOB - {{$company->name}}</h6>
            </div>
        </div>
    </div>    
</nav>
<!-- END TOP NAVIGATION -->

