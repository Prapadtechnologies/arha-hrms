

<?php $__env->startSection('page-title'); ?>
   <?php echo e(__('Manage Employee Salary')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Employee Salary')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">

    <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Employee Id')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Payroll Type')); ?></th>
                                <th><?php echo e(__('Salary')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($employees as $employee){ $base_salary = CustomHelper::getBaseSalaryData($employee->id); ?>
                                
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('setsalary.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                                            class="btn btn-outline-primary">
                                            <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($employee->name); ?></td>
                                    <td><?php echo e(!empty($employee->salary_type()) ? $employee->salary_type() : '-'); ?></td>
                                    <td><?php echo e(!empty($base_salary) ? CustomHelper::currencyFormat($base_salary)." INR" : ''); ?></td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('setsalary.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                                                    class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip"
                                                    title="" data-bs-original-title="<?php echo e(__('View')); ?>">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\arha-hrms\resources\views/setsalary/index.blade.php ENDPATH**/ ?>