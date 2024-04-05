@extends('layouts.admin')

@section('page-title')
    {{ __('Employee Set Salary') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('setsalary') }}">{{ __('Set Salary') }}</a></li>
    <li class="breadcrumb-item">{{ __('Employee Set Salary') }}</li>
@endsection

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-xl-6">
                    {{ Form::open(['url' => 'salary-calculate-update', 'method' => 'post']) }}
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>{{ __('Employee Salary') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="project-info">
                                        <?php if(count($salary_breakup)  > 0){ 
                                            foreach ($salary_breakup as $sb) { 
                                                if($sb->component_value_type == "Base Salary") { ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ $sb->component_name }}</label>
                                                        <input class="form-control" required="required" name="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}" type="number" id="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}">
                                                        <input class="form-control" required="required" name="" type="hidden" value="{{$sb->component_type}}">
                                                    </div>
                                                </div>
                                        <?php  } } } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>{{ __('Allowance') }}</h5>
                                        </div>
                                    </div>
                                    <div class="project-info">
                                        <?php if(count($salary_breakup)  > 0){ 
                                            foreach ($salary_breakup as $sb) { 
                                                if($sb->component_value_type == "Allowance") { ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">{{ $sb->component_name }}</label>
                                                        <?php if($sb->component_type == "Flat"){ ?>
                                                        <input class="form-control" required="required" name="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}" type="number" id="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}" />
                                                        <?php } else if($sb->component_type == "Percentage") { ?>
                                                        <input class="form-control" required="required" name="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}" type="number" id="{{ str_replace(' ', '_' ,strtolower($sb->component_name)) }}" min="0" max="50">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php  } } } ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                    <div class="float-end">
                                        <button type="submit" class="btn  btn-primary">{{ 'Update' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    {!! Form::close() !!}                  
                </div>

                <!-- allowance -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>{{ __('Employee Details') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('Name of employee') }}</th>
                                                    <td>{{ $employee->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Employee ID') }}</th>
                                                    <td>{{ $employeesId }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Date of Joining') }}</th>
                                                    <td>{{ \Auth::user()->dateFormat($employee->company_doj) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Designation') }}</th>
                                                    <td>{{ !empty($employee->designation) ? $employee->designation->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Department') }}</th>
                                                    <td>{{ !empty($employee->department) ? $employee->department->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Location') }}</th>
                                                    <td><p style="word-break: break-all;white-space:normal;">{{ $employee->address }}</p></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Branch') }}</th>
                                                    <td>{{ !empty($employee->branch) ? $employee->branch->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('PAN') }}</th>
                                                    <td>{{ $employee->tax_payer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('PF No.') }}</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('PF UAN') }}</th>
                                                    <td>-</td>
                                                </tr>
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
@endsection

@push('script-page')
    <script type="text/javascript">
        $(document).on('change', '.amount_type', function() {

            var val = $(this).val();
            var label_text = 'Amount';
            if (val == 'percentage') {
                var label_text = 'Percentage';
            }
            $('.amount_label').html(label_text);
        });


        $(document).on('change', 'select[name=department_id]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });



        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#designation_id').empty();
                    $('#designation_id').append(
                        '<option value="">{{ __('Select any Designation') }}</option>');
                    $.each(data, function(key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' +
                            value + '</option>');
                    });
                }
            });
        }
    </script>
@endpush
