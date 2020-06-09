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
            <table border="1" id="audit_trail" width="100%" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th style="width:20%; text-align: center !important;">Modul</th>
                        <th style="width:40%; text-align: center !important;">Aktiviti</th>
                        <th style="width:20%; text-align: center !important;">Tindakan Daripada</th>
                        <th style="width:20%; text-align: center !important;">Tarikh Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($audit_trail) > 0)
                    @foreach ($audit_trail as $audit_trails)
                    <?php $user = User::find($audit_trails->audit_by); ?>
                    <tr>
                        <td>{{$audit_trails->module}}</td>
                        <td>{{$audit_trails->remarks}}</td>
                        <td>{{$user->full_name}}</td>
                        <td>{{date('d/m/Y H:i:s', strtotime($audit_trails->created_at))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" style="text-align: center">Tiada data</td>
                    </tr>
                    @endif
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

@stop