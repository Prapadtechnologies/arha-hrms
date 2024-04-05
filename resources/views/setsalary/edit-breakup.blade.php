{{ Form::open(['url' => 'salary-breakup-update', 'method' => 'post']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('component_name', __('Component Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <input type="text" name="component_name" value="{{$salarybreakup->component_name}}" class="form-control" required placeholder="Enter Component Name" />
                    <input type="hidden" name="id" value="{{$salarybreakup->id}}" />
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('component_value_type', __('Component Value Type'), ['class' => 'form-label']) }}
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="base_salary" value="Base Salary" name="component_value_type" class="form-check-input componentvaluetype" <?php if($salarybreakup->component_value_type == "Base Salary") { echo "checked"; } ?>>
                        <label class="form-check-label" for="base_salary">{{ __('Is Base Salary?') }}</label>
                    </div>
                    <div class="custom-control custom-radio ms-1 custom-control-inline">
                        <input type="radio" id="allowance" value="Allowance" name="component_value_type" class="form-check-input componentvaluetype" <?php if($salarybreakup->component_value_type == "Allowance") { echo "checked"; } ?>>
                        <label class="form-check-label" for="allowance">{{ __('Is Allowance?') }}</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('component_type', __('Component Value Type'), ['class' => 'form-label']) }}
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="flat_type" value="Flat" name="component_type" class="form-check-input" <?php if($salarybreakup->component_type == "Flat") { echo "checked"; } ?>>
                        <label class="form-check-label flat_type" for="flat_type">{{ __('Flat Value') }}</label>
                    </div>
                    <div class="custom-control custom-radio ms-1 custom-control-inline">
                        <input type="radio" id="percentage" value="Percentage" name="component_type" class="form-check-input" <?php if($salarybreakup->component_type == "Percentage") { echo "checked"; } ?>>
                        <label class="form-check-label percentage" for="percentage">{{ __('Percentage Value') }}</label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script type="text/javascript">
    jQuery('body').on('click', 'input[name="component_value_type"]', function() {
        var componet_value = $(this).val();
        if(componet_value == "Base Salary"){
            $('#flat_type').show();
            $('#percentage').hide();
            $('.flat_type').show();
            $('.percentage').hide();
        }else if(componet_value == "Allowance"){
            $('#flat_type').show();
            $('#percentage').show();
            $('.flat_type').show();
            $('.percentage').show();
        }else{
            $('#flat_type').hide();
            $('#percentage').hide();
            $('.flat_type').hide();
            $('.percentage').hide();
        }
    });
</script>