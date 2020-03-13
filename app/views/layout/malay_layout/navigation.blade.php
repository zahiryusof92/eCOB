<script>
    $(document).ready(function () {
        $("#{{ $panel_nav_active }}").addClass("left-menu-list-opened");
        $("#{{ $main_nav_active }}").css("display", "block");
        $("#{{ $sub_nav_active }}").addClass("left-menu-list-active");
    });
</script>

<?php
$access_permission1 = 0;
$access_permission2 = 0;
$access_permission3 = 0;
$access_permission4 = 0;
$access_permission5 = 0;
$access_permission6 = 0;
$access_permission7 = 0;
$access_permission8 = 0;
$access_permission9 = 0;
$access_permission10 = 0;
$access_permission11 = 0;
$access_permission12 = 0;
$access_permission13 = 0;
$access_permission14 = 0;
$access_permission15 = 0;
$access_permission16 = 0;
$access_permission17 = 0;
$access_permission18 = 0;
$access_permission19 = 0;
$access_permission20 = 0;
$access_permission21 = 0;
$access_permission22 = 0;
$access_permission23 = 0;
$access_permission24 = 0;
$access_permission29 = 0;
$access_permission30 = 0;
$access_permission31 = 0;
$access_permission32 = 0;
$access_permission33 = 0;
$access_permission34 = 0;
$access_permission35 = 0;
$access_permission36 = 0;
$access_permission37 = 0;
$access_permission38 = 0;
$access_permission39 = 0;

$user_permission = AccessGroup::getAccessPermission(Auth::user()->id);

if ($user_permission) {
//    echo "<pre>" . print_r($user_permission, 1) . "</pre>";

    foreach ($user_permission as $permission) {
        if ($permission->submodule_id == 1) {
            $access_permission1 = $permission->access_permission;
        }
        if ($permission->submodule_id == 2) {
            $access_permission2 = $permission->access_permission;
        }
        if ($permission->submodule_id == 3) {
            $access_permission3 = $permission->access_permission;
        }
        if ($permission->submodule_id == 4) {
            $access_permission4 = $permission->access_permission;
        }
        if ($permission->submodule_id == 5) {
            $access_permission5 = $permission->access_permission;
        }
        if ($permission->submodule_id == 6) {
            $access_permission6 = $permission->access_permission;
        }
        if ($permission->submodule_id == 7) {
            $access_permission7 = $permission->access_permission;
        }
        if ($permission->submodule_id == 8) {
            $access_permission8 = $permission->access_permission;
        }
        if ($permission->submodule_id == 9) {
            $access_permission9 = $permission->access_permission;
        }
        if ($permission->submodule_id == 10) {
            $access_permission10 = $permission->access_permission;
        }
        if ($permission->submodule_id == 11) {
            $access_permission11 = $permission->access_permission;
        }
        if ($permission->submodule_id == 12) {
            $access_permission12 = $permission->access_permission;
        }
        if ($permission->submodule_id == 13) {
            $access_permission13 = $permission->access_permission;
        }
        if ($permission->submodule_id == 14) {
            $access_permission14 = $permission->access_permission;
        }
        if ($permission->submodule_id == 15) {
            $access_permission15 = $permission->access_permission;
        }
        if ($permission->submodule_id == 16) {
            $access_permission16 = $permission->access_permission;
        }
        if ($permission->submodule_id == 17) {
            $access_permission17 = $permission->access_permission;
        }
        if ($permission->submodule_id == 18) {
            $access_permission18 = $permission->access_permission;
        }
        if ($permission->submodule_id == 19) {
            $access_permission19 = $permission->access_permission;
        }
        if ($permission->submodule_id == 20) {
            $access_permission20 = $permission->access_permission;
        }
        if ($permission->submodule_id == 21) {
            $access_permission21 = $permission->access_permission;
        }
        if ($permission->submodule_id == 22) {
            $access_permission22 = $permission->access_permission;
        }
        if ($permission->submodule_id == 23) {
            $access_permission23 = $permission->access_permission;
        }
        if ($permission->submodule_id == 24) {
            $access_permission24 = $permission->access_permission;
        }
        if ($permission->submodule_id == 25) {
            $access_permission25 = $permission->access_permission;
        }
        if ($permission->submodule_id == 26) {
            $access_permission26 = $permission->access_permission;
        }
        if ($permission->submodule_id == 27) {
            $access_permission27 = $permission->access_permission;
        }
        if ($permission->submodule_id == 28) {
            $access_permission28 = $permission->access_permission;
        }
        if ($permission->submodule_id == 29) {
            $access_permission29 = $permission->access_permission;
        }
        if ($permission->submodule_id == 30) {
            $access_permission30 = $permission->access_permission;
        }
        if ($permission->submodule_id == 31) {
            $access_permission31 = $permission->access_permission;
        }
        if ($permission->submodule_id == 32) {
            $access_permission32 = $permission->access_permission;
        }
        if ($permission->submodule_id == 33) {
            $access_permission33 = $permission->access_permission;
        }
        if ($permission->submodule_id == 34) {
            $access_permission34 = $permission->access_permission;
        }
        if ($permission->submodule_id == 35) {
            $access_permission35 = $permission->access_permission;
        }
        if ($permission->submodule_id == 36) {
            $access_permission36 = $permission->access_permission;
        }
        /*
         * Finance
         */
        if ($permission->submodule_id == 37) {
            $access_permission37 = $permission->access_permission;
        }
        if ($permission->submodule_id == 38) {
            $access_permission38 = $permission->access_permission;
        }
        if ($permission->submodule_id == 39) {
            $access_permission39 = $permission->access_permission;
        }
        /*
         * End Finance
         */
    }
}

