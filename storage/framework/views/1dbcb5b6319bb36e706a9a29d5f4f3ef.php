

<?php $__env->startSection('page-title'); ?>
   <?php echo e(__('Manage Salary Breakup')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Salary')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="#" data-url="<?php echo e(route('salarybreakup.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Salary Breakup')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
    </a>
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
                                <th><?php echo e(__('Component Name')); ?></th>
                                <th><?php echo e(__('Component Type')); ?></th>
                                <th><?php echo e(__('Component Value')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $breackups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breakup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($breakup->component_name); ?></td>
                                    <td><?php echo e($breakup->component_type); ?></td>
                                    <td><?php echo e($breakup->component_value_type); ?></td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="<?php echo e(URL::to('salary-breakup-edit/' . $breakup->id)); ?>"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="<?php echo e(__('Edit Breakup')); ?>"
                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['salarybreakup.delete', $breakup->id], 'id' => 'delete-form-' . $breakup->id]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    </form>
                                                </div>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\arha-hrms\resources\views/setsalary/breakup.blade.php ENDPATH**/ ?>