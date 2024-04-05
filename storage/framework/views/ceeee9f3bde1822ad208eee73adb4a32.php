

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Employee Set Salary')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(url('setsalary')); ?>"><?php echo e(__('Set Salary')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Employee Set Salary')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-xl-6">
                    <?php echo e(Form::open(['url' => 'salary-calculate-update', 'method' => 'post'])); ?>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5><?php echo e(__('Employee Salary')); ?></h5>
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
                                                        <label for="name" class="form-label"><?php echo e($sb->component_name); ?></label>
                                                        <input class="form-control" required="required" name="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>" type="number" id="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>">
                                                    </div>
                                                </div>
                                        <?php  } } } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h5><?php echo e(__('Allowance')); ?></h5>
                                        </div>
                                    </div>
                                    <div class="project-info">
                                        <?php if(count($salary_breakup)  > 0){ 
                                            foreach ($salary_breakup as $sb) { 
                                                if($sb->component_value_type == "Allowance") { ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label"><?php echo e($sb->component_name); ?></label>
                                                        <?php if($sb->component_type == "Flat"){ ?>
                                                        <input class="form-control" required="required" name="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>" type="number" id="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>" />
                                                        <?php } else if($sb->component_type == "Percentage") { ?>
                                                        <input class="form-control" required="required" name="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>" type="number" id="<?php echo e(str_replace(' ', '_' ,strtolower($sb->component_name))); ?>" min="0" max="50">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php  } } } ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>">
                                    <div class="float-end">
                                        <button type="submit" class="btn  btn-primary"><?php echo e('Update'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <?php echo Form::close(); ?>                  
                </div>

                <!-- allowance -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5><?php echo e(__('Employee Details')); ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                                        
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th><?php echo e(__('Name of employee')); ?></th>
                                                    <td><?php echo e($employee->name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Employee ID')); ?></th>
                                                    <td><?php echo e($employeesId); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Date of Joining')); ?></th>
                                                    <td><?php echo e(\Auth::user()->dateFormat($employee->company_doj)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Designation')); ?></th>
                                                    <td><?php echo e(!empty($employee->designation) ? $employee->designation->name : ''); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Department')); ?></th>
                                                    <td><?php echo e(!empty($employee->department) ? $employee->department->name : ''); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Location')); ?></th>
                                                    <td><p style="word-break: break-all;white-space:normal;"><?php echo e($employee->address); ?></p></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('Branch')); ?></th>
                                                    <td><?php echo e(!empty($employee->branch) ? $employee->branch->name : ''); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('PAN')); ?></th>
                                                    <td><?php echo e($employee->tax_payer_id); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('PF No.')); ?></th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('PF UAN')); ?></th>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
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
                url: '<?php echo e(route('employee.json')); ?>',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    $('#designation_id').empty();
                    $('#designation_id').append(
                        '<option value=""><?php echo e(__('Select any Designation')); ?></option>');
                    $.each(data, function(key, value) {
                        var select = '';
                        if (key == '<?php echo e($employee->designation_id); ?>') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' +
                            value + '</option>');
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\arha-hrms\resources\views/setsalary/employee_salary.blade.php ENDPATH**/ ?>