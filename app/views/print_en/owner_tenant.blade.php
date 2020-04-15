@extends('layout.english_layout.print')

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
                            <img src="{{ asset($company->image_url) }}" height="100px;" alt="">
                        </h4> 
                    </td>
                    <td>
                        <h5 class="margin-bottom-10">
                            {{ $company->name }}
                        </h5>
                        <h6 class="margin-bottom-0">
                            {{ $title }}
                        </h6>
                    </td>                            
                </tr>
            </table>

            <hr/>

            @if ($type == 'all')
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th style="width:20%; text-align: center !important; vertical-align:middle !important;">FILE NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">UNIT NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">SHARE UNIT</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">OWNER</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">NRIC</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">PHONE NO</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">EMAIL</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">RACE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($owner))
                    @foreach ($owner as $owners)
                    <tr>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->file->file_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->unit_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->unit_share }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->owner_name }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->ic_company_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->phone_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->email }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->race->name }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" style="text-align: center !important; vertical-align:middle !important;">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th style="width:25%; text-align: center !important; vertical-align:middle !important;">FILE NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">UNIT NO</th>
                        <th style="width:20%; text-align: center !important; vertical-align:middle !important;">OWNER</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">NRIC</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">PHONE NO</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">EMAIL</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">RACE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($tenant))
                    @foreach ($tenant as $tenants)
                    <tr>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->file->file_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->unit_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->tenant_name }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->ic_company_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->phone_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->email }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->race->name }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center !important; vertical-align:middle !important;">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @elseif ($type == 'owner')           
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th style="width:20%; text-align: center !important; vertical-align:middle !important;">FILE NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">UNIT NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">SHARE UNIT</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">OWNER</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">NRIC</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">PHONE NO</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">EMAIL</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">RACE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($owner))
                    @foreach ($owner as $owners)
                    <tr>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->file->file_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->unit_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->unit_share }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->owner_name }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->ic_company_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->phone_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->email }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $owners->race->name }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" style="text-align: center !important; vertical-align:middle !important;">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @else
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th style="width:25%; text-align: center !important; vertical-align:middle !important;">FILE NO</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">UNIT NO</th>
                        <th style="width:20%; text-align: center !important; vertical-align:middle !important;">OWNER</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">NRIC</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">PHONE NO</th>
                        <th style="width:15%; text-align: center !important; vertical-align:middle !important;">EMAIL</th>
                        <th style="width:10%; text-align: center !important; vertical-align:middle !important;">RACE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($tenant))
                    @foreach ($tenant as $tenants)
                    <tr>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->file->file_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->unit_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->tenant_name }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->ic_company_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->phone_no }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->email }}</td>
                        <td style="text-align: center !important; vertical-align:middle !important;">{{ $tenants->race->name }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center !important; vertical-align:middle !important;">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @endif

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

@stop