<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <style>
        .progress-container {
            width: 100%;
            background-color: blue;
            border-radius: 24px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .progress-bar {
            width: 0%;
            height: 5px;
            background-color: var(--primary);
            border-radius: 24px;
            transition: width 0.3s ease-in-out;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
        $selectRolesDuringRegistration = getFeaturesSettings('select_the_role_during_registration') ?? null;
        $logo = getGeneralSettings('logo') ?? '';
    ?>

    <div class="container">
        <div class="row login-container d-flex justify-content-center border-0" style="margin-top:60px !important">
           

            <div class="col-9 col-md-12 d-flex justify-content-center ">
                <div class="col-8 shadow-xl! border-1!" style="border-radius: 24px; background: white">
                    <div class="login-card d-flex flex-column" style="position: relative;z-index:10;">
                        <h1 class="font-20 font-weight-bold"><?php echo e(trans('auth.signup')); ?></h1>
                        <form method="post" action="/register" class="mt-35">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <div class="progress position-relative mt-3 text-center " style="background:#3551a430;box-shadow:none;margin-bottom:20px;height:5px;overflow:visible;">
                              <div class="position-absolute bg-white " style="left:0;top:-7px; border:  2px solid var(--secondary); width:20px; height:20px;border-radius:1000px;"><p>3</p></div>
                              <div class="position-absolute bg-white  " style="left:49%;top:-7px; border: var(--secondary) 2px solid; width:20px; height:20px;border-radius:1000px;"><p>2</p></div>  
                              <div class="position-absolute bg-white  " style="right:0;top:-7px; border: var(--secondary) 2px solid; width:20px; height:20px;border-radius:1000px;"><p>1</p></div>  
  
                              
                              <div id="progress-bar" class="progress-bar bg-primary" style="width: 33%; height:100%;"
                                    role="progressbar"></div>
                            </div>

                            <div id="step-1">
                                <div class="form-group">
                                    <label class="input-label" for="full_name"><?php echo e(trans('auth.full_name')); ?>:</label>
                                    <input name="full_name" type="text" value="<?php echo e(old('full_name')); ?>"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['full_name'];
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
                                    <label class="input-label" for="email"><?php echo e(trans('auth.email')); ?>:</label>
                                    <input name="email" type="email" value="<?php echo e(old('email')); ?>"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['email'];
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

                                <button type="button" class="btn btn-primary w-100 mt-3" id="next-step-1"><?php echo e(trans('auth.continue')); ?></button>
                            </div>
<script>
    async function loadCountries() {
        const select = document.getElementById('countrySelect');

        try {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();

            // Sort countries alphabetically
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.cca2; // ISO Alpha-2 Code (e.g., US, EG)
                option.text = country.name.common;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading countries:', error);
        }
    }

    // Call it on page load
    window.addEventListener('DOMContentLoaded', loadCountries);
</script>

                            <div id="step-2" style="display: none;">
<div class="form-group" style="padding-right:0px !important;">
    <label class="input-label" for="country_code"><?php echo e(trans('auth.country')); ?>:</label>
    <select id="countrySelect" name="country_code" class="form-control select2" 
            style="border-color: rgba(31, 42, 85, 0.15);" required>
        <option value="">Select Country</option>
    </select>
    <?php $__errorArgs = ['country_code'];
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
                                <div class="form-group"
                                    style="padding-left:0px !important; padding-right:10px !important;">
                                    <label class="input-label" for="phone"><?php echo e(trans('auth.phone')); ?>:</label>
                                    <input name="phone" type="text" value="<?php echo e(old('phone')); ?>"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['phone'];
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

				<div class="d-flex  justify-content-between align-items-center mb-2 mt-3">
                                <button type="button" class="btn btn-secondary " style="width:48%;" id="prev-step-1"><?php echo e(trans('auth.return')); ?></button>
                                <button type="button" class="btn btn-primary " style="width:48%;"  id="next-step-2"><?php echo e(trans('auth.continue')); ?></button>
                              </div>
                            </div>

                            <div id="step-3" style="display: none;">
                                <div class="form-group">
                                    <label class="input-label" for="password"><?php echo e(trans('auth.password')); ?>:</label>
                                    <input name="password" type="password"
                                        class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        style="border-color: rgba(31, 42, 85, 0.15);">
                                    <?php $__errorArgs = ['password'];
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
                                    <label class="input-label"
                                        for="confirm_password"><?php echo e(trans('auth.retype_password')); ?>:</label>
                                    <input name="password_confirmation" type="password"
                                        class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        style="border-color: rgba(31, 42, 85, 0.15);">
                                    <?php $__errorArgs = ['password_confirmation'];
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

                                <!-- Additional Fields and Terms -->
                                <?php if($showCertificateAdditionalInRegister): ?>
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="certificate_additional"><?php echo e(trans('update.certificate_additional')); ?></label>
                                        <input name="certificate_additional" style="border-color: rgba(31, 42, 85, 0.15);"
                                            id="certificate_additional"
                                            class="form-control <?php $__errorArgs = ['certificate_additional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                                        <?php $__errorArgs = ['certificate_additional'];
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
                                <?php endif; ?>

                                             <div class="form-group">
    <label for="category_id"><?php echo e(trans('auth.age_group')); ?>:</label>
    <select name="category_id" id="category_id" class="form-control" required>
        <option value=""><?php echo e(trans('public.select')); ?></option>
        <?php $__currentLoopData = $ageRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ageRange): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($ageRange['id']); ?>" <?php echo e(old('category_id') == $ageRange['id'] ? 'selected' : ''); ?>>
                <?php echo e($ageRange['ageRange']); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
                                <div class="custom-control custom-checkbox">
                                    <input style="border-color: rgba(31, 42, 85, 0.15);" type="checkbox" name="term"
                                        value="1" <?php echo e((!empty(old('term')) and old('term') == '1') ? 'checked' : ''); ?>

                                        class="custom-control-input <?php $__errorArgs = ['term'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="term">
                                    <label class="custom-control-label font-14"
                                        for="term"><?php echo e(trans('auth.i_agree_with')); ?>

                                        <a href="pages/terms" target="_blank"
                                            class="text-secondary font-weight-bold font-14"><?php echo e(trans('auth.terms_and_rules')); ?></a>
                                    </label>
                                    <?php $__errorArgs = ['term'];
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


								<div class="d-flex align-items-center justify-content-between mb-2 mt-3">
                                <button type="button" class="btn btn-secondary"
                                    id="prev-step-2" style="width:48%;"><?php echo e(trans('auth.return')); ?></button>
                                <button type="submit" class="btn btn-primary " style="width:48%;"><?php echo e(trans('auth.signup')); ?></button>
                              </div>
                              </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script>
    $(document).ready(function() {
        const isRTL = $('html').attr('dir') === 'rtl';

        function updateProgress(step) {
            let percentage = step === 1 ? 0 : step === 2 ? 50 : 100;
            if (isRTL) {
                $("#progress-bar").css({
                    "width": percentage + "%",
                    "left": "auto",
                    "right": 0
                });
            } else {
                $("#progress-bar").css({
                    "width": percentage + "%",
                    "right": "auto",
                    "left": 0
                });
            }
        }

        updateProgress(1); // Initialize at 0% for Step 1

        $("#next-step-1").click(function() {
            $("#step-1").hide();
            $("#step-2").show();
            updateProgress(2); // Move to 50%
        });

        $("#prev-step-1").click(function() {
            $("#step-2").hide();
            $("#step-1").show();
            updateProgress(1); // Back to 0%
        });

        $("#next-step-2").click(function() {
            $("#step-2").hide();
            $("#step-3").show();
            updateProgress(3); // Move to 100%
        });

        $("#prev-step-2").click(function() {
            $("#step-3").hide();
            $("#step-2").show();
            updateProgress(2); // Back to 50%
        });

        $("form").submit(function() {
            updateProgress(3); // Ensure progress bar is full on final submit
        });
    });
</script>

    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/forms.min.js"></script>
    <script src="/assets/default/js/parts/register.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate() . '.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/auth/register.blade.php ENDPATH**/ ?>