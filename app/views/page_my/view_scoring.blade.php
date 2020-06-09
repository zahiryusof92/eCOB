@extends('layout.malay_layout.default')

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
                    <h6>No. Fail: {{$files->file_no}}</h6>
                    <div id="update_files_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewHouse', $files->id)}}">Skim Perumahan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewStrata', $files->id)}}">Kawasan Pemajuan (STRATA)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewManagement', $files->id)}}">Pihak Pengurusan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewMonitoring', $files->id)}}">Pemantauan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewOthers', $files->id)}}">Pelbagai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Pemarkahan Komponen Nilai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@viewBuyer', $files->id)}}">Senarai Pembeli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::action('AdminController@fileApproval', $files->id)}}">Pengesahan</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">
                            <div class="tab-pane active" id="scoring" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php
                                            $scoring = Scoring::where('file_id', $files->id)->where('is_deleted', 0)->count();
                                        ?>
                                        <div class="row">
                                            <table class="table table-hover nowrap" id="scoring_list" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:15%;">Tarikh</th>
                                                        <th style="width:10%;">A (%)</th>
                                                        <th style="width:10%;">B (%)</th>
                                                        <th style="width:10%;">C (%)</th>
                                                        <th style="width:10%;">D (%)</th>
                                                        <th style="width:10%;">E (%)</th>
                                                        <th style="width:10%;">Markah (%)</th>
                                                        <th style="width:15%;">{{ trans('app.forms.rating') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    var oTable;
    $(document).ready(function () {
        oTable = $('#scoring_list').DataTable({
            "sAjaxSource": "{{URL::action('AdminController@getScoring', $files->id)}}",
            "order": [[ 0, "desc" ]],
            "autoWidth": true,
            "scrollX": true,
            "fixedColumns": true
        });
    });

    function addSurveyForm(){
        var addsurvey = $("#add_survey").val();
        if (addsurvey.trim() == "strata_management") {
            $("#add_strata_management_quality").modal("show");
        } else {
            bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
        }
    }

    function addScoring() {
        $("#loading").css("display", "inline-block");

        var score1 = $("#score1").val(),
            score2 = $("#score2").val(),
            score3 = $("#score3").val(),
            score4 = $("#score4").val(),
            score5 = $("#score5").val(),
            score6 = $("#score6").val(),
            score7 = $("#score7").val(),
            score8 = $("#score8").val(),
            score9 = $("#score9").val(),
            score10 = $("#score10").val(),
            score11 = $("#score11").val(),
            score12 = $("#score12").val(),
            score13 = $("#score13").val(),
            score14 = $("#score14").val(),
            score15 = $("#score15").val(),
            score16 = $("#score16").val(),
            score17 = $("#score17").val(),
            score18 = $("#score18").val(),
            score19 = $("#score19").val(),
            score20 = $("#score20").val(),
            score21 = $("#score21").val(),
            survey = $("#add_survey").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@addScoring') }}",
                type: "POST",
                data: {
                    score1: score1,
                    score2: score2,
                    score3: score3,
                    score4: score4,
                    score5: score5,
                    score6: score6,
                    score7: score7,
                    score8: score8,
                    score9: score9,
                    score10: score10,
                    score11: score11,
                    score12: score12,
                    score13: score13,
                    score14: score14,
                    score15: score15,
                    score16: score16,
                    score17: score17,
                    score18: score18,
                    score19: score19,
                    score20: score20,
                    score21: score21,
                    survey: survey,
                    file_id: '{{$files->id}}'
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $('#add_strata_management_quality').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">{{ trans("app.successes.saved_successfully") }}</p>'
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        }
    }

    function editSurveyForm($survey){
        var editsurvey = $survey;
        if (editsurvey.trim() == "strata_management") {
            $("#edit_strata_management_quality").modal("show");
        } else {
            bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
        }
    }

    $(document).on("click", '.edit_survey', function (e) {
        var score1 = $(this).data('score1'),
            score2 = $(this).data('score2'),
            score3 = $(this).data('score3'),
            score4 = $(this).data('score4'),
            score5 = $(this).data('score5'),
            score6 = $(this).data('score6'),
            score7 = $(this).data('score7'),
            score8 = $(this).data('score8'),
            score9 = $(this).data('score9'),
            score10 = $(this).data('score10'),
            score11 = $(this).data('score11'),
            score12 = $(this).data('score12'),
            score13 = $(this).data('score13'),
            score14 = $(this).data('score14'),
            score15 = $(this).data('score15'),
            score16 = $(this).data('score16'),
            score17 = $(this).data('score17'),
            score18 = $(this).data('score18'),
            score19 = $(this).data('score19'),
            score20 = $(this).data('score20'),
            score21 = $(this).data('score21'),
            id = $(this).data('id');

        $("#score1_edit").val(score1);
        $("#score2_edit").val(score2);
        $("#score3_edit").val(score3);
        $("#score4_edit").val(score4);
        $("#score5_edit").val(score5);
        $("#score6_edit").val(score6);
        $("#score7_edit").val(score7);
        $("#score8_edit").val(score8);
        $("#score9_edit").val(score9);
        $("#score10_edit").val(score10);
        $("#score11_edit").val(score11);
        $("#score12_edit").val(score12);
        $("#score13_edit").val(score13);
        $("#score14_edit").val(score14);
        $("#score15_edit").val(score15);
        $("#score16_edit").val(score16);
        $("#score17_edit").val(score17);
        $("#score18_edit").val(score18);
        $("#score19_edit").val(score19);
        $("#score20_edit").val(score20);
        $("#score21_edit").val(score21);
        $("#scoring_id").val(id);
    });

    function editScoring() {
        $("#loading").css("display", "inline-block");

        var score1 = $("#score1_edit").val(),
            score2 = $("#score2_edit").val(),
            score3 = $("#score3_edit").val(),
            score4 = $("#score4_edit").val(),
            score5 = $("#score5_edit").val(),
            score6 = $("#score6_edit").val(),
            score7 = $("#score7_edit").val(),
            score8 = $("#score8_edit").val(),
            score9 = $("#score9_edit").val(),
            score10 = $("#score10_edit").val(),
            score11 = $("#score11_edit").val(),
            score12 = $("#score12_edit").val(),
            score13 = $("#score13_edit").val(),
            score14 = $("#score14_edit").val(),
            score15 = $("#score15_edit").val(),
            score16 = $("#score16_edit").val(),
            score17 = $("#score17_edit").val(),
            score18 = $("#score18_edit").val(),
            score19 = $("#score19_edit").val(),
            score20 = $("#score20_edit").val(),
            score21 = $("#score21_edit").val(),
            id = $("#scoring_id").val();

        var error = 0;

        if (error == 0) {
            $.ajax({
                url: "{{ URL::action('AdminController@editScoring') }}",
                type: "POST",
                data: {
                    score1: score1,
                    score2: score2,
                    score3: score3,
                    score4: score4,
                    score5: score5,
                    score6: score6,
                    score7: score7,
                    score8: score8,
                    score9: score9,
                    score10: score10,
                    score11: score11,
                    score12: score12,
                    score13: score13,
                    score14: score14,
                    score15: score15,
                    score16: score16,
                    score17: score17,
                    score18: score18,
                    score19: score19,
                    score20: score20,
                    score21: score21,
                    id: id
                },
                success: function (data) {
                    $("#loading").css("display", "none");
                    $('#edit_strata_management_quality').modal('hide');
                    if (data.trim() == "true") {
                        $.notify({
                            message: '<p style="text-align: center; margin-bottom: 0px;">{{ trans("app.successes.updated_successfully") }}</p>'
                        }, {
                            type: 'success',
                            placement: {
                                align: "center"
                            }
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        }
    }

    function deleteScoring(id) {
        swal({
            title: "{{ trans('app.confirmation.are_you_sure') }}",
            text: "{{ trans('app.confirmation.no_recover_file') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            confirmButtonText: "Delete",
            closeOnConfirm: true
        },
        function(){
            $.ajax({
                url: "{{ URL::action('AdminController@deleteScoring') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.trim() == "true") {
                        swal({
                            title: "{{ trans('app.successes.deleted_title') }}",
                            text: "{{ trans('app.successes.deleted_text_file') }}",
                            type: "success",
                            confirmButtonClass: "btn-success",
                            closeOnConfirm: false
                        });
                        location.reload();
                    } else {
                        bootbox.alert("<span style='color:red;'>{{ trans('app.errors.occurred') }}</span>");
                    }
                }
            });
        });
    }
</script>


<!-- End Page Scripts-->

@stop