$company = Company::find(Auth::user()->company_id);
if (!Auth::user()->getAdmin()) {
    $pending = Files::where('created_by', Auth::user()->id)->where('status', 0)->where('is_deleted', 0)->count();
} else {
    $pending = Files::where('status', 0)->where('is_deleted', 0)->count();
}
?>
<!-- BEGIN SIDE NAVIGATION -->
<nav class="left-menu" left-menu>
    <div class="logo-container">
        <div class="logo">
            <a href="{{URL::action('AdminController@home')}}"><img src="{{asset($company->image_url)}}" alt=""/></a>
        </div>
    </div>
    <div class="left-menu-inner scroll-pane">
        <div id="image_nav">

            @if ($image == "")        
            @if ($company->nav_image_url != "")
            <img src="{{asset($company->nav_image_url)}}" style="width: 100%;" alt="" />     
            @endif     
            @else
            <img src="{{asset($image)}}" style="width: 100%;" alt="" />
            @endif
        </div>
        <ul class="left-menu-list left-menu-list-root list-unstyled">

            @if ($access_permission1 == 1 || $access_permission2 == 1 || $access_permission3 == 1 || $access_permission36 == 1 || $access_permission37 == 1 || $access_permission38 == 1 || $access_permission39 == 1)
            <li class="left-menu-list-submenu" id="cob_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-file"><!-- --></i>
                    Pengurusan COB
                </a>
                <ul class="left-menu-list list-unstyled" id="cob_main">
                    @if ($access_permission1 == 1)
                    <li id="prefix_file">
                        <a class="left-menu-link" href="{{URL::action('AdminController@filePrefix')}}">
                            Awalan Fail COB
                        </a>
                    </li>
                    @endif
                    @if($access_permission2 == 1)
                    <li id="add_cob">
                        <a class="left-menu-link" href="{{URL::action('AdminController@addFile')}}">
                            Tambah Fail COB
                        </a>
                    </li>
                    @endif
                    @if ($access_permission3 == 1)
                    <li id="cob_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@fileList')}}">
                            Senarai Fail COB <span class="label left-menu-label label-danger">{{$pending}} menunggu</span>
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission36 == 1)
                    <li id="add_finance_list">
                        <a class="left-menu-link" href="#">
                            COB File List Before VP
                        </a>
                    </li>
                    @endif
                    @if ($access_permission37 == 1)
                    <li id="add_finance_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@addFinanceFileList')}}">
                            Add Finance File List
                        </a>
                    </li>
                    @endif
                    @if ($access_permission38 == 1)
                    <li id="finance_file_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@financeList')}}">
                            Finance File List
                        </a>
                    </li>
                    @endif
                    @if ($access_permission39 == 1)
                    <li id="finance_support_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@financeSupport')}}">
                            Finance Support
                        </a>
                    </li>  
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission4 == 1 || $access_permission5 == 1 || $access_permission6 == 1 || $access_permission7 == 1)
            <li class="left-menu-list-submenu" id="admin_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-user"><!-- --></i>
                    Pentadbiran
                </a>
                <ul class="left-menu-list list-unstyled" id="admin_main">
                    @if ($access_permission4 == 1)
                    <li id="profile_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@editCompany')}}">
                            Edit Profil Organisasi
                        </a>
                    </li>
                    @endif
                    @if ($access_permission5 == 1)
                    <li id="access_group_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@accessGroups')}}">
                            Akses Kumpulan
                        </a>
                    </li>
                    @endif
                    @if ($access_permission6 == 1)
                    <li id="user_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@user')}}">
                            Pengurusan Pengguna <span class="label left-menu-label label-danger">{{User::where('status', 0)->where('is_deleted', 0)->count()}} menunggu</span>
                        </a>
                    </li>  
                    @endif
                    @if ($access_permission7 == 1)
                    <li id="memo_maintenence_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@memo')}}">
                            Pengurusan Memo
                        </a>
                    </li>  
                    <li id="form_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@form')}}">
                            Form
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission8 == 1 || $access_permission9 == 1 || $access_permission10 == 1 || $access_permission11 == 1 ||
            $access_permission12 == 1 || $access_permission13 == 1 || $access_permission14 == 1 || $access_permission15 == 1 ||
            $access_permission16 == 1 || $access_permission17 == 1 || $access_permission18 == 1 || $access_permission19 == 1 ||
            $access_permission20 == 1 || $access_permission21 == 1 || $access_permission22 == 1 || $access_permission23 == 1)
            <li class="left-menu-list-submenu" id="master_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-gears"><!-- --></i>
                    Pengurusan Master Data
                </a>
                <ul class="left-menu-list list-unstyled" id="master_main">                    
                    @if ($access_permission8 == 1)
                    <li id="country_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@country')}}">
                            Negara
                        </a>
                    </li>
                    @endif
                    @if ($access_permission9 == 1)
                    <li id="state_list"><a class="left-menu-link" href="{{URL::action('AdminController@state')}}">
                            Negeri
                        </a>
                    </li>
                    @endif
                    @if ($access_permission10 == 1)
                    <li id="area_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@area')}}">
                            Daerah
                        </a>
                    </li>
                    @endif
                    @if ($access_permission11 == 1)
                    <li id="city_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@city')}}">
                            Bandar
                        </a>
                    </li>
                    @endif
                    @if ($access_permission12 == 1)
                    <li id="category_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@category')}}">
                            Kategori
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission13 == 1)
                    <li id="land_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@landTitle')}}">
                            Jenis Tanah
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission14 == 1)
                    <li id="developer_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@developer')}}">
                            Pemaju
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission15 == 1)
                    <li id="agent_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@agent')}}">
                            Ejen
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission16 == 1)
                    <li id="parliament_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@parliment')}}">
                            Parlimen
                        </a>
                    </li>
                    @endif
                    @if ($access_permission17 == 1)
                    <li id="dun_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@dun')}}">
                            DUN
                        </a>
                    </li>
                    @endif
                    @if ($access_permission18 == 1)
                    <li id="park_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@park')}}">
                            Taman
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission19 == 1)
                    <li id="memo_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@memoType')}}">
                            Jenis Memo
                        </a>
                    </li>
                    @endif
                    @if ($access_permission20 == 1)
                    <li id="designation_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@designation')}}">
                            Jawatan
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission21 == 1)
                    <li id="unit_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@unitMeasure')}}">
                            Unit Ukuran
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission22 == 1)
                    <li id="formtype_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@formtype')}}">
                            Form Type
                        </a>
                    </li>
                    @endif
                    @if ($access_permission23 == 1)
                    <li id="documenttype_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@documenttype')}}">
                            Document Type
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission24 == 1 || $access_permission25 == 1 || $access_permission26 == 1 || $access_permission27 == 1 || $access_permission28 == 1 || $access_permission29 == 1)
            <li class="left-menu-list-submenu" id="reporting_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-file-pdf-o"><!-- --></i>
                    Laporan
                </a>
                <ul class="left-menu-list list-unstyled" id="reporting_main">
                    @if ($access_permission24 == 1)
                    <li id="audit_trail_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@auditTrail')}}">
                            Audit Trail
                        </a>
                    </li>
                    @endif
                    @if ($access_permission25 == 1)
                    <li id="file_by_location_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@fileByLocation')}}">
                            Fail Mengikut Lokasi
                        </a>
                    </li>
                    @endif
                    @if ($access_permission26 == 1)
                    <li id="rating_summary_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@ratingSummary')}}">
                            Penakrifan Bintang
                        </a>
                    </li>  
                    @endif
                    @if ($access_permission27 == 1)
                    <li id="management_summary_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@managementSummary')}}">
                            Rumusan Pengurusan
                        </a>
                    </li> 
                    @endif
                    @if ($access_permission28 == 1)
                    <li id="cob_file_management_list">
                        <a class="left-menu-link" href="{{URL::action('AdminController@cobFileManagement')}}">
                            Fail COB / Pengurusan (%)
                        </a>
                    </li>  
                    @endif
                    @if ($access_permission29 == 1)
                    <li id="lphs_report_strata_form">
                        <a class="left-menu-link" href="{{URL::action('ReportController@reportStrataProfile')}}">
                            Laporan Strata Profile
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission30 == 1 || $access_permission31 == 1 || $access_permission32 == 1 || $access_permission33 == 1)
            <li class="left-menu-list-submenu" id="agm_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-sitemap"><!-- --></i>
                    AGM Submission
                </a>
                <ul class="left-menu-list list-unstyled" id="agm_main">
                    @if ($access_permission30 == 1)
                    <li id="agmdesignsub_list">
                        <a class="left-menu-link" href="{{URL::action('AgmController@AJK')}}">
                            Designation Submission
                        </a>
                    </li>
                    @endif
                    @if ($access_permission31 == 1)
                    <li id="agmpurchasesub_list">
                        <a class="left-menu-link" href="{{URL::action('AgmController@agmPurchaseSub')}}">
                            Purchaser Submission
                        </a>
                    </li>
                    @endif
                    @if ($access_permission32 == 1)
                    <li id="agmpurchasesub_list">
                        <a class="left-menu-link" href="#">
                            Upload of Minutes
                        </a>
                    </li>
                    @endif
                    @if ($access_permission33 == 1)
                    <li id="agmpurchasesub_list">
                        <a class="left-menu-link" href="#">
                            Upload Document
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission34 == 1)
            <li class="left-menu-list-submenu" id="form_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-file-text-o"><!-- --></i>
                    Form Management
                </a>
                <ul class="left-menu-list list-unstyled" id="form_main">
                    @if ($access_permission34 == 1)
                    <li id="agmpurchasesub_list">
                        <a class="left-menu-link" href="#">
                            Form Download
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($access_permission35 == 1)
            <li class="left-menu-list-submenu" id="change_cob_panel">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon fa fa-exchange"><!-- --></i>
                    Change COB
                </a>
                <ul class="left-menu-list list-unstyled" id="change_cob_main">
                    @if ($access_permission34 == 1)
                    <?php
                    $jmb = Company::where('is_active', 1)->where('short_name', '!=', '')->where('is_deleted', 0)->orderBy('short_name')->get();
                    ?>

                    @foreach ($jmb as $cob)
                    <li id="{{ $cob->short_name . "_list" }}">
                        <a class="left-menu-link" href='{{ url("cob/get/{$cob->id}") }}'>{{ strtoupper($cob->short_name) }}</a>
                    </li>    
                    @endforeach
                    @endif
                </ul>
            </li>
            @endif

    </div>
</nav>
<!-- END SIDE NAVIGATION -->