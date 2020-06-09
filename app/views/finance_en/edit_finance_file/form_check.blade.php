<div class="row">
    <div class="col-lg-12">

        <h6>Check</h6>

        <div class="form-group row">
            <div class="col-md-6">                            
                <label><span style="color: red;">*</span> Date</label>
                <input id="date" class="form-control form-control-sm" type="text" placeholder="Date" value="{{ ($checkdata->date) ? date('d/m/Y', strtotime($checkdata->date)) : '' }}">
                <input type="hidden" name="date" id="mirror_date" value="{{ $checkdata->date }}">
                <div id="date_err" style="display:none;"></div>
            </div>
            <div class="col-md-6">
                <label><span style="color: red;">*</span> Name</label>
                <input name="name" id="name" class="form-control form-control-sm" type="text" placeholder="Name" value="{{ $checkdata->name }}">
                <div id="name_err" style="display:none;"></div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label><span style="color: red;">*</span> Position</label>
                <input name="position" id="position" class="form-control form-control-sm" type="text" placeholder="Position" value="{{ $checkdata->position }}">
                <div id="position_err" style="display:none;"></div>
            </div>
            <div class="col-md-6">
                <label><span style="color: red;">*</span> Status</label>
                <select name="is_active" id="is_active" class="form-control form-control-sm">
                    <option value="">Please Select</option>
                    <option value="1" {{ ($checkdata->is_active == 1) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ ($checkdata->is_active == 0) ? 'selected' : '' }}>Inactive</option>
                </select>
                <div id="is_active_err" style="display:none;"></div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <label>Remarks</label>
                <textarea name="remarks" id="remarks" rows="5" class="form-control form-control-sm" placeholder="Remarks">{{ $checkdata->remarks }}</textarea>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#date").datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'DD/MM/YYYY'
        }).on('dp.change', function () {
            let currentDate = $(this).val().split('/');
            $("#mirror_date").val(`${currentDate[2]}-${currentDate[1]}-${currentDate[0]}`);
        });
    });
</script>