@extends('layout.english_layout.default')

@section('content')

<?php
$update_permission = 0;

foreach ($user_permission as $permission) {
    if ($permission->submodule_id == 3) {
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
                <div class="col-lg-12"> 
                    <button onclick="window.location = '{{ URL::action('AdminController@addFinanceSupport') }}'" type="button" class="btn btn-primary">
                        Add Finance Support
                    </button>
                    <br/><br/>
                    <table class="table table-hover nowrap" id="filelist" width="100%">
                        <thead>
                            <tr>
                                <th style="width:30%;">File No.</th>
                                <th style="width:10%;">Date</th>
                                <th style="width:10%;">Bantuan Name</th>
                                <th style="width:10%;">Bantuan Amount</th>
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
            "sAjaxSource": "{{URL::action('AdminController@getFinanceSupportList')}}",
            "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]],
            "order": [[ 3, "asc" ]],
            responsive: true
        });
    }); 
    
</script>

@stop