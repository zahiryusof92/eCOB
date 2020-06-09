@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 38) {
        $update_permission = $permission->update_permission;
    }
}
?>

<div class="page-content-inner">
    <section class="panel panel-with-borders">
        <div class="panel-heading">
            <h3>{{$title}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <form>
                        <div class="row">
                            @if (Auth::user()->getAdmin())
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>COB</label>
                                    <select id="company" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @foreach ($cob as $companies)
                                        <option value="{{ $companies->short_name }}">{{ $companies->name }} ({{ $companies->short_name }})</option>
                                        @endforeach                                    
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Month</label>
                                    <select id="month" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @foreach ($month as $months)
                                        <option value="{{ $months }}">{{ $months }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select id="year" class="form-control select2">
                                        <option value="">Please Select</option>
                                        @for ($i = 2012; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>                            
                        </div>  
                    </form>
                </div>
            </div>
            
            <hr/>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-hover nowrap" id="filelist" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20%;">Finance Management</th>
                                <th style="width:20%;">Strata</th>
                                <th style="width:20%;">COB</th>
                                <th style="width:10%;">Month</th>
                                <th style="width:10%;">Year</th>
                                <th style="width:10%;">Status</th>
                                @if ($update_permission == 1)
                                <th style="width:10%;">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </section>    
    <!-- End  -->
</div>

<!-- Page Scripts -->
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#filelist').DataTable({
            "sAjaxSource": "{{URL::action('FinanceController@getFinanceList')}}",
            "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]],
            "order": [[0, "asc"]],
            responsive: true
        });
        
        $('#company').on('change', function () {
            oTable.columns(2).search(this.value).draw();
        });        
        $('#month').on('change', function () {
            oTable.columns(3).search(this.value).draw();
        });
        $('#year').on('change', function () {
            oTable.columns(4).search(this.value).draw();
        });       
    });

    function inactiveFinanceList(id) {
        $.ajax({
            url: "{{ URL::action('FinanceController@inactiveFinanceList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('FinanceController@financeList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function activeFinanceList(id) {
        $.ajax({
            url: "{{ URL::action('FinanceController@activeFinanceList') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data.trim() == "true") {
                    bootbox.alert("<span style='color:green;'>Status update successfully!</span>", function () {
                        window.location = "{{URL::action('FinanceController@financeList')}}";
                    });
                } else {
                    bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                }
            }
        });
    }

    function deleteFinanceList(id) {
        bootbox.confirm("Are you sure want to delete this file?", function (result) {
            if (result) {
                $.ajax({
                    url: "{{ URL::action('FinanceController@deleteFinanceList') }}",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.trim() == "true") {
                            bootbox.alert("<span style='color:green;'>Delete successfully!</span>", function () {
                                window.location = "{{URL::action('FinanceController@financeList')}}";
                            });
                        } else {
                            bootbox.alert("<span style='color:red;'>An error occured while processing. Please try again.</span>");
                        }
                    }
                });
            }
        });
    }
</script>

@stop