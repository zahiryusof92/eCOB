@extends('layout.malay_layout.print')

@section('content')

<?php
$company = Company::find(Auth::user()->company_id);
?>

<table width="100%">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td class="text-center">
                        <h4 class="margin-bottom-0">
                            <img src="{{asset($company->image_url)}}" height="100px;" alt="">
                        </h4> 
                    </td>
                    <td>
                        <h5 class="margin-bottom-10">
                            {{$company->name}}
                        </h5>
                        <h6 class="margin-bottom-0">
                            {{$title}}
                        </h6>
                    </td>                            
                </tr>
            </table>
            <hr/>
            <table class="table" id="file_location_list" width="100%" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th style="width:20%; text-align: center !important;">Parlimen</th>
                        <th style="width:20%; text-align: center !important;">DUN</th>
                        <th style="width:20%; text-align: center !important;">Taman</th>
                        <th style="width:20%; text-align: center !important;">No. Fail</th>
                        <th style="width:20%; text-align: center !important;">Kawasan Pemajuan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <hr/>
            <table width="100%">
                <tr>
                    <td>
                        <p><b>CONFIDENTIAL</b></p>
                    </td>
                    <td class="pull-right">
                        <p>Print On: {{date('d/m/Y h:i:s A', strtotime("now"))}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- End  -->

<!-- Page Scripts -->
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#file_location_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getFileByLocation')}}",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "pageLength": 50,
            order: [[0, "asc"]],
            responsive: false
        });
    });
</script>

@stop