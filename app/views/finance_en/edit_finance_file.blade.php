@extends('layout.english_layout.default')

@section('content')

<?php
$insert_permission = 0;
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 38) {
        $access_permission = $permission->access_permission;
        $insert_permission = $permission->insert_permission;
        $delete_permission = $permission->delete_permission;
    }
}

$finance_file_id = $financefiledata->id;
?>

<style>
    .padding-form {
        padding-left: 20px !important;
        padding-top: 15px !important;
    }
    .padding-table {
        padding-top: 15px !important;
    }
</style>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Finance Management</td>
                                <td>{{ $financefiledata->file->file_no }}</td>
                                <td>Finance ManagementID</td>
                                <td>{{ $financefiledata->id }}</td>
                            </tr>
                            <tr>
                                <td>Year</td>
                                <td>{{ $financefiledata->year }}</td>
                                <td>Month</td>
                                <td>{{ $financefiledata->month }}</td>
                            </tr>
                            <tr>
                                <td>Strata</td>
                                <td colspan="3">{{ $financefiledata->file->strata->strataName() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color: red; font-style: italic;">* Mandatory Fields</label>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'home') ? 'active' : '' }}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Check</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'summary') ? 'active' : '' }}" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="false">Summary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'mfreport') ? 'active' : '' }}" id="mfreport-tab" data-toggle="tab" href="#mfreport" role="tab" aria-controls="mfreport" aria-selected="false">MF Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'sfreport') ? 'active' : '' }}" id="sfreport-tab" data-toggle="tab" href="#sfreport" role="tab" aria-controls="sfreport" aria-selected="false">SF Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'income') ? 'active' : '' }}" id="income-tab" data-toggle="tab" href="#income" role="tab" aria-controls="income" aria-selected="false">Income</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'utility') ? 'active' : '' }}" id="utility-tab" data-toggle="tab" href="#utility" role="tab" aria-controls="utility" aria-selected="false">Utility</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'contractexp') ? 'active' : '' }}" id="contractexp-tab" data-toggle="tab" href="#contractexp" role="tab" aria-controls="contractexp" aria-selected="false">Contract Exp.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'repair') ? 'active' : '' }}" id="repair-tab" data-toggle="tab" href="#repair" role="tab" aria-controls="repair" aria-selected="false">Repair</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'vandalisme') ? 'active' : '' }}" id="vandalisme-tab" data-toggle="tab" href="#vandalisme" role="tab" aria-controls="vandalisme" aria-selected="false">Vandalisme</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'staff') ? 'active' : '' }}" id="staff-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="false">Staff</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($tab == 'admin') ? 'active' : '' }}" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Admin</a>
                        </li>
                    </ul>
                    <div class="tab-content padding-vertical-20" id="myTabContent">
                        <div class="tab-pane fade {{ ($tab == 'home') ? 'show active in' : '' }}" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @include('finance_en.edit_finance_file.form_check')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'summary') ? 'show active in' : '' }}" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                            @include('finance_en.edit_finance_file.form_summary')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'mfreport') ? 'show active in' : '' }}" id="mfreport" role="tabpanel" aria-labelledby="mfreport-tab">
                            @include('finance_en.edit_finance_file.form_mfreport')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'income') ? 'show active in' : '' }}" id="income" role="tabpanel" aria-labelledby="income-tab">
                            @include('finance_en.edit_finance_file.form_income')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'sfreport') ? 'show active in' : '' }}" id="sfreport" role="tabpanel" aria-labelledby="sfreport-tab">
                            @include('finance_en.edit_finance_file.form_sfreport')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'utility') ? 'show active in' : '' }}" id="utility" role="tabpanel" aria-labelledby="utility-tab">
                            @include('finance_en.edit_finance_file.form_utility')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'contractexp') ? 'show active in' : '' }}" id="contractexp" role="tabpanel" aria-labelledby="contractexp-tab">
                            @include('finance_en.edit_finance_file.form_contractexp')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'repair') ? 'show active in' : '' }}" id="repair" role="tabpanel" aria-labelledby="repair-tab">
                            @include('finance_en.edit_finance_file.form_repair')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'vandalisme') ? 'show active in' : '' }}" id="vandalisme" role="tabpanel" aria-labelledby="vandalisme-tab">
                            @include('finance_en.edit_finance_file.form_vandalisme')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'staff') ? 'show active in' : '' }}" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                            @include('finance_en.edit_finance_file.form_staff')
                        </div>
                        <div class="tab-pane fade {{ ($tab == 'admin') ? 'show active in' : '' }}" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                            @include('finance_en.edit_finance_file.form_admin')
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
</div>

<!-- Page Scripts -->
<script>
    $(function () {
        $('#date').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'DD/MM/YYYY',
        }).on('dp.change', function () {
            let currentDate = $(this).val().split('/');
//            console.log(currentDate);
            $("#mirror_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
        });
    });
</script>

@stop