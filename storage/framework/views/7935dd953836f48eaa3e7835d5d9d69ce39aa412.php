<?php
    use Illuminate\Support\Str;
?>

<div class="webinar-card relative" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">

    <figure class="webinar-figure relative">
        <div class="badges-lists z-999 d-flex justify-content-between position-absolute"
            style="background: linear-gradient(to bottom, #060606f0, #ffffff00);">
            <div class="badge-column">
                <?php if($webinar->bestTicket() < $webinar->price): ?>
                    <span class="badge badge-danger"
                        style="background: red;"><?php echo e(trans('public.offer', ['off' => $webinar->bestTicket(true)['percent']])); ?></span>
                <?php elseif(empty($isFeature) and !empty($webinar->feature)): ?>
                    <span class="badge badge-warning"><?php echo e(trans('home.featured')); ?></span>
                <?php elseif($webinar->type == 'webinar'): ?>
                    <?php if($webinar->start_date > time()): ?>
                        <span class="badge badge-primary"><?php echo e(trans('panel.not_conducted')); ?></span>
                    <?php elseif($webinar->isProgressing()): ?>
                        <span class="badge badge-secondary"
                            style="background: red;"><?php echo e(trans('webinars.in_progress')); ?></span>
                    <?php else: ?>
                        <span class="badge badge-secondary"><?php echo e(trans('public.finished')); ?></span>
                    <?php endif; ?>
                <?php elseif(!empty($webinar->type)): ?>
                    <span class="badge badge-primary"><?php echo e(trans('webinars.' . $webinar->type)); ?></span>
                <?php endif; ?>
                <?php echo $__env->make('web.default.includes.product_custom_badge', ['itemTarget' => $webinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="icon-column">

                    <div>
                        <a href="/favorites/<?php echo e($webinar->slug); ?>/toggle" id="favoriteToggle"
                            class="d-flex flex-column align-items-center text-light">

                            <span class="badge bg-transparent d-flex flex-column align-items-center">
                                <i data-feather="heart"
                                    class="<?php echo e(!empty($isFavorite) ? 'favorite-active' : ''); ?> feather-solid"
                                    width="20" height="20"></i>
                                <span class="font-12"><?php echo e(trans('panel.favorite')); ?></span>

                            </span>
                        </a>
                        <a href="#" id="js-share-course"
                                class="js-share-course d-flex flex-column align-items-center text-light  mt-15">
                                <i data-feather="share-2"
                                    class="<?php echo e(!empty($isFavorite) ? 'favorite-active' : ''); ?> feather-solid"
                                    width="20" height="20"></i>
                                <span class="font-12"><?php echo e(trans('public.share')); ?></span>
                            </a>
                    </div>

                </div>
            </div>

        </div>
        <?php if($webinar->video_demo): ?>
    <div id="webinarDemoVideoBtn"
        data-video-path="<?php echo e($webinar->video_demo_source == 'upload' ? url($webinar->video_demo) : $webinar->video_demo); ?>"
        data-video-source="<?php echo e($webinar->video_demo_source); ?>"
        class="course-video-icon cursor-pointer d-flex align-items-center justify-content-center z-999 position-absolute flex-column">
        <i data-feather="play" width="50" height="50" class="feather-solid"></i>
        <div class="font-12 mt-5">Play intro</div>
    </div>
<?php endif; ?>

        <div class="webinar-image" style="background-image: url('<?php echo e($webinar->getImage()); ?>');">
            <div class="overlay"></div>
        </div>


        <div class="position-relative">
            <figcaption class="webinar-content">
                <?php if(!empty($webinar->category)): ?>
                    <span class="d-block font-14"><?php echo e(trans('public.in')); ?> <a
                            href="<?php echo e($webinar->category->getUrl()); ?>" target="_blank"
                            class=" cat text-decoration-underline text-light"><?php echo e($webinar->category->title); ?></a></span>
                <?php endif; ?>
                <h3 class="webinar-title overflow-marquee"><a href="<?php echo e($webinar->getUrl()); ?>"><?php echo e(clean($webinar->title, 'title')); ?></a>
                </h3>
                <div class="d-flex align-items-center justify-content-center rate">
                    <?php echo $__env->make('web.default.includes.webinar.rate', ['rate' => $webinar->getRate()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="">
                    <div class="z-999 d-flex justify-content-center  mt-10"
                        style="
                        top: -57px;
                        right: 0;
                    ">
                        <span class="badge bg-transparent d-flex flex-column align-items-center">

                            <span class="font-12">Students</span>
                            <i data-feather="users" width="20" height="20"></i>
                            <span><?php echo e($webinar->getSalesCount()); ?></span>
                        </span>
                        <span class="badge bg-transparent d-flex flex-column align-items-center">

                            <span class="font-12">Duration</span>
                            <i data-feather="clock" width="20" height="20"></i>
                            <span><?php echo e(convertMinutesToHourAndMinute($webinar->duration)); ?></span>

                        </span>
                    </div>
                    <div class="d-flex justify-content-center mt-15">
                        <div>
                            <img src="<?php echo e($webinar->teacher->getAvatar()); ?>"
                                style="
                    width: 40px;
                    height: 40px;
                    object-fit: cover;
                    border-radius: 50%;
                    margin-inline-end: 10px;
                "
                                alt="<?php echo e($webinar->teacher->full_name); ?>">
                        </div>
                        <div class="d-flex justify-content-center flex-column">
                            <a class="webinar-teacher text-center webinar-teacher-name text-light text-decoration-underline"
                                href="<?php echo e($webinar->teacher->getProfileUrl()); ?>"
                                target="_blank"href><?php echo e($webinar->teacher->full_name); ?></a>
                            <p class="webinar-teacher text-center"><?php echo e($webinar->teacher->bio); ?></p>
                        </div>
                    </div>
                </div>




                <div class="webinar-price py-3 d-flex justify-content-center">
                    <?php if(!empty($webinar->price) && $webinar->price > 0): ?>
                        <span class="price">
                            <?php if($webinar->price > $webinar->getPrice()): ?>
                                <span class="original-price">
                                    <?php
                                        $originalPrice = handlePrice($webinar->price, true, true, false, null, true);
                                        $splitOriginalPrice = explode(' ', $originalPrice);
                                    ?>
                                    <span class="price-value"><?php echo e($splitOriginalPrice[0]); ?></span>
                                    <span class="currency-symbol"><?php echo e($splitOriginalPrice[1] ?? "$"); ?></span>
                                </span>
                                <span class="discounted-price">
                                    <?php
                                        $discountedPrice = handlePrice($webinar->getPrice(), true, true, false, null, true);
                                        $splitDiscountedPrice = explode(' ', $discountedPrice);
                                    ?>
                                    <span class="price-value"><?php echo e($splitDiscountedPrice[0]); ?></span>
                                    <span class="currency-symbol"><?php echo e($splitDiscountedPrice[1] ?? "$"); ?></span>
                                </span>
                            <?php else: ?>
                                <?php
                                    $normalPrice = handlePrice($webinar->getPrice(), true, true, false, null, true);
                                    $splitNormalPrice = explode(' ', $normalPrice);
                                ?>
                                <span class="price">
                                    <span class="price-value"><?php echo e($splitNormalPrice[0]); ?></span>
                                    <span class="currency-symbol"><?php echo e($splitNormalPrice[1] ?? "$"); ?></span>
                                </span>
                            <?php endif; ?>

                        </span>
                    <?php else: ?>
                        <span class="price"><?php echo e(trans('public.free')); ?></span>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e($webinar->getUrl()); ?>" class="btn-modern">Enroll now</a>

            </figcaption>
        </div>

    </figure>
      <?php echo $__env->make('web.default.course.share_modal', ['course' => $webinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>
<?php $__env->startPush('scripts_bottom'); ?>
      <script src="/assets/default/js/parts/comment.min.js"></script>

<script>
var courseDemoVideoPlayer;

$('#webinarDemoVideoBtn').on('click', function (e) { 
  var fileVideoPlayer;

window.makeVideoPlayerHtml = function (path, storage, height, tagId) {
  console.log('makeVideoPlayerHtml called with:', { path, storage, height, tagId });
  var html = '';
  var options = {
    autoplay: false,
    preload: 'auto'
  };
  
  if (storage === 'youtube' || storage === 'vimeo') {
    console.log('Storage is YouTube or Vimeo');
    html = '<video id="' + tagId + '" class="video-js" width="100%" height="' + height + '"></video>';
    options = {
      controls: storage !== 'vimeo',
      ytControls: true,
      autoplay: false,
      preload: 'auto',
      techOrder: ['html5', storage],
      sources: [{
        src: path,
        type: "video/" + storage
      }]
    };
  } else if (storage === "secure_host") {
    console.log('Storage is secure_host');
    // Remove the ability to go fullscreen on secure_host iframes
    html = '<iframe src="' + path + '" class="img-cover bg-gray200" frameborder="0" loading="lazy" allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"></iframe>';
  } else {
    console.log('Default storage method used');
    html = '<video id="' + tagId + '" oncontextmenu="return false;" controlsList="nodownload" class="video-js" controls preload="auto" width="100%" height="' + height + '"><source src="' + path + '" type="video/mp4"/></video>';
  }
  
  console.log('Generated HTML:', html);
  return {
    html: html,
    options: options
  };
};
  console.log("Click event triggered"); // Log when the event is triggered
  e.preventDefault();
  console.log("Default action prevented"); // Log after preventing default action

  var path = $(this).attr('data-video-path');
  console.log("Video path:", path); // Log the video path

  var source = $(this).attr('data-video-source');
  console.log("Video source:", source); // Log the video source

  var videoTagId = 'demoVideoPlayer';
  console.log("Video tag ID:", videoTagId); // Log the video tag ID

  var { html, options } = makeVideoPlayerHtml(path, source, 264, videoTagId);
  console.log("Generated video player HTML and options:", { html, options }); // Log generated HTML and options

  var modalHtml = `
    <div id="webinarDemoVideoModal" class="demo-video-modal">
      <div class="demo-video-card mt-25">${html}</div>
    </div>`;
  console.log("Generated modal HTML:", modalHtml); // Log the modal HTML

  Swal.fire({
    html: modalHtml,
    showCancelButton: false,
    showConfirmButton: false,
    customClass: {
      content: 'p-0 text-left'
    },
    width: '48rem',
    didOpen: function () {
      console.log("Modal didOpen callback triggered"); // Log when the modal opens
      courseDemoVideoPlayer = videojs(videoTagId, options);
      console.log("Video.js player initialized"); // Log after initializing the video player
    }
  });
  console.log("SweetAlert modal triggered"); // Log after triggering the modal
});


document.getElementById('js-share-course').addEventListener('click', function (e) {
  e.preventDefault();
  console.log('Share course button clicked'); // Log when the button is clicked

  Swal.fire({
    html: document.getElementById('courseShareModal').innerHTML,
    showCancelButton: false,
    showConfirmButton: false,
    customClass: {
      content: 'p-0 text-left'
    },
    didOpen: function () {
      console.log('SweetAlert modal opened'); // Log when the modal opens
      
      // Ensure tooltips are initialized correctly
      const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
      tooltips.forEach(function (tooltip) {
        new bootstrap.Tooltip(tooltip); // Initialize Bootstrap tooltips
      });
      console.log('Tooltip initialized'); // Log after initializing tooltips

      // Fix the modal content's positioning
      const swalModal = document.querySelector('.swal2-popup');
      if (swalModal) {
        swalModal.style.position = 'fixed'; // Ensure it's fixed
        swalModal.style.top = '50%';
        swalModal.style.left = '50%';
        swalModal.style.transform = 'translate(-50%, -50%)';
      }
    },
    width: '32rem'
  });

  console.log('SweetAlert modal triggered'); // Log after triggering the modal
});

document.addEventListener("DOMContentLoaded", function () {
  var marqueeElement = document.querySelector('.overflow-marquee');
  var anchorElement = marqueeElement.querySelector('a');

  // Check if the text exceeds the container's width
  if (anchorElement.scrollWidth > marqueeElement.clientWidth) {
    // Apply the marquee animation if the text overflows
    anchorElement.style.animation = 'marquee 10s linear infinite';
  }
});

</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('styles_top'); ?>
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <style>
      .demo-video-modal {
  width: 640px; /* Fixed width */
  height: 360px; /* Fixed height */
  margin: 0 auto; /* Center horizontally */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.demo-video-card {
  width: 100%; /* Ensure video player fits the modal */
  height: 100%; /* Match the modal height */
  display: flex;
  align-items: center;
  justify-content: center;
}

.swal2-popup {
  display: flex;
  align-items: center;
  justify-content: center;
}

.swal2-content {
  width: auto; /* Prevent content from stretching */
  max-width: 640px; /* Ensure the content doesn't exceed modal width */
  margin: auto;
  text-align: center;
}

        .cat {
            font-weight: bold;
        }

        .btn-modern {
            display: inline-block;
            padding: 10px 20px;
            /* Space inside the button */
            font-size: 14px;
            /* Font size */
            font-weight: bold;
            /* Bold text */
            background-color: var(--primary);
            /* Button background color */
            color: white;
            /* Text color */
            border: none;
            /* Remove the default border */
            border-radius: 15px;
            /* Rounded edges */
            text-align: center;
            /* Center the text */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background-color 0.3s, transform 0.2s;
            /* Smooth transitions */
            text-decoration: none;
            /* Remove underline if any */
            width: 100%;
        }

        .btn-modern:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            transform: translateY(-2px);
            /* Slightly raise the button */
        }

        .btn-modern:active {
            transform: translateY(1px);
            /* Add a small press effect */
        }

        .btn-modern:focus {
            outline: none;
            /* Remove the outline on focus */
        }

        .badges-lists {
            padding: 15px;
            top: 0;
            width: 100%
        }

        .webinar-card {
            position: relative;
            width: 100%;
            max-width: 400px;
            height: 550px;
            /* Adjusted height for buttons */
            overflow: hidden;
            border-radius: 24px !important;
            display: flex;
            flex-direction: column;
            color: white;
            cursor: pointer;
        }

        .webinar-card .stars-card {
            margin-top: 0 !important;
        }

        .webinar-figure {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            /* Push content to the bottom */
          z-index: 99;
        }

        .price-value {
            font-size: 1.2em;
            /* Adjust the size of the numeric part */
        }

        .currency-symbol {
            font-size: 0.8em;
            /* Make the currency symbol smaller */
            vertical-align: super;
            /* Optionally align the symbol above the number */
        }

        .webinar-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
            z-index: 1;
        }

        .webinar-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
            backdrop-filter: blur(50px);
            border-radius: 0 0 24px 24px;
            /* Rounded corners for the bottom */
            margin-top: auto;
            /* Push to the bottom */
            text-align: center;
        }




        .badge-container {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .badge {
            background-color: #ff5b5b;
            border-radius: 5px;
            font-size: 12px;
        }

        .webinar-title {
            font-size: 24px;
            font-weight: bold;
            position: relative;
        }

        .rate {
            margin: 5px 0 5px 0
        }

        .webinar-title a {
            color: white;
            text-decoration: none;
            transition: color 0.3s, transform 0.3s;
            position: relative;
            z-index: 1;
        }

        .webinar-title a:hover {
            color: white;
            /* Modern color change */
            transform: scale(1.1);
            /* Slight zoom effect */
        }
.overflow-marquee {
  display: inline-block;
  white-space: nowrap;
  overflow: hidden;
  width: 100%; /* Ensure the container has width */
  position: relative;
}

.overflow-marquee a {
  display: inline-block;
}

/* Marquee animation */
@keyframes marquee {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}

@media (max-width: 991px) {
  .overflow-marquee a {
    animation-duration: 15s; /* Adjust speed for mobile */
  }
}


        .webinar-title a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: white;
            /* Highlight color */
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        .webinar-card:hover .webinar-title a::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .webinar-teacher {
            font-size: 14px;
            text-align: start;
        }

        .webinar-teacher-name {
            font-weight: bold;
        }

        .webinar-info {
            font-size: 12px;
            margin-bottom: 10px;
            gap: 15px;
        }

        .webinar-price {
            font-size: 20px;
            font-weight: bold;
        }

        .badges-lists {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            /* Adds space between the columns */
        }

        .badge-column,
        .icon-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Adds space between each badge/icon */
        }

        .icon-column {
            margin-top: 15px;
        }

        .feather-solid {
            fill: currentColor;
            /* Makes icons solid */
        }

        .webinar-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Background for button section */
            backdrop-filter: blur(8px);
            /* Frosted glass effect */
            border-radius: 0 0 24px 24px;
            /* Match the bottom corners */
        }

        .badge-danger {
            background: red;
        }

        .original-price .price-value {
            text-decoration: line-through;
        }

        .original-price {
            color: red;
            /* Or any color to show it's crossed out */
        }

        .discounted-price {
            color: white;
            /* Or any color for the discounted price */
            font-weight: bold;

        }

        .original-price,
        .discounted-price {
            margin-inline: 5px;
        }
#webinarDemoVideoBtn {
    width: 120px; /* Set width for the circle */
    height: 120px; /* Set height equal to width */
    border-radius: 50%; /* Makes it a circle */
    color: white; /* Icon color */
    display: flex; /* Flex to center the icon */
    align-items: center; /* Center icon vertically */
    justify-content: center; /* Center icon horizontally */
    transition: transform 0.3s ease, background-color 0.3s ease; 
  border: 
}

#webinarDemoVideoBtn:hover {
    background-color: rgba(0, 0, 0, 0.9); /* Darker background on hover */
}

#webinarDemoVideoBtn i {
    pointer-events: none; /* Ensures the icon doesn't interfere with hover events */
}


        .enroll-btn {
            width: 100%;
            /* Full width minus padding */
            background-color: var(--secondary);
            /* Green */
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
            opacity: 0.8;
            backdrop-filter: blur(50px);
            -webkit-backdrop-filter: blur(8px);

        }

        #webinarDemoVideoBtn {
            margin-bottom: 10px;
            top: 20%;
            /* Vertical centering */
            left: 50%;
            /* Horizontal centering */
            transform: translate(-50%, -50%);
            /* Offsets by half of its size */
        }

        .enroll-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        .add-to-cart-btn {
            width: 10%;
            /* Icon button width */
            height: 40px;
            background-color: #007bff;
            /* Blue */
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }

        .add-to-cart-btn i {
            margin: 0;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/includes/webinar/grid-card.blade.php ENDPATH**/ ?>