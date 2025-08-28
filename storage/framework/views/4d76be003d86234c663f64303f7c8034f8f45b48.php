<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">

<?php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];
$whatsappNumber = !empty($generalSettings['whatsapp_floating_button']) ? $generalSettings['whatsapp_floating_button'] : null;
    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
?>

<head>
    <?php echo $__env->make('web.default.includes.metas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <title><?php echo e($pageTitle ?? ''); ?><?php echo e(!empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : ''); ?></title>

    <!-- General CSS File -->
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
    <link rel="stylesheet" href="/assets/default/css/app.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Nerko+One&display=swap" rel="stylesheet">
    <?php if($isRtl): ?>
        <link rel="stylesheet" href="/assets/default/css/rtl-app.css">
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('styles_top'); ?>
    <?php echo $__env->yieldPushContent('scripts_top'); ?>

    <style>
        <?php echo !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : ''; ?>


        <?php echo getThemeFontsSettings(); ?>


        <?php echo getThemeColorsSettings(); ?>

    </style>

<style>
    /* Floating button styling */
    .floating-support {
        position: fixed;
        bottom: 20px;
        left: 20px; /* Positioned on the left */
        background-color: #0069d9; /* Professional blue color */
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3); /* Softer shadow */
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease; /* Smooth transition for hover effects */
        text-align: center;
      color: #fff;
    }

    .floating-support img {
        width: 50px; /* Slightly larger for better visibility */
        height: 50px;
    }

    /* Tooltip design */
    .tooltip {
        display: none;
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 8px;
        border-radius: 8px;
        font-size: 14px;
        white-space: nowrap;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15); /* Subtle shadow for tooltip */
    }

    /* Show tooltip on hover */
    .floating-support:hover .tooltip {
        display: block;
    }

    /* Hover effect for button */
    .floating-support:hover {
        transform: scale(1.1); /* Slightly grow the button on hover */
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.4); /* Stronger shadow */
    }

    /* Optional: Animation for tooltip */
    .floating-support:hover .tooltip {
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Tooltip fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<style>
    /* Floating Button Styles */
    .floating-whatsapp {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #25d366;
        border-radius: 50%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        animation: bounce 2s infinite;
        z-index: 1000;
        transition: transform 0.3s;
    }

    .floating-whatsapp:hover {
        transform: scale(1.1);
    }

    .floating-whatsapp img {
        width: 35px;
        height: 35px;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Tooltip Styles */
    .tooltip {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        bottom: 80px; /* Position above the button */
        right: 10px; /* Adjust as needed */
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: 14px;
        white-space: nowrap;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        transition: opacity 0.3s ease-in-out;
    }

    .floating-whatsapp:hover .tooltip {
        visibility: visible;
        opacity: 1;
    }
</style>
    <?php if(!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1'): ?>
        <?php echo $__env->make('admin.includes.preloading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</head>

<body class="<?php if($isRtl): ?> rtl <?php endif; ?>">

<div id="app" class="<?php echo e((!empty($floatingBar) and $floatingBar->position == 'top' and $floatingBar->fixed) ? 'has-fixed-top-floating-bar' : ''); ?>">
    <?php if(!empty($floatingBar) and $floatingBar->position == 'top'): ?>
        <?php echo $__env->make('web.default.includes.floating_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($appHeader)): ?>
        
        <?php echo $__env->make('web.default.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!empty($justMobileApp)): ?>
        <?php echo $__env->make('web.default.includes.mobile_app_top_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php if(!isset($appFooter)): ?>
        <?php echo $__env->make('web.default.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('web.default.includes.advertise_modal.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(!empty($floatingBar) and $floatingBar->position == 'bottom'): ?>
        <?php echo $__env->make('web.default.includes.floating_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
  
<?php if(!empty($whatsappNumber)): ?>
    <div class="floating-whatsapp" id="whatsappButton">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        <div class="tooltip">Chat with us on WhatsApp!</div>
    </div>
<?php endif; ?>
    <div class="floating-support" id="supportButton">
        <i data-feather="help-circle"></i>
        <div class="tooltip">Get support</div>
    </div>
</div>
<!-- Template JS File -->
<script src="/assets/default/js/app.js"></script>
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/moment.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>

<?php if(empty($justMobileApp) and checkShowCookieSecurityDialog()): ?>
    <?php echo $__env->make('web.default.includes.cookie-security', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<script>
    document.getElementById('supportButton').onclick = function() {
        window.location.href = '/panel/support/new';
    }
</script>
<script>
    var deleteAlertTitle = '<?php echo e(trans('public.are_you_sure')); ?>';
    var deleteAlertHint = '<?php echo e(trans('public.deleteAlertHint')); ?>';
    var deleteAlertConfirm = '<?php echo e(trans('public.deleteAlertConfirm')); ?>';
    var deleteAlertCancel = '<?php echo e(trans('public.cancel')); ?>';
    var deleteAlertSuccess = '<?php echo e(trans('public.success')); ?>';
    var deleteAlertFail = '<?php echo e(trans('public.fail')); ?>';
    var deleteAlertFailHint = '<?php echo e(trans('public.deleteAlertFailHint')); ?>';
    var deleteAlertSuccessHint = '<?php echo e(trans('public.deleteAlertSuccessHint')); ?>';
    var forbiddenRequestToastTitleLang = '<?php echo e(trans('public.forbidden_request_toast_lang')); ?>';
    var forbiddenRequestToastMsgLang = '<?php echo e(trans('public.forbidden_request_toast_msg_lang')); ?>';
</script>

<?php if(session()->has('toast')): ?>
    <script>
        (function () {
            "use strict";

            $.toast({
                heading: '<?php echo e(session()->get('toast')['title'] ?? ''); ?>',
                text: '<?php echo e(session()->get('toast')['msg'] ?? ''); ?>',
                bgColor: '<?php if(session()->get('toast')['status'] == 'success'): ?> #43d477 <?php else: ?> #f63c3c <?php endif; ?>',
                textColor: 'white',
                hideAfter: 10000,
                position: 'bottom-right',
                icon: '<?php echo e(session()->get('toast')['status']); ?>'
            });
        })(jQuery)
    </script>
<?php endif; ?>

<?php echo $__env->make('web.default.includes.purchase_notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldPushContent('styles_bottom'); ?>
<?php echo $__env->yieldPushContent('scripts_bottom'); ?>

<script src="/assets/default/js/parts/main.min.js"></script>
<script>
     <?php if(!empty($whatsappNumber)): ?>
        document.getElementById('whatsappButton').addEventListener('click', function () {
            const whatsappNumber = "<?php echo e($whatsappNumber); ?>"; // Use the dynamic WhatsApp number
            const message = "Hello, I need assistance."; // Default message
            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;
            window.open(whatsappUrl, '_blank');
        });
    <?php endif; ?>
</script>
<script>
    <?php if(session()->has('registration_package_limited')): ?>
    (function () {
        "use strict";

        handleLimitedAccountModal('<?php echo session()->get('registration_package_limited'); ?>')
    })(jQuery)

    <?php echo e(session()->forget('registration_package_limited')); ?>

    <?php endif; ?>

    <?php echo !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : ''; ?>

</script>
</body>
</html>
<?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/layouts/app.blade.php ENDPATH**/ ?>