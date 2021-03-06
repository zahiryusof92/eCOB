<!-- BEGIN TOP NAVIGATION -->
<?php
$company = Company::find(Auth::user()->company_id);

if ($company->is_main != 1) {
    $cob_logout = strtolower($company->short_name);
} else {
    $cob_logout = '';
}

$swith_lang = false;
?>

<nav class="top-menu">
    <div class="menu-icon-container hidden-md-up">
        <div class="animate-menu-button left-menu-toggle">
            <div><!-- --></div>
        </div>
    </div>
    <div class="menu">
        <div class="menu-user-block margin-top-5">
            @if ($swith_lang)
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle dropdown-inline-button" data-toggle="dropdown" aria-expanded="false">
                    <i class="dropdown-inline-button-icon fa fa-globe"></i>
                    <span class="hidden-lg-down">English</span>
                    <span class="caret"></span>
                </a>               
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                    <a class="dropdown-item" href="{{ url('/changeLanguage/ms') }}">Bahasa Melayu</a>
                    <a class="dropdown-item active" href="{{ url('/changeLanguage/en') }}">English</a>                    
                </ul>                
            </div>
            @endif
            <div class="menu-user-block">
                <div class="dropdown dropdown-avatar">
                    <a href="javascript: void(0);" class="dropdown-toggle dropdown-inline-button" data-toggle="dropdown" aria-expanded="false">
                        <i class="dropdown-inline-button-icon icmn-user"></i>
                        <span class="hidden-lg-down">{{Auth::user()->full_name}}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                        <a class="dropdown-item" href="{{URL::action('AdminController@home')}}"><i class="dropdown-icon icmn-home2"></i> Home</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{URL::action('UserController@editProfile')}}"><i class="dropdown-icon icmn-profile"></i> Edit Profile</a>
                        <a class="dropdown-item" href="{{URL::action('UserController@changePassword')}}"><i class="dropdown-icon fa fa-key"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        @if (!empty($cob_logout))
                        <a class="dropdown-item" href="{{ url('/' . $cob_logout . '/logout') }}"><i class="dropdown-icon icmn-exit"></i> Logout</a>
                        @else
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i class="dropdown-icon icmn-exit"></i> Logout</a>
                        @endif
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
                <h6 class="margin-top-10">eCOB System - {{$company->name}}</h6>
            </div>
        </div>
    </div>    
</nav>
<!-- END TOP NAVIGATION -->

