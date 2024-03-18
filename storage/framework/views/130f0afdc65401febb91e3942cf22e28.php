<?php echo e(Form::open(['route' => ['create.webhook'], 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo e(Form::label('module', __('Module'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('module', $modules, null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo e(Form::label('method', __('Method'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('method', $methods, null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo e(Form::label('url', __('URL'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('url', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home/u206694750/domains/arha-express.com/public_html/hrms/resources/views/webhook_settings/create.blade.php ENDPATH**/ ?>