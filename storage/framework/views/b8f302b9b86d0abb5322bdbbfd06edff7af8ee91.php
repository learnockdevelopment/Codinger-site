<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
  .site-top-banner{
    border-radius: 24px;
    background: var(--primary) !important;
  }
  .search-input{
    border-radius: 24px !important;
    margin-top: 20px !important;
  } 
  .search-input button{
    border-radius: 24px !important;
  } 
  .btn i {
    font-size: 1.5rem; /* Adjust size */
}
  .site-top-banner .content{
  width: 90%;
  }
  /* Gradient overlay style */
.gradient-overlay {
  border-radius: 24px !important;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)); /* Dark gradient */
  
  z-index: 1; /* Ensure it sits under the content */
}

.site-top-banner {
  position: relative; /* Ensures the overlay works with the content inside */
}

</style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
<div class="container position-relative" style="padding-top: 20px">
  <section class="site-top-banner search-top-banner opacity-04 position-relative rounded-3">
    <div class="gradient-overlay position-absolute w-100 h-100" style="top: 0; left: 0;  z-index: 1;"></div>

    <div class="container h-100 d-flex justify-content-center">
      <div class="content">
        <div class="row align-items-center h-100 position-relative">
          
          <!-- Dark Gradient Overlay -->
          
          <!-- Text Section -->
          <div class="col-12 col-lg-6 text-white" style="z-index: 2;">
            <div class="top-search-categories-form">
              <h1 class="font-30 mb-15 text-start"><?php echo e($title); ?></h1>
              <span class="course-count-badge py-5 px-10 text-white rounded" style="background: var(--primary);">
                <?php echo e($instructorsCount); ?> <?php echo e($title); ?>

              </span>

              <div class="search-input p-10 mt-3" style="background: white;">
                <form action="/search" method="get">
                  <div class="form-group d-flex align-items-center m-0">
                    <input 
                      type="text" 
                      name="search" 
                      class="form-control border-0" 
                      placeholder="<?php echo e(trans('home.slider_search_placeholder')); ?>" />
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Image Section -->
          <div class="col-12 col-lg-6 text-center" style="z-index: 2; padding-inline-end: 0;">
            <img 
              src="<?php echo e(getPageBackgroundSettings('categories')); ?>"
              alt="Top Banner Image" 
              class="img-fluid rounded-3"
              style="max-height: 400px; position: unset" />
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

   
    <div class="container">

        

        <section>
            <div id="instructorsList" class="row mt-20">

                <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-6 col-lg-3 ">
                        <?php echo $__env->make('web.default.pages.instructor_card',['instructor' => $instructor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            <div class="text-center">
                <button type="button" id="loadMoreInstructors" data-page="<?php echo e(($page == 'instructors') ? \App\Models\Role::$teacher : \App\Models\Role::$organization); ?>" class="btn btn-border-white mt-50 <?php echo e(($instructors->lastPage() <= $instructors->currentPage()) ? ' d-none' : ''); ?>"><?php echo e(trans('site.load_more_instructors')); ?></button>
            </div>
        </section>


       
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/instructors.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/pages/instructors.blade.php ENDPATH**/ ?>