<?php
    $canReserve = !empty($instructor->meeting) 
        && !$instructor->meeting->disabled 
        && !empty($instructor->meeting->meetingTimes) 
        && $instructor->meeting->meeting_times_count > 0;
?>

<div class="rounded-lg mt-25 p-20 course-teacher-card instructors-list text-center d-flex align-items-center flex-column position-relative">
    <!-- Instructor Profile Link -->
    <a href="<?php echo e($instructor->getProfileUrl()); ?>" class="text-center d-flex flex-column align-items-center justify-content-center">
        <div class="teacher-avatar mt-5 position-relative">
            <img src="<?php echo e($instructor->getAvatar(190)); ?>" class="img-cover" alt="<?php echo e($instructor->full_name); ?>">
        </div>

        <h3 class="mt-20 font-16 font-weight-bold text-dark-blue text-center" style="color: var(--primary); font-weight: bold;">
            <?php echo e($instructor->full_name); ?>

        </h3>
    </a>

    <!-- Bio -->
    <?php if(!empty($instructor->bio)): ?>
        <div class="mt-5 font-14 text-gray" style="color: var(--primary); font-weight: bold;">
            <?php echo e($instructor->bio); ?>

        </div>
    <?php endif; ?>

    <!-- Rating -->
    <div class="stars-card d-flex align-items-center">
        <?php echo $__env->make('web.default.includes.webinar.rate', ['rate' => $instructor->rates()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <!-- Outline Button for Appointments -->
    <?php if($canReserve): ?>
        <a href="<?php echo e($instructor->getProfileUrl()); ?>?tab=appointments#appointments" 
           class="btn btn-outline-primary mt-3">
            <?php echo e(trans('site.book_an_appointment')); ?>

        </a>
    <?php endif; ?>
</div>
<?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/pages/instructor_card.blade.php ENDPATH**/ ?>