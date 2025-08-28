<div class="tab-pane mt-3 fade" id="devices" role="tabpanel" aria-labelledby="devices-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="<?php echo e(getAdminPanelUrl()); ?>/users/<?php echo e($user->id .'/updateDevice'); ?>" method="Post">
                <?php echo e(csrf_field()); ?>

<div class="form-group">
    <label><?php echo e(trans('/admin/main.mac_address')); ?></label>
    <input type="text" name="mac_address"
           class="form-control <?php $__errorArgs = ['mac_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           value="<?php echo e(!empty($user) ? $user->mac_address : old('mac_address')); ?>"
           placeholder="<?php echo e(trans('admin/main.create_field_mac_address_placeholder')); ?>"/>
    <?php $__errorArgs = ['mac_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="invalid-feedback">
        <?php echo e($message); ?>

    </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
              <div class="form-group">
    <label><?php echo e(trans('/admin/main.device_id')); ?></label>
    <input type="text" name="device_id"
           class="form-control <?php $__errorArgs = ['device_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           value="<?php echo e(!empty($user) ? $user->device_id : old('device_id')); ?>"
           placeholder="<?php echo e(trans('admin/main.create_field_device_id_placeholder')); ?>"/>
    <?php $__errorArgs = ['device_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="invalid-feedback">
        <?php echo e($message); ?>

    </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                <div class=" mt-4">
                    <button class="btn btn-primary"><?php echo e(trans('admin/main.submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/admin/users/editTabs/devices.blade.php ENDPATH**/ ?>