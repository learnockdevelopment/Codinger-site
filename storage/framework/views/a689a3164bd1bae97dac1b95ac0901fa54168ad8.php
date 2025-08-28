<?php
    $videos  = [
        '/store/1/frog game.mp4',
        '/store/1/fruit game.mp4',
        '/store/1/maze game.mp4',
		'/store/1/jumping ant.mp4',
        '/store/1/fruit game.mp4',

		//'/store/1/reel1.mp4'

    ];

?>

<?php
    $tabs = [
        ["grade" => "Grade 1 - 2", "years" => "6 - 7"],
        ["grade" => "Grade 3 - 4", "years" => "8 - 9"],
        ["grade" => "Grade 5 - 6", "years" => "10 - 11"],
        ["grade" => "Grade 7 - 8", "years" => "12 - 13"],
        ["grade" => "Grade 9 - 10", "years" => "14 - 15"],
        ["grade" => "Grade 11 - 12", "years" => "16 - 17"],
    ];

    $colors = [
        ['main' => '#63c93b', 'sup' => '#FFFFFF'],
        ['main' => '#41d2d8', 'sup' => '#ffffff'],
        ['main' => '#ba00db', 'sup' => '#FFFFFF'],
       
    ];
?>



<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
                   
<link href="https://cdn.tailwindcss.com/3.4.1" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
<style>
  html {
    scroll-behavior: smooth;
}

        .btn-border-white {
            position: relative;
            display: inline-block;
            padding: 12px 24px;
            border: 2px solid var(--primary);
            background-color: transparent;
            color: var(--primary);
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 10px;
        }
      .content-box{padding: 50px}
        .search-input {
            border-radius: 24px !important;
            margin-top: 20px !important;
        }

        .search-input button {
            border-radius: 24px !important;
        }

        .btn-border-white:hover {
            border: 2px solid var(--primary);
            color: #fff;
            /* Change text color to white */
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            /* Gradient background */
            box-shadow: 0 0 10px 3px rgba(var(--primary-rgb), 0.4);
            /* Light shadow effect */
        }

        .blurred-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: blur(10px);
            transform: scale(1.05);
            background-attachment: fixed;
        }

    /*    .main-home-rapper section:nth-child(odd) {
            background: linear-gradient(135deg, #D0EFFF, #FAD0EC, #FFE5B4, #DCCEFF);
            

        } */

       /* .main-home-rapper section {
            padding: 90px 0px 90px;

        } */
      .price-home-cards .swiper-wrapper {
    display: flex;
    align-items: stretch; /* This will make all cards stretch to the same height */
}
      .price-home-cards .subscribe-plan {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* This will distribute the space evenly */
    flex-grow: 1; /* This will make the card stretch to fill the height */
}
      .price-home-cards .subscribes-swiper {
    height: auto; /* Allow the swiper to adjust its height based on the content */
}

.price-home-cards .swiper-slide {
    height: auto; /* Allow the slides to adjust their height based on the content */
}
    .tabs-home .tabs-container {
        
        justify-content: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
  .tabs-home .nav{
  display:grid !important;
  }
      .nav-tabs .nav-item a.active:after {content:none;}

    .tabs-home .nav-item a {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 23px;
        text-align: center;
        border-radius: 75px;
    }
   @media (min-width: 380px) {
    .tabs-home .nav-item a {
  padding:12px;
  }
}

  @media (min-width: 640px) {
    .tabs-home .nav-item a {
  padding:16px;
  }
}

/* Medium screens (≥ 768px) */
@media (min-width: 768px) {
  .tabs-home .nav-item a {
  padding:20px;
  }
}

/* Large screens (≥ 1024px) */
@media (min-width: 1024px) {
    
}

    .tabs-home .cards-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        padding: 40px;
    }

    .tabs-home .card {
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        font-size: 20px;
        transition: 0.3s ease-in-out;
    }

    .tabs-home .tab-pane {
        display: none;
    }

    .tabs-home .tab-pane.active {
    display: grid;
    gap: 20px; /* Default gap between items */
    grid-template-columns: repeat(1, 1fr); /* 1 column by default (mobile) */
}

/* Small screens (≥ 640px) */

 .tabs-home  .number-line {
        
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 24px;
        font-weight: bold;
        margin-top: 20px;
    }

     .tabs-home .number {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #112058; /* Default color */
        color: white;
        transition: background 0.3s ease-in-out;
    }

     .tabs-home .dashed-line {
        flex-grow: 1;
        height: 2px;
        border-top: 2px dashed #112058;
    } 

.card.update-card {
    width: 100%; 
    max-width: 100%;
    border-radius: 15px; 
    padding: 20px;
    transition: 0.3s ease-in-out;
}
  
 
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="main-home-rapper" >
        <?php if(!empty($heroSectionData)): ?>

            <?php if(!empty($heroSectionData['has_lottie']) and $heroSectionData['has_lottie'] == '1'): ?>
                <?php $__env->startPush('scripts_bottom'); ?>
                    <script src="/assets/default/vendors/lottie/lottie-player.js"></script>
                <?php $__env->stopPush(); ?>
            <?php endif; ?>

        <section>
    <div class="slider-container <?php echo e($heroSection == '2' ? 'slider-hero-section2' : ''); ?> lg:pt-64! md:pt-48! pt-12! relative px-6!"  style="background-image: url('<?php echo $heroSectionData['hero_vector']; ?>'); background-size: cover; background-position: bottom; background-repeat: no-repeat;">
        <?php if($heroSection == '1'): ?>
            <?php if(!empty($heroSectionData['is_video_background'])): ?>
                <video playsinline autoplay muted loop id="homeHeroVideoBackground" class="absolute inset-0 w-full h-full object-cover">
                    <source src="<?php echo $heroSectionData['hero_background']; ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <?php endif; ?>

        <div class="container mx-auto pt-0 select-none min-h-[60vh] " >
            <?php if($heroSection == '2'): ?>
                <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-8" >
                    <!-- Content Section -->
                    <div class="w-full ">
                       <h1 class="text-white!
xl:text-8xl!
lg::text-6xl!
md:text-4xl!
text-3xl!
text-center
font-normal!
font-['Nerko_One']!
[text-shadow:_0px_0px_25px_rgb(8_8_8_/_0.84)]!">
    <?php echo $heroSectionData['title']; ?>

</h1>


<p class="text-white! mt-3!
          text-center!
xl:text-2xl!
          md:text-xl!
          text-lg!
font-normal!
font-['Nerko_One']!
[text-shadow:_0px_0px_12px_rgb(80_78_78_/_0.58)]!">
    <?php echo trans('home.hero_subtitle_part_2'); ?>

</p>
                      <p class="text-white! mt-3!
          text-center!
xl:text-2xl!
          md:text-xl!
          text-lg!
font-normal!
font-['Nerko_One']!
[text-shadow:_0px_0px_12px_rgb(80_78_78_/_0.58)]!">
    <?php echo trans('home.hero_subtitle_part_1'); ?>

</p> 
<h2 class="text-white! mt-3!
          text-center!
xl:text-2xl!
          md:text-xl!
          text-lg!
font-normal!
font-['Nerko_One']!
[text-shadow:_0px_0px_12px_rgb(80_78_78_/_0.58)]!">
    <?php echo trans('home.hero_title'); ?>

</h2>


<!--
<p class="text-[1.25rem] md:text-[1.5rem] mt-2">
    <i class="fa-solid fa-check text-[#65C83C] mr-2"></i>
    <?php echo trans('home.feature_1'); ?>

</p>

<p class="text-[1.25rem] md:text-[1.5rem] mt-2">
    <i class="fa-solid fa-check text-[#65C83C] mr-2"></i>
    <?php echo trans('home.feature_2'); ?>

</p>

<p class="text-[1.25rem] md:text-[1.5rem] mt-2">
    <i class="fa-solid fa-check text-[#65C83C] mr-2"></i>
    <?php echo trans('home.feature_3'); ?>

</p> -->

                        <!-- Button Section -->
                        <div class="mt-6">
                            <form action="/search" method="get">
                                <div class="flex items-center justify-center">
                                    <button type="submit"
    class="text-white text-[1.25rem] md:text-[1.5rem]  px-[73px]! py-[11px]! bg-fuchsia-800! rounded-[40px]! shadow-[0px_4px_4px_2px_rgba(69,69,69,0.43)]!  hover:bg-[#4fa82c] transition-colors duration-300 text-white
text-base!
font-bold!
font-['Segoe_UI']!">
    <?php echo e(__('home.start_button')); ?>

</button>

                                </div>
                            </form>
                        </div>

                       <!-- <p class="mt-3 text-[1rem] md:text-[1.5rem] text-[#0082D6] font-light">
    <?php echo e(__('home.partnership_text')); ?>

</p> -->

<div class="logos-container absolute lg:bottom-[-250px] sm:bottom-[-200px] bottom-[-250px] inset-x-0">
  <div class="logos-track">
    <?php
      $logos = [
        'store/1/Picture10.png',
        'store/1/Picture11.png',
    'store/1/Picture12.png',
    'store/1/Picture13.png',
    'store/1/Picture14.png',


      ];
      // Clone logos enough times to fill the screen twice (for smooth looping)
      $repeatedLogos = array_merge($logos, $logos, $logos, $logos, $logos);
    ?>
    
    <?php $__currentLoopData = $repeatedLogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="logo-item">
        <img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(basename($logo)); ?>" loading="lazy">
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $repeatedLogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="logo-item">
        <img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(basename($logo)); ?>" loading="lazy">
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $repeatedLogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="logo-item">
        <img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(basename($logo)); ?>" loading="lazy">
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php $__currentLoopData = $repeatedLogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="logo-item" aria-hidden="true">
        <img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(basename($logo)); ?>" loading="lazy">
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>

<style>
  /* Base styles for the carousel container */
  .logos-container {
    --logo-height: 100px;
    overflow: hidden;
    position: relative;
    width: 100%;
    padding: 4rem 0;
    background: transparent;
    mask: linear-gradient(90deg, transparent 0%, white 15%, white 85%, transparent 100%);
  }

  /* Style for the carousel track (the actual scrolling content) */
  .logos-track {
    display: flex;
    align-items: center;
    gap: 4rem;
    width: max-content;
    will-change: transform;
    animation: scroll 20s linear infinite;
  }

  /* Style for each logo item */
  .logo-item {
    flex: 0 0 auto;
    height: var(--logo-height);
    transition: transform 0.3s ease;
  }

  /* Styling the images inside the logo items */
  .logo-item img {
    height: 100%;
    width: auto;
    max-width: 200px;
    object-fit: contain;
    filter: grayscale(100%);
    transition: all 0.3s ease;
  }

  /* Hover effect on the logos */
  .logo-item:hover img {
    filter: grayscale(0);
    transform: scale(1.1);
  }

  /* Keyframes for infinite scrolling animation */
  @keyframes scroll {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(-50%); /* Moves by half the total width */
    }
  }

  /* Responsive styling for smaller screens */
  @media (max-width: 768px) {
    .logos-container {
      --logo-height: 80px;
    }
    .logos-track {
      gap: 4rem;
    }
  }

  /* Adding the necessary classes to simulate Tailwind CSS utility effects */
  .logos-container, .logos-track, .logo-item, .logo-item img {
    box-sizing: border-box;
  }

  .logos-container {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    position: relative;
  }
  
  .logos-track {
    display: flex;
    gap: 4rem;
    animation: scroll 30s linear infinite;
  }

  .logo-item {
    flex: 0 0 auto;
    transition: transform 0.3s ease;
  }

  .logo-item img {
    height: 100%;
    width: auto;
    max-width: 200px;
    object-fit: contain;
    filter: grayscale(100%);
    transition: transform 0.3s ease, filter 0.3s ease;
  }

  .logo-item:hover img {
    transform: scale(1.1);
    filter: grayscale(0);
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.logos-track');
    const logos = document.querySelectorAll('.logo-item');
    const trackWidth = logos[0].offsetWidth * logos.length / 5; // Only measure the first set
    
    // Set the track width to double the content (for seamless looping)
    track.style.width = `${trackWidth * 2}px`;
    
    // Reset animation to prevent memory issues
    setInterval(() => {
      track.style.animation = 'none';
      void track.offsetWidth; // Force reflow
      track.style.animation = 'scroll 20s linear infinite';
    }, 30000); // Match animation duration
  });
</script>

                      
                      
                      
                 
                      
                      
                      
          </div>
                  
                  
                  
           

                    <!-- Photo Section (Hidden on screens smaller than xl) -->
                    <div class=" hidden! ">
                        <?php if(!empty($heroSectionData['has_lottie']) and $heroSectionData['has_lottie'] == '1'): ?>
                            <lottie-player src="<?php echo $heroSectionData['hero_vector']; ?>" background="transparent" speed="1" class="w-full" loop autoplay></lottie-player>
                        <?php else: ?>
                            <img src="<?php echo $heroSectionData['hero_vector']; ?>" alt="<?php echo $heroSectionData['title']; ?>" class="w-[15rem] md:w-[19.75rem] h-[35rem] md:h-[48.75rem] mx-auto object-cover">
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center pt-0 pb-12 md:pb-20">
                    <?php if(empty($heroSectionData['is_video_background'])): ?>
                        <img src="<?php echo e($heroSectionData['hero_background']); ?>" alt="Background Image" class="blurred-img">
                    <?php endif; ?>
                    <div class="pt-12 md:pt-[6.25rem]">
                        <h1 class="text-[2.5rem] md:text-[3rem] lg:text-[4rem]"><?php echo $heroSectionData['title']; ?></h1>
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-full md:w-9/12 lg:w-7/12">
                                <p class="mt-6 md:mt-8 text-[1rem] md:text-[1.125rem]"><?php echo $heroSectionData['description']; ?></p>
                                <form action="/search" method="get" class="inline-flex mt-6 md:mt-8 w-full">
                                    <div class="flex items-center bg-white p-2 md:p-3 w-full rounded-lg shadow-md ">
                                        <input type="text" name="search" class="form-input border-0 flex-grow mr-4" placeholder="<?php echo trans('home.slider_search_placeholder'); ?>">
                                        <button type="submit" class="bg-blue-500 text-white rounded-full px-6 py-2 hover:bg-blue-600 transition-colors duration-300"><?php echo trans('home.find'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
      
      
      
      
      
                                            
                      
      <section id="aboutUs" class="py-12 lg:mt-42! mt-24!">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-center justify-between!">
          <?php $__currentLoopData = $aboutSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Text content - takes 5/8 on large screens -->
            <div class="lg:w-5/8 xl:w-5/12">
                <h1 class="mb-6! text-3xl font-bold text-primary"><?php echo $about['title']; ?></h1>
                <p class="mb-6! text-lg text-gray-800! leading-relaxed!"><?php echo $about['description']; ?></p>
                
            </div>
            
            <!-- Image - takes 3/8 on large screens -->
            <div class="lg:w-3/8 xl:w-5/12">
                <img 
                    src="<?php echo e($about['link']); ?>" 
                    alt="About Us" 
                    class="w-full h-auto rounded-lg  object-cover"
                    loading="lazy"
                >
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
      
          
        <?php endif; ?>
<!--
<section>
    <div class="home-sections position-relative subscribes-container pe-none user-select-none tabs-home">
        <div class="your_learning_path">
            <div class="container">
              <h1 class="section-title text-center" style="font-size:40px; color:#112058;">
    <?php echo e(__('home.select_age_title')); ?>

</h1>
<div class="section-hint text-center text-[10px]">
    <?php echo e(__('home.select_age_hint')); ?>

</div>

                <div class="tabs py-10">
                    <ul class="nav nav-tabs tabs-container grid xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-2 gap-10 justify-center" 
                        id="tabsMenu2" role="tablist" style="border:0px !important;">
                      
                        <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item w-full col-span-1 max-w-[212px] mx-auto" role="presentation">
                                <a class="nav-link <?php echo e($index == 0 ? 'active' : ''); ?> flex flex-col items-center py-2 px-0
                                   transition duration-300 transform hover:scale-105"
                                   style="background: <?php echo e($category['color']); ?>; 
                                          color: <?php echo e($category['text_color']); ?>; 
                                          border-radius: 50px;"
                                   id="tab-<?php echo e($category['id']); ?>" 
                                   data-bs-toggle="tab" 
                                   href="#tab<?php echo e($category['id']); ?>"
                                   role="tab" 
                                   aria-controls="tab<?php echo e($category['id']); ?>" 
                                   aria-selected="<?php echo e($index == 0 ? 'true' : 'false'); ?>"
                                   data-color="<?php echo e($category['color']); ?>" 
                                   data-text-color="<?php echo e($category['text_color']); ?>"
                                   data-category-id="<?php echo e($category['id']); ?>">
                            
                                    <p class="tab-text tab-title text-lg sm:text-xl md:text-2xl font-semibold" 
                                       style="color: <?php echo e($category['text_color']); ?>">
                                       Grade <?php echo e($category['grade']); ?>

                                    </p>

                                    <p class="tab-text font-bold text-3xl sm:text-4xl md:text-5xl lg:text-[48px] my-1">
                                        <?php echo e($category['age_min']); ?> - <?php echo e($category['age_max']); ?>

                                    </p>

                                    <p class="tab-text px-4 py-1 text-lg sm:text-xl md:text-2xl font-medium"
                                       style="background: <?php echo e($category['text_color']); ?>; 
                                              color: <?php echo e($category['color']); ?>; 
                                              border-radius: 50px;">
                                        Years
                                    </p>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
              
              
              
              
              
              
<?php
    $filteredCourses = $courses->where('category_id', 0);
?>

<?php if($filteredCourses->isNotEmpty()): ?>
     <h1 class="section-title text-center dynamic-title" style="font-size:40px; color:#112058;">
    <?php echo e(__('home.learning_path_title')); ?>

</h1>

              
    <?php $__currentLoopData = $filteredCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(url('/course/' . $course['slug'])); ?>" style="text-decoration: none; color: inherit;">
            <div class="card update-card text-center"
                data-index="<?php echo e($course['id']); ?>"
                style="border-radius: 50px; padding: 20px; max-width: 100%; transition: 0.3s ease-in-out;">
                
                <img src="store/1/tabimg2.png" class="mb-1"/>

                <div class="d-flex justify-content-center gap-2">
                    <p class="card-badge"
                       style="font-size:12px; padding:8px 11px; border-radius:25px;">
                        <i class="fa-regular fa-clock"></i>  
                        <span style="font-weight:bold;margin:0px 2px;">3</span> Months
                    </p> 
                    <p class="card-badge"
                       style="font-size:12px; padding:8px 11px; border-radius:25px;">
                        <i class="fa-solid fa-chalkboard-user"></i>  
                        <span style="font-weight:bold;margin:0px 2px;">12</span> Live Sessions
                    </p> 
                </div>

                <p class="card-text" style="font-size:30px;">
                    <?php echo e($course['slug']); ?>

                </p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
                     <div class="number-line lg:flex hidden justify-center items-center w-3/4 mx-auto my-10">
                    <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                        1
                    </span>
                    <span class="dashed-line w-10 sm:w-14 md:w-16 lg:w-20 h-[2px] bg-gray-400"></span>
                    <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                        2
                    </span>
                    <span class="dashed-line w-10 sm:w-14 md:w-16 lg:w-20 h-[2px] bg-gray-400"></span>
                    <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                        3
                    </span>
                    <span class="dashed-line w-10 sm:w-14 md:w-16 lg:w-20 h-[2px] bg-gray-400"></span>
                    <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                        4
                    </span>
                </div>
<?php endif; ?>
              
              
              
              
              
              
              
      


            </div>
        </div>
    </div>
</section>
-->
      
      
<!--  --> 
<!--
 <div class="number-line lg:flex hidden justify-center items-center  mx-auto my-12!">
        <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg" 
              data-step="1" data-color="#112058">
            1
        </span>
        <span class="dashed-line w-10 sm:w-14 md:w-16 lg:w-86 h-[2px] bg-gray-400"></span>
        <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-gray-400 flex items-center justify-center text-gray-600 font-bold text-lg"
              data-step="2" data-color="#4CAF50">
            2
        </span>
        <span class="dashed-line w-10 sm:w-14 md:w-16 lg:w-86 h-[2px] bg-gray-400"></span>
        <span class="number w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-[47px] lg:h-[47px] rounded-full bg-gray-400 flex items-center justify-center text-gray-600 font-bold text-lg"
              data-step="3" data-color="#FF5722">
            3
        </span>
    </div>
-->












      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
        <?php $__currentLoopData = $homeSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(
                $homeSection->name == \App\Models\HomeSection::$featured_classes and
                    !empty($featureWebinars) and
                    !$featureWebinars->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="px-20 px-md-0">
                            <h2 class="section-title"><?php echo e(trans('home.featured_classes')); ?></h2>
                            <p class="section-hint"><?php echo e(trans('home.featured_classes_hint')); ?></p>
                        </div>

                        <div class="feature-slider-container position-relative d-flex justify-content-center mt-10">
                            <div class="swiper-container features-swiper-container pb-25">
                                <div class="swiper-wrapper py-10">
                                    <?php $__currentLoopData = $featureWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">

                                            <a href="<?php echo e($feature->webinar->getUrl()); ?>">
                                                <div class="feature-slider d-flex h-100"
                                                    style="background-image: url('<?php echo e($feature->webinar->getImage()); ?>')">
                                                    <div class="mask"></div>
                                                    <div class="p-5 p-md-25 feature-slider-card">
                                                        <div
                                                            class="d-flex flex-column feature-slider-body position-relative h-100">
                                                            <?php if($feature->webinar->bestTicket() < $feature->webinar->price): ?>
                                                                <span
                                                                    class="badge badge-danger mb-2 "><?php echo e(trans('public.offer', ['off' => $feature->webinar->bestTicket(true)['percent']])); ?></span>
                                                            <?php endif; ?>
                                                            <a href="<?php echo e($feature->webinar->getUrl()); ?>">
                                                                <h3 class="card-title mt-1"><?php echo e($feature->webinar->title); ?>

                                                                </h3>
                                                            </a>

                                                            <div
                                                                class="user-inline-avatar mt-15 d-flex align-items-center">
                                                                <div class="avatar bg-gray200">
                                                                    <img src="<?php echo e($feature->webinar->teacher->getAvatar()); ?>"
                                                                        class="img-cover"
                                                                        alt="<?php echo e($feature->webinar->teacher->full_naem); ?>"
                                                                         loading="lazy"
                                                                         >
                                                                </div>
                                                                <a href="<?php echo e($feature->webinar->teacher->getProfileUrl()); ?>"
                                                                    target="_blank"
                                                                    class="user-name font-14 ml-5"><?php echo e($feature->webinar->teacher->full_name); ?></a>
                                                            </div>

                                                            <p class="mt-25 feature-desc text-gray">
                                                                <?php echo e($feature->description); ?>

                                                            </p>

                                                            <?php echo $__env->make('web.default.includes.webinar.rate', [
                                                                'rate' => $feature->webinar->getRate(),
                                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                                            <div
                                                                class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex align-items-center">
                                                                        <i data-feather="clock" width="20"
                                                                            height="20" class="webinar-icon"></i>
                                                                        <span
                                                                            class="duration ml-5 text-dark-blue font-14"><?php echo e(convertMinutesToHourAndMinute($feature->webinar->duration)); ?>

                                                                            <?php echo e(trans('home.hours')); ?></span>
                                                                    </div>

                                                                    <div class="vertical-line mx-10"></div>

                                                                    <div class="d-flex align-items-center">
                                                                        <i data-feather="calendar" width="20"
                                                                            height="20" class="webinar-icon"></i>
                                                                        <span
                                                                            class="date-published ml-5 text-dark-blue font-14"><?php echo e(dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at, 'j M Y')); ?></span>
                                                                    </div>
                                                                </div>

                                                                <div class="feature-price-box">
                                                                    <?php if(!empty($feature->webinar->price) and $feature->webinar->price > 0): ?>
                                                                        <?php if($feature->webinar->bestTicket() < $feature->webinar->price): ?>
                                                                            <span
                                                                                class="real"><?php echo e(handlePrice($feature->webinar->bestTicket(), true, true, false, null, true)); ?></span>
                                                                        <?php else: ?>
                                                                            <?php echo e(handlePrice($feature->webinar->price, true, true, false, null, true)); ?>

                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <?php echo e(trans('public.free')); ?>

                                                                    <?php endif; ?>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="swiper-pagination features-swiper-pagination"></div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$latest_bundles and
                    !empty($latestBundles) and
                    !$latestBundles->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-between ">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('update.latest_bundles')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('update.latest_bundles_hint')); ?></p>
                            </div>

                            <a href="/classes?type[]=bundle"
                                class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container latest-bundle-swiper px-12">
                                <div class="swiper-wrapper py-20">
                                    <?php $__currentLoopData = $latestBundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latestBundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                                'webinar' => $latestBundle,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination bundle-webinars-swiper-pagination"></div>
                            </div>
                        </div>
                </section>
            <?php endif; ?>

            
            <?php if(
                $homeSection->name == \App\Models\HomeSection::$upcoming_courses and
                    !empty($upcomingCourses) and
                    !$upcomingCourses->isEmpty()): ?>
                <section class="home-sections home-sections-swiper container">
                    <div class="d-flex justify-content-between ">
                        <div>
                            <h2 class="section-title"><?php echo e(trans('update.upcoming_courses')); ?></h2>
                            <p class="section-hint"><?php echo e(trans('update.upcoming_courses_home_section_hint')); ?></p>
                        </div>

                    </div>

                    <div class="mt-10 position-relative">
                        <div class="swiper-container upcoming-courses-swiper px-12">
                            <div class="swiper-wrapper py-20">
                                <?php $__currentLoopData = $upcomingCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upcomingCourse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <?php echo $__env->make('web.default.includes.webinar.upcoming_course_grid_card', [
                                            'upcomingCourse' => $upcomingCourse,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="/upcoming_courses?sort=newest"
                                    class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination upcoming-courses-swiper-pagination"></div>
                        </div>
                    </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$latest_classes and
                    !empty($latestWebinars) and
                    !$latestWebinars->isEmpty()): ?>
                <section class="home-sections home-sections-swiper container">
                    <div class="d-flex justify-content-center ">
                        <div>
                            <h2 class="section-title"><?php echo e(trans('home.latest_classes')); ?></h2>
                            <p class="section-hint"><?php echo e(trans('home.latest_webinars_hint')); ?></p>
                        </div>


                    </div>

                    <div class="mt-10 position-relative">
                        <div class="swiper-container latest-webinars-swiper px-12">
                            <div class="swiper-wrapper py-20">
                                <?php $__currentLoopData = $latestWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latestWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                            'webinar' => $latestWebinar,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="/classes?sort=newest"
                                    class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination latest-webinars-swiper-pagination"></div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$best_rates and
                    !empty($bestRateWebinars) and
                    !$bestRateWebinars->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.best_rates')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.best_rates_hint')); ?></p>
                            </div>

                            <a href="/classes?sort=best_rates"
                                class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container best-rates-webinars-swiper px-12">
                                <div class="swiper-wrapper py-20">
                                    <?php $__currentLoopData = $bestRateWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bestRateWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                                'webinar' => $bestRateWebinar,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination best-rates-webinars-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$trend_categories and
                    !empty($trendCategories) and
                    !$trendCategories->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-center">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.trending_categories')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.trending_categories_hint')); ?></p>
                            </div>



                        </div>
                        <div class="swiper-container trend-categories-swiper px-12 mt-40">
                            <div class="swiper-wrapper py-20">
                                <?php $__currentLoopData = $trendCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo e($trend->category->getUrl()); ?>">
                                            <div class="trending-card d-flex flex-column align-items-center w-100">
                                                <div class="trending-image d-flex align-items-center justify-content-center w-100"
                                                    style="background-color: <?php echo e($trend->color); ?>">
                                                    <div class="icon mb-3">
                                                        <img src="<?php echo e($trend->getIcon()); ?>" width="10" loading="lazy"
                                                            class="img-cover" alt="<?php echo e($trend->category->title); ?>">
                                                    </div>
                                                </div>

                                                <div class="item-count px-10 px-lg-20 py-5 py-lg-10">
                                                    <?php echo e($trend->category->webinars_count); ?> <?php echo e(trans('product.course')); ?>

                                                </div>

                                                <h3><?php echo e($trend->category->title); ?></h3>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination trend-categories-swiper-pagination"></div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            
            <?php if(
                $homeSection->name == \App\Models\HomeSection::$full_advertising_banner and
                    !empty($advertisingBanners1) and
                    count($advertisingBanners1)): ?>
                <div class="home-sections container">
                    <div class="row">
                        <?php $__currentLoopData = $advertisingBanners1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-<?php echo e($banner1->size); ?>">
                                <a href="<?php echo e($banner1->link); ?>">
                                    <img src="<?php echo e($banner1->image); ?>" class="img-cover rounded-sm" loading="lazy"
                                        alt="<?php echo e($banner1->title); ?>">
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
            

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$best_sellers and
                    !empty($bestSaleWebinars) and
                    !$bestSaleWebinars->isEmpty()): ?>
                <section>
                    <div class="home-sections container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.best_sellers')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.best_sellers_hint')); ?></p>
                            </div>

                            <a href="/classes?sort=bestsellers"
                                class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container best-sales-webinars-swiper px-12">
                                <div class="swiper-wrapper py-20">
                                    <?php $__currentLoopData = $bestSaleWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bestSaleWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                                'webinar' => $bestSaleWebinar,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination best-sales-webinars-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$discount_classes and
                    !empty($hasDiscountWebinars) and
                    !$hasDiscountWebinars->isEmpty()): ?>
                <section>
                    <div class="home-sections container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.discount_classes')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.discount_classes_hint')); ?></p>
                            </div>

                            <a href="/classes?discount=on" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container has-discount-webinars-swiper px-12">
                                <div class="swiper-wrapper py-20">
                                    <?php $__currentLoopData = $hasDiscountWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hasDiscountWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                                'webinar' => $hasDiscountWebinar,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination has-discount-webinars-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$free_classes and
                    !empty($freeWebinars) and
                    !$freeWebinars->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.free_classes')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.free_classes_hint')); ?></p>
                            </div>

                            <a href="/classes?free=on" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container free-webinars-swiper px-12">
                                <div class="swiper-wrapper py-20">

                                    <?php $__currentLoopData = $freeWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freeWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.includes.webinar.grid-card', [
                                                'webinar' => $freeWebinar,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination free-webinars-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$store_products and
                    !empty($newProducts) and
                    !$newProducts->isEmpty()): ?>
                <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('update.store_products')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('update.store_products_hint')); ?></p>
                            </div>

                            <a href="/products" class="btn btn-border-white"><?php echo e(trans('update.all_products')); ?></a>
                        </div>

                        <div class="mt-10 position-relative">
                            <div class="swiper-container new-products-swiper px-12">
                                <div class="swiper-wrapper py-20">

                                    <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <?php echo $__env->make('web.default.products.includes.card', [
                                                'product' => $newProduct,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination new-products-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$testimonials and
                    !empty($testimonials) and
                    !$testimonials->isEmpty()): ?>
 <!-- Testimonials Section -->
<section id="testimonials" class="testimonials-section">
    <div class="testimonials-container">
        <!-- Section Header -->
        <div class="section-header text-center">
            <h2 class="section-title"><?php echo e(trans('home.testimonials')); ?></h2>
        </div>

        <!-- Testimonials Slider -->
        <div class="testimonials-slider">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <!-- Testimonial Card -->
                        <div class="testimonial-card">
                            <!-- Video Thumbnail with First Frame and Play Button -->
                            <div class="video-thumbnail" 
                                 data-video-src="<?php echo e($testimonial->user_avatar); ?>"
                                 data-poster="<?php echo e($testimonial->user_avatar_thumbnail ?? $testimonial->user_avatar); ?>">
                                <video class="first-frame-video" muted playsinline>
                                    <source src="<?php echo e($testimonial->user_avatar); ?>" type="video/mp4">
                                </video>
                                <div class="thumbnail-overlay">
                                    <button class="play-button">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Testimonial Content -->
                           <!-- <div class="testimonial-content">
                                <h3 class="testimonial-name"><?php echo e($testimonial->user_name); ?></h3>
                                <p class="testimonial-text"><?php echo e($testimonial->content); ?></p>
                            </div> -->
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Slider Navigation -->
              <!--  <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>-->
            </div>
        </div>
    </div>

    <!-- Video Modal with Overlay -->
    <div class="video-modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="close-modal">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
            <div class="video-wrapper">
                <video controls class="modal-video">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        </div>
    </div>
</section>

<style>
    /* Base Styles */
    .testimonials-section {
        position: relative;
        padding: 5rem 0;
        background: #f9f9f9;
        overflow: hidden;
    }
    
    .testimonials-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
    }
    
    .section-title {
        font-size: 2.5rem;
        margin-bottom: 3rem;
        color: #333;
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #0082d6;
    }
    
    /* Testimonial Card Styles */
    .testimonial-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    .testimonial-content {
        padding: 25px;
        flex-grow: 1;
    }
    
    .testimonial-name {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #333;
    }
    
    .testimonial-text {
        color: #666;
        line-height: 1.6;
    }
    
    /* Video Thumbnail Styles */
    .video-thumbnail {
        position: relative;
        width: 100%;
        height: 350px;
        cursor: pointer;
        overflow: hidden;
    }
    
    .video-thumbnail video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .thumbnail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
       /* background: rgba(0, 0, 0, 0.3); */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        transition: all 0.3s ease;
    }
    
    .play-button {
        width: 70px;
        height: 70px;
        background: rgba(0, 130, 214, 0.9);
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        transform: scale(0.9);
    }
    
    .play-button svg {
        width: 25px;
        height: 25px;
        fill: white;
        margin-left: 5px;
    }
    
    .video-thumbnail:hover .thumbnail-overlay {
        background: rgba(0, 0, 0, 0.5);
    }
    
    .video-thumbnail:hover .play-button {
        transform: scale(1);
        background: rgba(0, 130, 214, 1);
    }
    
    .video-thumbnail:hover video {
        transform: scale(1.05);
    }
    
    /* Video Modal Styles */
    .video-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .video-modal.active {
        opacity: 1;
        visibility: visible;
              background: rgba(0, 0, 0, 0.5);

    }
    
    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        position: relative;
        width: 85%;
        max-width: 1000px;
        z-index: 2;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    
    .video-modal.active .modal-content {
        transform: scale(1);
    }
    
    .close-modal {
        position: absolute;
        top: -50px;
        right: 0;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        z-index: 3;
    }
    
    .close-modal svg {
        width: 28px;
        height: 28px;
        fill: white;
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .close-modal:hover svg {
        opacity: 1;
        transform: rotate(90deg);
    }
    
    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }
    
    .modal-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        outline: none;
    }
    
    /* Swiper Styles */
    .testimonials-slider {
        padding: 30px 10px 60px;
        position: relative;
    }
    
    .swiper-container {
        overflow: visible;
    }
    
    .swiper-wrapper {
        padding-bottom: 20px;
    }
    
    .swiper-slide {
        height: auto;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }
    
    .swiper-slide-active, .swiper-slide-duplicate-active {
        opacity: 1;
    }
    
    .swiper-pagination {
        bottom: 20px !important;
    }
    
    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: #ccc;
        opacity: 1;
        transition: all 0.3s ease;
    }
    
    .swiper-pagination-bullet-active {
        background: #0082d6;
        transform: scale(1.2);
    }
    
    .swiper-button-next, .swiper-button-prev {
        color: #0082d6;
        background: rgba(255, 255, 255, 0.8);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 20px;
        font-weight: bold;
    }
    
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: white;
        transform: scale(1.1);
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }
        
        .video-thumbnail {
            height: 200px;
        }
        
        .modal-content {
            width: 95%;
        }
        
        .close-modal {
            top: -60px;
        }
        
        .swiper-button-next, .swiper-button-prev {
            display: none;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper with enhanced configuration
    const swiper = new Swiper('.swiper-container', {
        loop: false,
        slidesPerView: 1,
        spaceBetween: 30,
            initialSlide: 1, // Start from the second slide (index 1)
        centeredSlides: true,
      dots:false,
        autoplay: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: false,
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
                centeredSlides: false,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            }
        }
    });
    
    // Handle first frame display for all videos
    const firstFrameVideos = document.querySelectorAll('.first-frame-video');
    
    firstFrameVideos.forEach(video => {
        // Set video to show first frame
        video.currentTime = 0.1;
        
        // Try to play briefly to ensure first frame shows
        const playPromise = video.play();
        
        if (playPromise !== undefined) {
            playPromise.then(() => {
                // Immediately pause after starting playback
                setTimeout(() => {
                    video.pause();
                    video.currentTime = 0;
                }, 100);
            }).catch(error => {
                // Autoplay was prevented, just show first frame
                video.currentTime = 0;
            });
        }
    });
    
    // Video Modal functionality
    const modal = document.querySelector('.video-modal');
    const modalVideo = document.querySelector('.modal-video');
    const closeModal = document.querySelector('.close-modal');
    const videoThumbnails = document.querySelectorAll('.video-thumbnail');
    
    // Open modal when thumbnail is clicked
    videoThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const videoSrc = this.getAttribute('data-video-src');
            const posterSrc = this.getAttribute('data-poster');
            
            // Set video source
            modalVideo.innerHTML = `<source src="${videoSrc}" type="video/mp4">`;
            modalVideo.poster = posterSrc;
            
            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
            
            // Attempt to play video
            modalVideo.muted = false;
            const playPromise = modalVideo.play();
            
            if (playPromise !== undefined) {
                playPromise.catch(error => {
                    // Auto-play was prevented, show controls
                    modalVideo.controls = true;
                    console.log("Autoplay prevented:", error);
                });
            }
        });
    });
    
    // Close modal functions
    function closeVideoModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
        modalVideo.pause();
        modalVideo.currentTime = 0;
        modalVideo.controls = false;
    }
    
    closeModal.addEventListener('click', closeVideoModal);
    document.querySelector('.modal-overlay').addEventListener('click', closeVideoModal);
    
    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeVideoModal();
        }
    });
    
    // Pause videos when they're not visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && modal.classList.contains('active')) {
            modalVideo.pause();
        }
    });
});
</script>
            <?php endif; ?>








            <?php if($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty()): ?>
                <!--  الاسعاااار    -->
                <!--  الاسعاااار    -->
                <section class="price-home-cards 2xl:px-84!">
    <div class="home-sections position-relative subscribes-container pe-none user-select-none">
        <div id="parallax4" class="ltr d-none d-md-block">
            <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
        </div>

        <div class="home-sections home-sections-swiper">
            <div class="container-lg">
                <div class="text-center">
                    <h1 class="section-title text-center dynamic-title xl:text-[40px]! lg:text-[34px]! text-[28px]!" style=" color:#112058;">
                        <?php echo e(trans('home.learning_memberships')); ?>

                    </h1>
                </div>

                <div class="position-relative mt-30">
                    <div class="">
                        <div class=" py-20" style="display: flex; align-items: stretch !important;justify-content:center;gap:40px;">
                          <script>console.log(<?php echo json_encode($subscribes, 15, 512) ?>)</script>
<?php $__currentLoopData = $subscribes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subscribe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
    <?php
        $color = $colors[$index % count($colors)]; // Cycle through colors
        $mainColor = $color['main'];
        $supColor = $color['sup'];
        $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
    ?>

    <div class="">
        <div class="min-h-96! px-7! py-3! bg-white! relative rounded-[40px]! flex! flex-col! justify-start! items-center! gap-8! overflow-hidden! border-1! border-[#64C83A]! shadow-lg!">
           
          
         <!-- <div class="absolute left-0 top-0 h-16 w-16">
    <div
      class="absolute transform rotate-[-45deg]! <?php if($subscribe->is_popular): ?> bg-secondary <?php else: ?> bg-primary <?php endif; ?> text-center text-white font-semibold py-1 right-[-65px] top-[32px] w-[170px]">
      20% off
    </div>
  </div> -->
          
          <!-- Banner Section -->
            <div class=" text-center! py-4! rounded-full! mb-4!" style="background: <?php echo e($mainColor); ?>;">
               <div class="self-stretch! w-44 h-36!  rounded-[70px]! flex! flex-col! justify-center! items-center! gap-2.5!"
                     style="background: <?php echo e($mainColor); ?>;">
                   <div class="justify-start! text-white! lg:text-4xl! text-3xl! font-bold! font-['Segoe_UI']!">
    <?php echo e(Str::of($subscribe->title)->before(' ')); ?>

</div>

               
            </div>
 </div>
            <!-- Features List -->
            <div class="self-stretch! w-full! px-4!">
                <div class="flex! flex-col! justify-start! items-start! gap-4! w-full!">
                    <!-- Days of Subscription -->
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                            <?php echo e($subscribe->days); ?> <?php echo e(trans('financial.days_of_subscription')); ?>

                        </span>
                       
                    </div>
                    
                    <!-- Description -->
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                           <?php echo e(trans('home.tecguid')); ?>Technical Guidance
                        </span>
                    </div>
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                          <?php echo e(trans('home.group')); ?> Limited Group
                        </span>
                    </div>
                    
                    <!-- Usable Count -->
                    
                </div>
            </div>

            <!-- Purchase Button -->
            

                    <a href="/subscribe_details/<?php echo e($subscribe->id); ?>" class="w-48! h-11! px-20! py-2.5! rounded-[40px]! inline-flex! justify-center! items-center! gap-2.5! overflow-hidden! text-white! text-base! font-bold! font-['Segoe_UI']!" style="background: #812895;">
                        <?php echo e(trans('update.details')); ?>

                    </a>

                   
         
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination subscribes-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="parallax5" class="ltr d-none d-md-block">
            <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
        </div>

        <div id="parallax6" class="ltr d-none d-md-block">
            <div data-depth="0.6" class="gradient-box bottom-gradient-box"></div>
        </div>
    </div>
</section>

             
<script>
document.addEventListener('DOMContentLoaded', function () {
    const subscribesSwiper = new Swiper('.subscribes-swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 52,
        pagination: {
            el: '.subscribes-swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.subscribes-swiper-next',
            prevEl: '.subscribes-swiper-prev',
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
});
</script>         
                      
                      
                      
                      
                      
        
                      
                
                      
                  

   
                      
                      
            <?php endif; ?>









            <?php if($homeSection->name == \App\Models\HomeSection::$find_instructors and !empty($findInstructorSection)): ?>
               <!-- <section>
                    <div class="home-sections home-sections-swiper container find-instructor-section position-relative">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6">
                                <div class="">
                                    <h2 class="font-36 font-weight-bold text-dark">
                                        <?php echo e($findInstructorSection['title'] ?? ''); ?>

                                    </h2>
                                    <p class="font-16 font-weight-normal text-gray mt-10">
                                        <?php echo e($findInstructorSection['description'] ?? ''); ?></p>

                                    <div class="mt-35 d-flex align-items-center">
                                        <?php if(
                                            !empty($findInstructorSection['button1']) and
                                                !empty($findInstructorSection['button1']['title']) and
                                                !empty($findInstructorSection['button1']['link'])): ?>
                                            <a href="<?php echo e($findInstructorSection['button1']['link']); ?>"
                                                class="btn btn-primary mr-15"><?php echo e($findInstructorSection['button1']['title']); ?></a>
                                        <?php endif; ?>

                                        <?php if(
                                            !empty($findInstructorSection['button2']) and
                                                !empty($findInstructorSection['button2']['title']) and
                                                !empty($findInstructorSection['button2']['link'])): ?>
                                            <a href="<?php echo e($findInstructorSection['button2']['link']); ?>"
                                                class="btn btn-outline-primary"><?php echo e($findInstructorSection['button2']['title']); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                                <div class="position-relative ">
                                    <img src="<?php echo e($findInstructorSection['image']); ?>" class="find-instructor-section-hero"
                                        alt="<?php echo e($findInstructorSection['title']); ?>">
                                    <img src="/assets/default/img/home/circle-4.png"
                                        class="find-instructor-section-circle" alt="circle">
                                    <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                        alt="dots">

                                    <div
                                        class="example-instructor-card bg-white rounded-sm shadow-lg  p-5 p-md-15 d-flex align-items-center">
                                        <div class="example-instructor-card-avatar">
                                            <img src="/assets/default/img/home/toutor_finder.svg"
                                                class="img-cover rounded-circle" alt="user name">
                                        </div>

                                        <div class="flex-grow-1 ml-15">
                                            <span
                                                class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.looking_for_an_instructor')); ?></span>
                                            <span
                                                class="text-gray font-12 font-weight-500"><?php echo e(trans('update.find_the_best_instructor_now')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$reward_program and !empty($rewardProgramSection)): ?>
              <!--  <section>
                    <div class="home-sections home-sections-swiper container reward-program-section position-relative">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6">
                                <div class="position-relative reward-program-section-hero-card">
                                    <img src="<?php echo e($rewardProgramSection['image']); ?>" class="reward-program-section-hero"
                                        alt="<?php echo e($rewardProgramSection['title']); ?>">

                                    <div
                                        class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                        <div class="example-reward-card-medal">
                                            <img src="/assets/default/img/rewards/medal.png"
                                                class="img-cover rounded-circle" alt="medal">
                                        </div>

                                        <div class="flex-grow-1 ml-15">
                                            <span
                                                class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.you_got_50_points')); ?></span>
                                            <span
                                                class="text-gray font-12 font-weight-500"><?php echo e(trans('update.for_completing_the_course')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                                <div class="">
                                    <h2 class="font-36 font-weight-bold text-dark">
                                        <?php echo e($rewardProgramSection['title'] ?? ''); ?>

                                    </h2>
                                    <p class="font-16 font-weight-normal text-gray mt-10">
                                        <?php echo e($rewardProgramSection['description'] ?? ''); ?></p>

                                    <div class="mt-35 d-flex align-items-center">
                                        <?php if(
                                            !empty($rewardProgramSection['button1']) and
                                                !empty($rewardProgramSection['button1']['title']) and
                                                !empty($rewardProgramSection['button1']['link'])): ?>
                                            <a href="<?php echo e($rewardProgramSection['button1']['link']); ?>"
                                                class="btn btn-primary mr-15"><?php echo e($rewardProgramSection['button1']['title']); ?></a>
                                        <?php endif; ?>

                                        <?php if(
                                            !empty($rewardProgramSection['button2']) and
                                                !empty($rewardProgramSection['button2']['title']) and
                                                !empty($rewardProgramSection['button2']['link'])): ?>
                                            <a href="<?php echo e($rewardProgramSection['button2']['link']); ?>"
                                                class="btn btn-outline-primary"><?php echo e($rewardProgramSection['button2']['title']); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$become_instructor and !empty($becomeInstructorSection)): ?>
             <!--   <section>
                    <div class="home-sections home-sections-swiper container find-instructor-section position-relative">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6">
                                <div class="">
                                    <h2 class="font-36 font-weight-bold text-dark">
                                        <?php echo e($becomeInstructorSection['title'] ?? ''); ?>

                                    </h2>
                                    <p class="font-16 font-weight-normal text-gray mt-10">
                                        <?php echo e($becomeInstructorSection['description'] ?? ''); ?></p>

                                    <div class="mt-35 d-flex align-items-center">
                                        <?php if(
                                            !empty($becomeInstructorSection['button1']) and
                                                !empty($becomeInstructorSection['button1']['title']) and
                                                !empty($becomeInstructorSection['button1']['link'])): ?>
                                            <a href="<?php echo e(empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button1']['link'] : '/panel/financial/registration-packages')); ?>"
                                                class="btn btn-primary mr-15"><?php echo e($becomeInstructorSection['button1']['title']); ?></a>
                                        <?php endif; ?>

                                        <?php if(
                                            !empty($becomeInstructorSection['button2']) and
                                                !empty($becomeInstructorSection['button2']['title']) and
                                                !empty($becomeInstructorSection['button2']['link'])): ?>
                                            <a href="<?php echo e(empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button2']['link'] : '/panel/financial/registration-packages')); ?>"
                                                class="btn btn-outline-primary"><?php echo e($becomeInstructorSection['button2']['title']); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                                <div class="position-relative ">
                                    <img src="<?php echo e($becomeInstructorSection['image']); ?>"
                                        class="find-instructor-section-hero"
                                        alt="<?php echo e($becomeInstructorSection['title']); ?>">
                                    <img src="/assets/default/img/home/circle-4.png"
                                        class="find-instructor-section-circle" alt="circle">
                                    <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                        alt="dots">

                                    <div
                                        class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                                        <div class="example-instructor-card-avatar">
                                            <img src="/assets/default/img/home/become_instructor.svg"
                                                class="img-cover rounded-circle" alt="user name">
                                        </div>

                                        <div class="flex-grow-1 ml-15">
                                            <span
                                                class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.become_an_instructor')); ?></span>
                                            <span
                                                class="text-gray font-12 font-weight-500"><?php echo e(trans('update.become_instructor_tagline')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$forum_section and !empty($forumSection)): ?>
            <!--    <section>
                    <div class="home-sections home-sections-swiper container find-instructor-section position-relative">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                                <div class="position-relative ">
                                    <img src="<?php echo e($forumSection['image']); ?>" class="find-instructor-section-hero"
                                        alt="<?php echo e($forumSection['title']); ?>">
                                    <img src="/assets/default/img/home/circle-4.png"
                                        class="find-instructor-section-circle" alt="circle">
                                    <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                        alt="dots">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="">
                                    <h2 class="font-36 font-weight-bold text-dark"><?php echo e($forumSection['title'] ?? ''); ?>

                                    </h2>
                                    <p class="font-16 font-weight-normal text-gray mt-10">
                                        <?php echo e($forumSection['description'] ?? ''); ?></p>

                                    <div class="mt-35 d-flex align-items-center">
                                        <?php if(
                                            !empty($forumSection['button1']) and
                                                !empty($forumSection['button1']['title']) and
                                                !empty($forumSection['button1']['link'])): ?>
                                            <a href="<?php echo e($forumSection['button1']['link']); ?>"
                                                class="btn btn-primary mr-15"><?php echo e($forumSection['button1']['title']); ?></a>
                                        <?php endif; ?>

                                        <?php if(
                                            !empty($forumSection['button2']) and
                                                !empty($forumSection['button2']['title']) and
                                                !empty($forumSection['button2']['link'])): ?>
                                            <a href="<?php echo e($forumSection['button2']['link']); ?>"
                                                class="btn btn-outline-primary"><?php echo e($forumSection['button2']['title']); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$video_or_image_section and !empty($boxVideoOrImage)): ?>
              <!--  <section>
                    <div class="home-sections home-sections-swiper position-relative">
                        <div class="home-video-mask"></div>
                        <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative"
                            style="background-image: url('<?php echo e($boxVideoOrImage['background'] ?? ''); ?>')">
                            <a href="<?php echo e($boxVideoOrImage['link'] ?? ''); ?>"
                                class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
                                <i data-feather="play" width="36" height="36" class=""></i>
                            </a>

                            <div class="mt-50 pt-10 text-center">
                                <h2 class="home-video-title"><?php echo e($boxVideoOrImage['title'] ?? ''); ?></h2>
                                <p class="home-video-hint mt-10"><?php echo e($boxVideoOrImage['description'] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$instructors and !empty($instructors) and !$instructors->isEmpty()): ?>
              <!--  <section>
                    <div class="home-sections container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.instructors')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.instructors_hint')); ?></p>
                            </div>

                            <a href="/instructors" class="btn btn-border-white"><?php echo e(trans('home.all_instructors')); ?></a>
                        </div>

                        <div class="position-relative mt-20 ltr">
                            <div class="owl-carousel customers-testimonials instructors-swiper-container">

                                <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item">
                                        <div class="shadow-effect" style="background: transparent; box-shadow: none;">
                                            <div
                                                class="instructors-card d-flex flex-column align-items-center justify-content-center">
                                                <div class="instructors-card-avatar">
                                                    <img src="<?php echo e($instructor->getAvatar(108)); ?>"
                                                        alt="<?php echo e($instructor->full_name); ?>"
                                                        class="rounded-circle img-cover">
                                                </div>
                                                <div class="instructors-card-info mt-10 text-center">
                                                    <a href="<?php echo e($instructor->getProfileUrl()); ?>" target="_blank">
                                                        <h3 class="font-16 font-weight-bold text-dark-blue"
                                                            style="color: var(--primary)"><?php echo e($instructor->full_name); ?>

                                                        </h3>
                                                    </a>

                                                    <p class="font-14 text-gray mt-5"><?php echo e($instructor->bio); ?></p>
                                                    <div
                                                        class="stars-card d-flex align-items-center justify-content-center mt-10">
                                                        <?php
                                                            $i = 5;
                                                        ?>
                                                        <?php while(--$i >= 5 - $instructor->rates()): ?>
                                                            <i data-feather="star" width="20" height="20"
                                                                class="active"></i>
                                                        <?php endwhile; ?>
                                                        <?php while($i-- >= 0): ?>
                                                            <i data-feather="star" width="20" height="20"
                                                                class=""></i>
                                                        <?php endwhile; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            
            <?php if(
                $homeSection->name == \App\Models\HomeSection::$half_advertising_banner and
                    !empty($advertisingBanners2) and
                    count($advertisingBanners2)): ?>
               <!-- <div class="home-sections container">
                    <div class="row">
                        <?php $__currentLoopData = $advertisingBanners2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-<?php echo e($banner2->size); ?>">
                                <a href="<?php echo e($banner2->link); ?>">
                                    <img src="<?php echo e($banner2->image); ?>" class="img-cover rounded-sm"
                                        alt="<?php echo e($banner2->title); ?>">
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div> -->
            <?php endif; ?>
            

            <?php if(
                $homeSection->name == \App\Models\HomeSection::$organizations and
                    !empty($organizations) and
                    !$organizations->isEmpty()): ?>
               <!-- <section>
                    <div class="home-sections home-sections-swiper container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.organizations')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.organizations_hint')); ?></p>
                            </div>

                            <a href="/organizations"
                                class="btn btn-border-white"><?php echo e(trans('home.all_organizations')); ?></a>
                        </div>

                        <div class="position-relative mt-20">
                            <div class="swiper-container organization-swiper-container px-12">
                                <div class="swiper-wrapper py-20">

                                    <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <div
                                                class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                                                <div class="home-organizations-avatar">
                                                    <img src="<?php echo e($organization->getAvatar(120)); ?>"
                                                        class="img-cover rounded-circle"
                                                        alt="<?php echo e($organization->full_name); ?>">
                                                </div>
                                                <a href="<?php echo e($organization->getProfileUrl()); ?>"
                                                    class="mt-25 d-flex flex-column align-items-center justify-content-center">
                                                    <h3 class="home-organizations-title"><?php echo e($organization->full_name); ?>

                                                    </h3>
                                                    <p class="home-organizations-desc mt-10"><?php echo e($organization->bio); ?></p>
                                                    <span
                                                        class="home-organizations-badge badge mt-15"><?php echo e($organization->webinars_count); ?>

                                                        <?php echo e(trans('panel.classes')); ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="swiper-pagination organization-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <?php endif; ?>

            <?php if($homeSection->name == \App\Models\HomeSection::$blog and !empty($blog) and !$blog->isEmpty()): ?>
               <!-- <section>
                    <div class="home-sections container">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="section-title"><?php echo e(trans('home.blog')); ?></h2>
                                <p class="section-hint"><?php echo e(trans('home.blog_hint')); ?></p>
                            </div>

                            <a href="/blog" class="btn btn-border-white"><?php echo e(trans('home.all_blog')); ?></a>
                        </div>

                        <div class="row mt-35">

                            <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                                    <?php echo $__env->make('web.default.blog.grid-list', ['post' => $post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </section> -->
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
<section class="mt-24 mb-24" style="" id="projects">
    <div class="container">
        <!-- Your existing parallax and container code remains the same -->
        <div id="parallax1" class="ltr">
            <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
        </div>

        <div class="home-sections home-sections-swiper"
            style="max-width:100% !important; 
            background-image: url(https://cdn.prod.website-files.com/655a780…/6574a39…_bg-stars.webp);
            background-position: 50% 71px;
            background-repeat: no-repeat;
            background-size: contain;
            margin-top: 0px;">
            
            <div class="text-center" style="margin-bottom:40px;">
                <h2 class="section-title"><?php echo e(trans('home.projects')); ?></h2>
                <p class="section-hint"></p>
            </div>

            <div class="position-relative">
                <div class="swiper-container testimonials-swiper-projects-fix">
                    <div class="swiper-wrapper">
                      <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Video Thumbnail Card (unchanged) -->
    <div class="swiper-slide">
        <div class="testimonials-card rounded-sm bg-white text-start pb-3"
            style="background-color:transparent; overflow:hidden; max-width:516px; margin:0 auto;">
            <div class="d-flex flex-column align-items-center position-relative">
                <div class="testimonials-user-avatar position-relative" 
                    style="position: static; width:100%; height:100%; cursor: pointer;"
                    onclick="openProjectModal('<?php echo e(asset($video)); ?>')">
                    
                   <video width="100%" height="100%"
       style="object-fit: cover;"
       poster="/store/1/theposter<?php echo e($index + 1); ?>.jpg"
       class="max-h-84!"
       muted playsinline
       preload="metadata"
       autoplay="false">
    <source src="<?php echo e(asset($video)); ?>#t=0.1" type="video/mp4">
</video>
                    
                    <!-- Play Button Overlay -->
                    <div class="play-overlay position-absolute top-0 left-0 w-100 h-100 d-flex justify-content-center align-items-center"
                        style="background: rgba(0, 0, 0, 0.3);">
                        <div class="play-icon" style="width: 60px; height: 60px; background: rgba(0, 130, 214, 0.9); border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M8 5V19L19 12L8 5Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="swiper-pagination testimonials-swiper-pagination"></div>
                </div>
            </div>
        </div>

        <div id="parallax2" class="ltr">
            <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
        </div>

        <div id="parallax3" class="ltr">
            <div data-depth="0.8" class="gradient-box bottom-gradient-box"></div>
        </div>
    </div>
</section>
<!-- Project Video Modal -->
<div id="projectModal" class="modal-overlay"
     style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.8); display: none; z-index: 999999;">
    
    <div style="position: relative; width: 90%; max-width: 960px; background: black; padding: 10px; z-index: 999999; margin: auto;">
        <video id="projectVideo" controls style="width: 100%; min-height: 300px; background: black;">
            <!-- Source will be added dynamically -->
        </video>

        <!-- Close Button -->
        <button onclick="closeProjectModal()" style="position: absolute; top: -15px; right: -15px;
            background: white; color: black; border: none; border-radius: 50%;
            width: 35px; height: 35px; font-size: 20px; font-weight: bold; cursor: pointer; z-index: 1000000;">
            ×
        </button>
    </div>
</div>


<style>
    /* Play Button Hover Effects */
    .play-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .testimonials-user-avatar:hover .play-overlay {
        opacity: 1;
    }
    .play-icon {
        transition: transform 0.3s ease, background 0.3s ease;
    }
    .testimonials-user-avatar:hover .play-icon {
        transform: scale(1.1);
        background: rgba(0, 130, 214, 1) !important;
    }
    
    /* Modal Animation */
    .modal-overlay {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
        display: flex !important;
    }
</style>
<script>
    function openProjectModal(videoSrc) {
        const modal = document.getElementById('projectModal');
        const video = document.getElementById('projectVideo');

        // Set video source
        video.innerHTML = `<source src="${videoSrc}" type="video/mp4">`;
        video.load(); // load new source

        // Show modal
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
        document.body.style.overflow = 'hidden';

        // Play video
        setTimeout(() => {
            video.currentTime = 0;
            video.play().catch(e => {
                console.log("Autoplay prevented:", e);
                // Show controls if autoplay is prevented
                video.controls = true;
            });
        }, 300);
    }

    function closeProjectModal() {
        const modal = document.getElementById('projectModal');
        const video = document.getElementById('projectVideo');

        // Pause and reset video
        video.pause();
        video.currentTime = 0;
        video.innerHTML = '';

        modal.classList.remove('active');
        document.body.style.overflow = '';

        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Close on outside click
    document.getElementById('projectModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeProjectModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeProjectModal();
        }
    });
</script>      
                    
                      
      <section class="container">
  <div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto">
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="bg-white rounded-lg p-4 hover:shadow-lg transition-shadow duration-300 flex flex-col items-center">
            <h3 class="text-sm font-medium text-gray-900 text-center"><?php echo e($item['title']); ?></h3>
            <img src="<?php echo e($item['icon']); ?>" alt="<?php echo e($item['text']); ?>" loading="lazy" width="124" height="124">
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</section>
                                  
                      
                      
                      
                                              
                      
      <section id="vision" class="py-12 mt-24!">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10! lg:gap-32! items-start relative">
            <!-- Text content - takes 5/8 on large screens -->
            <div class="flex-1! flex flex-col lg:items-end items-center px-12! justify-start">
                <img 
                    src="store/1/visionimg.jpg" 
                    alt="About Us" 
                    class="w-[125px] h-[125px] rounded-lg shadow-lg object-cover  mb-12!"
                    loading="lazy"
                >
                <h1 class="mb-6! text-3xl font-bold text-primary text-center"><?php echo e(trans('home.vision_title')); ?></h1>
                <p class="mb-6! text-lg text-gray-800! leading-relaxed! text-center"><?php echo e(trans('home.vision_desc')); ?></p>
               
            </div>
          <div class='absolute h-full lg:w-[2px] w-0 bg-primary inset-0 mx-auto '></div>
            <!-- Image - takes 3/8 on large screens -->
            <div class="flex-1! flex flex-col lg:items-start items-center px-12!  justify-start">
              <img 
                    src="store/1/missionimg.jpg" 
                    alt="About Us" 
                    class="w-[125px] h-[125px] rounded-lg shadow-lg object-cover mb-12!"
                    loading="lazy"
                >
                <h1 class="mb-6! text-3xl font-bold text-primary text-center"><?php echo e(trans('home.mission_title')); ?></h1>
                <p class="mb-6! text-lg text-gray-800! leading-relaxed! text-center"><?php echo e(trans('home.mission_desc')); ?></p>
            </div>
        </div>
    </div>
</section>
                      
    
                      
                      
                      
                      
                      
                      
   <!-- <section class="py-16! " id="aq">
  <div class="home-sections container mx-auto px-4!">
    <h1 class="section-title mb-12! text-center"><?php echo e(trans('home.benefits_title')); ?></h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <div class="bg-white p-6! rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4! uppercase"><?php echo e(trans('home.benefits_kids_title')); ?></h2>
        <div class="flex justify-center mb-8!">
          <img src="store/1/Picture5aq.png" alt="Kids Benefits" class="w-32 h-32">
        </div>
        <ul class="list-disc! list-inside! space-y-2! text-gray-800! mt-4!">
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_kids_1_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_kids_2_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_kids_3_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_kids_4_title')); ?></li>
        </ul>
      </div>

      <div class="bg-white p-6! rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4! uppercase"><?php echo e(trans('home.benefits_parents_title')); ?></h2>
        <div class="flex justify-center mb-8!">
          <img src="store/1/Picture2aq.png" alt="Parents Benefits" class="w-32 h-32">
        </div>
        <ul class="list-disc! list-inside! space-y-2! text-gray-800! mt-4!">
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_parents_1_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_parents_2_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_parents_3_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em; padding-left: 0.5em;"><?php echo e(trans('home.benefits_parents_4_title')); ?></li>
        </ul>
      </div>

      <div class="bg-white p-6! rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-8! uppercase"><?php echo e(trans('home.benefits_teachers_title')); ?></h2>
        <div class="flex justify-center mb-6!">
          <img src="store/1/Picture3aq.png" alt="Teachers Benefits" class="w-32 h-32">
        </div>
        <ul class="list-disc! list-inside! space-y-2 text-gray-800! mt-4!">
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em !important; padding-left: 0.5em !important; margin-right: 1em !important; padding-right: 0.5em !important;"><?php echo e(trans('home.benefits_teachers_1_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em !important; padding-left: 0.5em !important; margin-right: 1em !important; padding-right: 0.5em !important;"><?php echo e(trans('home.benefits_teachers_2_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em !important; padding-left: 0.5em !important; margin-right: 1em !important; padding-right: 0.5em !important;"><?php echo e(trans('home.benefits_teachers_3_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em !important; padding-left: 0.5em !important; margin-right: 1em !important; padding-right: 0.5em !important;"><?php echo e(trans('home.benefits_teachers_4_title')); ?></li>
          <li class="text-lg font-medium" style="list-style-type: disc; margin-left: 1em !important; padding-left: 0.5em !important; margin-right: 1em !important; padding-right: 0.5em !important;"><?php echo e(trans('home.benefits_teachers_5_title')); ?></li>
        </ul>
      </div>

    </div>
  </div>
</section>-->
                     <style>
.restore-bullets li {
  list-style-type: disc !important;
  display: list-item !important;
}
</style>
 
 <section class=" lg:block! hidden!">
    <div class="container mx-auto! px-4!">
        <h2 class="xl:text-[40px]! lg:text-[34px]! text-[28px]! font-bold! text-center! mb-12! text-[#203574]!"><?php echo e(trans('home.benefits_title')); ?></h2>
        
        <div class="grid! grid-cols-1! md:grid-cols-2! lg:grid-cols-3! gap-12!">
           <!-- Card 2 with list -->
<div class="rounded-lg!  p-6!">
    <ul class="restore-bullets list-inside! space-y-3! text-gray-700!">
        <li><?php echo e(trans('home.list1.item1')); ?></li>
        <li><?php echo e(trans('home.list1.item2')); ?></li>
        <li><?php echo e(trans('home.list1.item3')); ?></li>
        <li><?php echo e(trans('home.list1.item4')); ?></li>
    </ul>
</div>


            <!-- Card 1 with image -->
          <div class="px-12!">
            <div class="bg-white! rounded-[40px]! border-[1px]! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! py-6! px-12! flex! flex-col! items-center! text-center!">
                <img src="/store/1/image0.jpg" alt="<?php echo e(trans('home.card1.title')); ?>" class="w-32! h-32! rounded-full! object-cover! mb-4!" loading="lazy">
                <h3 class="text-fuchsia-800! px-10!
text-2xl!
font-medium!
font-['Mitr']!"><?php echo e(trans('home.card1.title')); ?></h3>
            </div>
          </div>

            
           
            
            <!-- Card 3 with image -->
           
             <div class="relative! overflow-hidden!">
    <img src="/store/1/newheader.png" 
         alt="<?php echo e(trans('home.card2.title')); ?>" 
         class="absolute! left-48! top-[-160px]! rotate-270!" 
         style="width: 241px; height: 594.873px;">
</div>

              
                      <!-- Card 1 with image -->
            <div>
              
            </div>
            
            <!-- Card 2 with list -->
            <div class="rounded-lg!  p-6!">
    <ul class="restore-bullets list-inside! space-y-3! text-gray-700!">
        <li><?php echo e(trans('home.list2.item1')); ?></li>
        <li><?php echo e(trans('home.list2.item2')); ?></li>
        <li><?php echo e(trans('home.list2.item3')); ?></li>
        <li><?php echo e(trans('home.list2.item4')); ?></li>
    </ul>
</div>
            
            <!-- Card 3 with image -->
          <div class="px-12!">
            <div class="bg-white! rounded-[40px]! border-[1px]! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! py-6! px-12! flex! flex-col! items-center! text-center!">
                <img loading="lazy" src="/store/1/image1.svg" alt="<?php echo e(trans('home.card1.title')); ?>" class="w-32! h-32! rounded-full! object-cover! mb-4!">
                <h3 class="text-fuchsia-800! px-10!
text-2xl!
font-medium!
font-['Mitr']!"><?php echo e(trans('home.card2.title')); ?></h3>
            </div>
          </div>
                      <!-- Card 1 with image -->
           <div class="px-12!">
            <div class="bg-white! rounded-[40px]! border-[1px]! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! py-6! px-12! flex! flex-col! items-center! text-center!">
                <img loading="lazy" src="/store/1/image2.svg" alt="<?php echo e(trans('home.card1.title')); ?>" class="w-32! h-32! rounded-full! object-cover! mb-4!">
                <h3 class="text-fuchsia-800! px-10!
text-2xl!
font-medium!
font-['Mitr']!"><?php echo e(trans('home.card3.title')); ?></h3>
            </div>
          </div>
            
            <!-- Card 2 with list -->
            <div class="rounded-lg!  p-6!">
    <ul class="restore-bullets list-inside! space-y-3! text-gray-700!">
        <li><?php echo e(trans('home.list3.item1')); ?></li>
        <li><?php echo e(trans('home.list3.item2')); ?></li>
        <li><?php echo e(trans('home.list3.item3')); ?></li>
        <li><?php echo e(trans('home.list3.item4')); ?></li>
        <li><?php echo e(trans('home.list3.item5')); ?></li>
    </ul>
</div>
            
            <!-- Card 3 with image -->
            <div>
               
            </div>
        </div>
    </div>
</section>
   
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
               <section class="lg:hidden!">
    <div class="container! mx-auto! px-4!">
        <h2 class="xl:text-[40px]! lg:text-[34px]! text-[24px]! font-bold! text-center! mb-12! text-[#203574]!"><?php echo e(trans('home.benefits_title')); ?></h2>
        
        <!-- Mobile layout (stacked cards with combined image+list) -->
        <div class="lg:hidden! space-y-8!">
            <!-- Card 1 (Image + List) -->
            <div class="bg-white! rounded-[40px]! border! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! md:p-6!">
                <div class="flex! flex-col! md:flex-row! items-center! gap-6! py-6!">
                    <div class="flex-shrink-0!">
                        <img loading="lazy" src="/store/1/image0.jpg" alt="<?php echo e(trans('home.card1.title')); ?>" 
                             class="w-32! h-32! rounded-full! object-cover!">
                    </div>
                    <div class="flex-grow!">
                        <h3 class="text-fuchsia-800! text-2xl! font-medium! font-['Mitr']! text-center! md:text-left! mb-4!">
                            <?php echo e(trans('home.card1.title')); ?>

                        </h3>
                        <ul class="space-y-3! text-gray-700! pl-5! list-disc!">
                            <li><?php echo e(trans('home.list1.item1')); ?></li>
                            <li><?php echo e(trans('home.list1.item2')); ?></li>
                            <li><?php echo e(trans('home.list1.item3')); ?></li>
                            <li><?php echo e(trans('home.list1.item4')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 (Image + List) -->
            <div class="bg-white! rounded-[40px]! border! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! md:p-6!">
                <div class="flex! flex-col! md:flex-row! items-center! gap-6! py-6!">
                    <div class="flex-shrink-0!">
                        <img loading="lazy" src="/store/1/image1.svg" alt="<?php echo e(trans('home.card2.title')); ?>" 
                             class="w-32! h-32! rounded-full! object-cover!">
                    </div>
                    <div class="flex-grow!">
                        <h3 class="text-fuchsia-800! text-2xl! font-medium! font-['Mitr']! text-center! md:text-left! mb-4!">
                            <?php echo e(trans('home.card2.title')); ?>

                        </h3>
                        <ul class="space-y-3! text-gray-700! pl-5! list-disc!">
                            <li><?php echo e(trans('home.list2.item1')); ?></li>
                            <li><?php echo e(trans('home.list2.item2')); ?></li>
                            <li><?php echo e(trans('home.list2.item3')); ?></li>
                            <li><?php echo e(trans('home.list2.item4')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 (Image + List) -->
            <div class="bg-white! rounded-[40px]! border! border-[#ECECEC]! shadow-[0_4px_4.7px_4px_rgba(231,244,240,1)]! md:p-6!">
                <div class="flex! flex-col! md:flex-row! items-center! gap-6! py-6!">
                    <div class="flex-shrink-0!">
                        <img loading="lazy" src="/store/1/image2.svg" alt="<?php echo e(trans('home.card3.title')); ?>" 
                             class="w-32! h-32! rounded-full! object-cover!">
                    </div>
                    <div class="flex-grow!">
                        <h3 class="text-fuchsia-800! text-2xl! font-medium! font-['Mitr']! text-center! md:text-left! mb-4!">
                            <?php echo e(trans('home.card3.title')); ?>

                        </h3>
                        <ul class="space-y-3! text-gray-700! pl-5! list-disc!">
                            <li><?php echo e(trans('home.list3.item1')); ?></li>
                            <li><?php echo e(trans('home.list3.item2')); ?></li>
                            <li><?php echo e(trans('home.list3.item3')); ?></li>
                            <li><?php echo e(trans('home.list3.item4')); ?></li>
                            <li><?php echo e(trans('home.list3.item5')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Rotated Image (Mobile position) -->
            <div class="relative! overflow-hidden! mt-8! flex! justify-center!">
                <img loading="lazy" src="/store/1/newheader.png" 
                     alt="<?php echo e(trans('home.card2.title')); ?>" 
                     class=""
                     style="width: 193px; height: 476px;">
            </div>
        </div>
        
        <!-- Desktop layout (original 3-column grid) -->
       
    </div>
</section>

                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
       <section class="py-16!" id="prize">
  <div class="home-sections container">
    <h2 class="section-title mb-12! text-center xl:text-[40px]! lg:text-[34px]! text-[28px]!"><?php echo e(trans('home.prizes')); ?></h2>
    
    <div class="grid lg:grid-cols-5 md:grid-cols-3 grid-cols-2 lg:gap-10 gap-4 items-start">
      <!-- First Column -->
        <img loading="lazy" src="store/1/Picture10.png" alt="Award 1" class="w-full h-54 rounded-lg  object-contain">
        <img loading="lazy" src="store/1/Picture11.png" alt="Award 2" class="w-full h-54 rounded-lg  object-contain">
        <img  loading="lazy"  src="store/1/Picture12.png" alt="Award 3" class="w-full h-54 rounded-lg  object-contain">
      
      <!-- Middle Column with space at top -->
        <!-- Empty space at top (same height as one image + gap) -->
       <!-- <div class="h-54 w-full lg:block hidden"></div>--> <!-- h-54 + gap-8 = h-62 -->
        <img loading="lazy"  src="store/1/Picture13.png" alt="Award 4" class="w-full h-54 rounded-lg  object-contain">
        <img loading="lazy"  src="store/1/Picture14.png" alt="Award 5" class="w-full h-54 rounded-lg  object-contain">
      
      <!-- Third Column 
        <img src="store/1/Picture15.png" alt="Award 6" class="w-full h-54 rounded-lg  object-contain">
        <img src="store/1/Picture16.png" alt="Award 7" class="w-full h-54 rounded-lg  object-contain">
        <img src="store/1/Picture17.png" alt="Award 8" class="w-full h-54 rounded-lg  object-contain"> -->
    </div>
  </div>
</section>  
                      
                      
                      

    <!--    <section>
            <div class="text-center container">
                <h1>
                    العائد على الطفل

                </h1>
                <div class="row justify-content-between">
    <div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-smile-beam fa-5x" style="color:#ff9800; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            مناهج تركز على المتعة و المشاركة
        </p>
    </div>
</div>

    <div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-user-graduate fa-5x" style="color:#007bff; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            بناء الثقة و التنمية العقلية
        </p>
    </div>
</div>

<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-paint-brush fa-5x" style="color:#28a745; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            تعزيز الإبداع و التعبير عن الذات
        </p>
    </div>
</div>

<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-lock fa-5x" style="color:#dc3545; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            تقديم نصائح للتوعية عن الأمن السيبراني
        </p>
    </div>
</div>

</div>

            </div>
        </section>



        <section class="text-center"
            style="background-image: url(https://cdn.prod.website-files.com/655a78032f46f2e55da300d7/6574c046d35e9c8898f7a242_backdrop-cert.svg);background-position: center;background-repeat: no-repeat;background-size: cover; padding-top:10rem;">
            <div class="test-width-responsive" style="margin-right:auto;margin-left:auto;">
                <img src="store/1/certificate2.jpg" style="width:100%;" />
            </div>

        </section>




        <section>
            <div class="text-center container">
                <h1 class="text-center " style="font-size:42px;font-weight:600;margin-bottom:40px;">
                    العائد على الآباء



                </h1>
                <div class="row justify-content-between">
<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-shield-alt fa-5x" style="color:#007bff; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            تعزيز الوعي بأمن المعلومات لدى أطفالهم
        </p>
    </div>
</div>

<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-rocket fa-5x" style="color:#28a745; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            استعداد الأبناء للفرص المستقبلية
        </p>
    </div>
</div>

<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-briefcase fa-5x" style="color:#ff9800; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            بناء ملف أعمال احترافي لأطفالهم
        </p>
    </div>
</div>

<div class="col-lg-6 col-12 d-flex align-items-center" style="margin-top:60px;">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; width: 100%;">
        <i class="fas fa-tags fa-5x" style="color:#dc3545; margin-inline-end:20px;"></i>
        <p class="text-center" style="font-size:28px;font-weight:500; color: var(--primary); margin: 0;">
            أسعار تنافسية
        </p>
    </div>
</div>

</div>

            </div>
        </section>
 


        <section>


            <div class="container py-5 text-center">
                <h1 class="text-center " style="font-size:42px;font-weight:600;margin-bottom:40px;">العائد على المدارس
                </h1>
                <div class="row text-center align-items-center">
<div class="col-md-4">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-bottom: 15px;">
        <i class="fas fa-chart-line fa-5x" style="color:#007bff;"></i>
      <p style="font-size:22px;font-weight:500; text-align: center;">النجاح على المدى الطويل و المستدام</p>
  
  </div>

    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-bottom: 15px;">
        <i class="fas fa-user-graduate fa-5x" style="color:#28a745;"></i>
  <p style="font-size:22px;font-weight:500; text-align: center;">جذب المزيد من الطلاب</p>  
  </div>
    
</div>

<div class="col-md-4 text-center">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-bottom: 15px;">
        <i class="fas fa-lightbulb fa-5x" style="color:#ff9800;"></i>
  
    <p style="font-size:22px;font-weight:500;">التوافق مع الفرص المستقبلية و الابتكار و مهارات القرن الواحد و العشرين</p>  
  </div>
</div>

<div class="col-md-4 text-center">
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-bottom: 15px;">
        <i class="fas fa-school fa-5x" style="color:#007bff;"></i>
      <p style="font-size:22px;font-weight:500;">تعزيز ريادة المدرسة داخل المجتمع التعليمي</p>

    </div>
    
    <div style="border: 2px solid var(--primary);background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-bottom: 15px;">
        <i class="fas fa-users fa-5x" style="color:#28a745;"></i>
      <p style="font-size:22px;font-weight:500;">رضا الآباء و تحسين سمعة المدرسة</p>
    </div>
    
</div>


                </div>
            </div>
        </section>
                      <section>
                                <div class="text-secondary company"
                style="
                
              ">
            <div class="d-flex justify-content-between">
                <div>
                    <h1 style="font-size: 36px; text-align: center">
                        <span style="color: #ba00db">+</span>2000
                    </h1>
                    <p style="font-size: 16px; text-align: center">طالب</p>
                </div>
                <div>
                    <h1 style="font-size: 36px; text-align: center">
                        <span style="color: #ba00db">5</span> شراكات
                    </h1>
                    <p style="font-size: 16px; text-align: center">مع مدارس وجامعات</p>
                </div>
                <div>
                    <h1 style="font-size: 36px; text-align: center">
                        <span style="color: #ba00db">+17 الف</span> زائر
                    </h1>
                    <p style="font-size: 16px; text-align: center">
                        للويب سايت <br />
                        10K متابعين لصفحات التواصل الاجتماعي
                    </p>
                </div>
                <div>
                    <h1 style="font-size: 36px; text-align: center">
                        <span style="color: #ba00db">90%</span> تقيمات
                    </h1>
                    <p style="font-size: 16px; text-align: center">
                        ايجابية من الأباء و الطلبة
                    </p>
                </div>
            </div>

            <div
                style="
      width: 100%;
      height: 1px;
      position: relative;
      margin: 70px 0;
      background: gray;
    ">
                <p
                    style="
        position: absolute;
        left: 50%;
        top: -12px;
        transform: translateX(-50%);
        padding: 5px 15px;
        background: white;
        z-index: 10;
        font-weight: bold;
        opasity: 0.7;
        color: #b1d1e6;
        text-align: center;
      ">
                    As Seen In
                </p>
            </div>
            <div>
                <div class="custom-carousel-body">
                    <div class="mask-companies">
                        <div class="swiper-container-company carousel-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="store/1/future-pioneers-removebg-preview.png"
                                        alt=""style="height:160px;" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="store/1/future-pioneers2-removebg-preview.png" alt=""
                                        style="height:160px;" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="store/1/Nile_University_Logo-removebg-preview.png" alt=""
                                        style="height:160px;" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="store/1/KSC-4-edited.png" alt="" style="height:160px;" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="store/1/NTI Logo.png" alt="" style="height:160px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
                      </section> -->
        <style>
          .company{width: 75%;
                margin: auto;
                padding: 40px;
                position: relative;
                background: white;
                border-radius: 20px;
            overflow:hidden;} 
          .company .carousel-container {
                position: relative;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            .company .swiper-wrapper {
                transition-timing-function: linear !important;
            }

           .company .swiper-slide {
                text-align: center;
                font-size: 18px;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: 0.3s all;
            }

            .company .mask {
                width: 100%;
                height: 100%;
                mask: linear-gradient(to right,
                        rgba(0, 0, 0, 0) 0%,
                        rgba(0, 0, 0, 1) 20%,
                        rgba(0, 0, 0, 1) 80%,
                        rgba(0, 0, 0, 0) 100%);
            }
           @media screen and (max-width: 1200px) {
             .company{
             width:95%;
             }
             
            }

            @media screen and (max-width: 900px) {
              .company{
              display:none;
              }
            }
        </style>
        </div>




        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" style="background:#80808078;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">مشاريع طلابنا</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body text-center">
                        <img  loading="lazy" id="modalImage" src="" alt="Testimonial Image" class="img-fluid"
                            style="max-height: 80vh;">
                    </div>
                </div>
            </div>
        </div>
                      

        <style>
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.8) !important;
                /* Darker overlay */
            }

            .modal-content {
                background: #ffffff;
                /* Ensure modal itself remains white */
                border-radius: 10px;
                /* Optional: rounded corners */
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                /* Slight shadow */
            }

            .modal.fade .modal-dialog {
                transition: transform 0.3s ease-out, opacity 0.3s ease-out;
            }
          @media screen and (min-width: 1200px) {
               .modal{
          top:200px;
            }}
            @media screen and (max-width: 750px) {
               .modal{
          top:400px;
          }
             
            }
          
        </style>


        <style>
            .test-width-responsive {
                width: 50%;
            }

            @media screen and (max-width: 1200px) {
                .test-width-responsive {
                    width: 80%;
                }
             
            }

            @media screen and (max-width: 900px) {
                .test-width-responsive {
                    width: 90%;
                }
            }
          body.modal-open {
    background-color: rgba(0, 0, 0, 0.7) !important;
    transition: background-color 0.3s ease-in-out;
}

        </style>
    </section>
      
<!-- Single Dynamic Modal (instead of multiple) -->
<div id="videoModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-container" style="width: 90%; max-width: 1200px; position: relative;">
        <button onclick="closeVideoModal()" class="close-btn" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: white; font-size: 24px; cursor: pointer;">
            ✕
        </button>
        <video id="modalVideo" controls style="width: 100%; max-height: 90vh; outline: none;">
            Your browser does not support the video tag.
        </video>
    </div>
</div>
     
<!-- Modal HTML (place before closing </section> tag) -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true" style="background: rgba(0,0,0,0.9);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="btn-close btn-close-white position-absolute" 
                style="top: 20px; right: 20px; z-index: 10;" 
                data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <video id="modalVideo" controls style="width:100%; max-height:80vh;"></video>
            </div>
        </div>
    </div>
</div>
<script>
  // Fix for testimonials swiper: use the correct selector and unique pagination
  document.addEventListener('DOMContentLoaded', function () {
    // Testimonials Swiper (videos with .testimonials-section)
    var testimonialsSwiper = new Swiper('.testimonials-section .swiper-container', {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: false,
      centeredSlides: true,
      initialSlide: 1,
      autoplay: false,
      pagination: {
        el: '.testimonials-section .swiper-pagination',
        clickable: true,
      },
      navigation: false,
      breakpoints: {
        1024: { slidesPerView: 3 },
        768: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
      }
    });

    // Projects Swiper (student projects)
    var projectsSwiper = new Swiper('.testimonials-swiper-projects-fix ', {
      slidesPerView: 1,
      spaceBetween: 26,
      loop: false,
      centeredSlides: true,
      initialSlide: 2,
      autoplay: false,
     
      navigation: false,
      breakpoints: {
        1024: { slidesPerView: 4 },
        768: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
      }
    });
  });
</script>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
      <!-- JavaScript (place before closing </script> tag) -->
<script>
    function openVideoModal(videoSrc) {
        const modal = new bootstrap.Modal(document.getElementById('videoModal'));
        const video = document.getElementById('modalVideo');
        
        // Clear previous source and set new one
        video.innerHTML = '';
        const source = document.createElement('source');
        source.src = videoSrc;
        source.type = 'video/mp4';
        video.appendChild(source);
        
        // Show modal
        modal.show();
        
        // Play video when modal is shown
        video.addEventListener('loadedmetadata', function() {
            video.play().catch(e => console.log("Autoplay prevented:", e));
        }, {once: true});
    }

    // Pause video when modal closes
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('modalVideo').pause();
    });
</script>
     <script>
    var swiper = new Swiper('.testimonials-swiper', {
      slidesPerView: 5,
      spaceBetween: 20,
      loop: false,
      centeredSlides: true,
      initialSlide: 1, // Start from the second slide (index 1)
      autoplay: false, // Disable autoplay
      pagination: {
        el: '.testimonials-swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        1024: {
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 2,
        },
        0: {
          slidesPerView: 1,
        }
      }
    });
  </script>

  <script>
    var swiperProjects = new Swiper('.testimonials-swiper-projects-fix', {
      slidesPerView: 6,
      spaceBetween: 26,
      loop: false,
      centeredSlides: true,
      initialSlide: 1, // Start from the second slide (index 1)
      autoplay: false, // Disable autoplay
      pagination: {
        el: '.testimonials-swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        1024: {
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 2,
        },
        0: {
          slidesPerView: 1,
        }
      }
    });
  </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById("imageModal"));
            const modalImage = document.getElementById("modalImage");

            document.querySelectorAll(".testimonial-media").forEach(img => {
                img.addEventListener("click", function() {
                    const imageUrl = this.src;
                    modalImage.src = imageUrl;
                    modal.show();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("video").forEach(video => {
                video.addEventListener("click", function() {
                    if (this.paused) {
                        this.play();
                    } else {
                        this.pause();
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
      
        var swiper = new Swiper(".swiper-container-company", {
            slidesPerView: 4,
            loop: true,
            centeredSlides: true,
            spaceBetween: 30,

            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            speed: 2000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            }
        });
    </script>
        <script>
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll('.nav-link');
    const dynamicTitles = document.querySelectorAll('.dynamic-title');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            let tabId = this.getAttribute('id').replace('tab-', ''); // Extract tab index
            let tabTitleElement = this.querySelector('.tab-title');

            if (tabTitleElement) {
                let tabTitle = tabTitleElement.innerText.trim(); // Get tab title

                // Update all elements with the class "dynamic-title"
                dynamicTitles.forEach(titleElement => {
                    // Remove the old prepended title if it exists
                    let existingTitle = titleElement.querySelector('span');
                    if (existingTitle) {
                        existingTitle.remove();
                    }

                    // Add the new title
                    titleElement.innerHTML = `<span>${tabTitle}</span> ` + titleElement.innerHTML;
                });
            }
        });
    });
});
</script>


                  
        <script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateNumberLineColor(color) {
            document.querySelectorAll('.number').forEach(num => {
                num.style.backgroundColor = color;
            });
            document.querySelectorAll('.dashed-line').forEach(line => {
                line.style.borderTopColor = color;
            });
        }

        // Set initial color from the first active tab
        let activeTab = document.querySelector('.nav-link.active');
        if (activeTab) {
            updateNumberLineColor(activeTab.getAttribute('data-color'));
        }

        // Update color on tab change
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', function () {
                updateNumberLineColor(this.getAttribute('data-color'));
            });
        });
    });
          
</script>
<!--<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".nav-link");
    const cards = document.querySelectorAll(".subscribe-plan");
    const buttons = document.querySelectorAll(".purchase-btn");
    const planFeatures = document.querySelectorAll(".plan-feature li");

    // Default colors
    const defaultMainColor = "#C833E2";
    const defaultSupColor = "#FFFFFF";

    let selectedTab = tabs[0]; // Default to the first tab
    selectedTab.classList.add("active");
    const selectedColor = selectedTab.getAttribute("data-color") || defaultMainColor;

    updateCardColors(selectedColor);

    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            tabs.forEach(t => t.classList.remove("active"));
            this.classList.add("active");

            const newColor = this.getAttribute("data-color") || defaultMainColor;
            updateCardColors(newColor);
        });
    });

    function updateCardColors(mainColor) {
        cards.forEach(card => {
            card.style.borderColor = mainColor;
            card.querySelectorAll("h4").forEach(h4 => (h4.style.color = mainColor));
            card.querySelectorAll(".font-36, .font-48").forEach(price => (price.style.color = mainColor));
            card.querySelectorAll(".badge-popular").forEach(badge => (badge.style.background = mainColor));
        });

        // Ensure all buttons match the selected color
        buttons.forEach(button => {
            button.style.background = mainColor;
            button.style.borderColor = mainColor;
            button.style.color = defaultSupColor; // Ensuring contrast
        });

        // Ensure plan-feature items have the correct mainColor background and supColor text
        planFeatures.forEach(feature => {
            feature.style.background = mainColor; // Background stays mainColor
            feature.style.color = defaultSupColor; // Text stays supColor (white)
        });
    }
});
</script> -->

      <script>
document.addEventListener("DOMContentLoaded", function () {
    let globalCategoryId = null; // Global variable to track selected category ID

    const tabs = document.querySelectorAll(".nav-link");
    const tabPanes = document.querySelectorAll(".tab-pane");

    // Function to handle tab selection
    function selectCategory(tab) {
        if (!tab) return;

        globalCategoryId = tab.getAttribute("data-category-id"); 
        const selectedColor = tab.getAttribute("data-color");
        const selectedTextColor = tab.getAttribute("data-text-color");

        // Remove active classes from all tab panes
        tabPanes.forEach(pane => {
            pane.classList.remove("show", "active");
        });

        // Show only the tab-pane that matches the selected category ID
        const activePane = document.querySelector(`.tab-pane[data-category-id="${globalCategoryId}"]`);
        if (activePane) {
            activePane.classList.add("show", "active");

            // Apply grid layout for multiple courses
            const courseContainer = activePane.querySelector(".course-grid-container");
            if (courseContainer) {
                courseContainer.style.display = "grid";
                courseContainer.style.gridTemplateColumns = "repeat(auto-fit, minmax(280px, 1fr))";
                courseContainer.style.gap = "20px";
                courseContainer.style.padding = "10px";
            }

            // Update styles for all course cards in this category
            activePane.querySelectorAll(".update-card").forEach((card) => {
                card.style.background = selectedColor || "#fff";
                card.style.color = selectedTextColor || "#000";
            });

            // Update badge colors
            activePane.querySelectorAll(".card-badge").forEach((badge) => {
                badge.style.color = selectedColor || "#000";
                badge.style.backgroundColor = selectedTextColor || "#fff";
            });

            // Update text colors
            activePane.querySelectorAll(".card-text").forEach((text) => {
                text.style.color = selectedTextColor || "#000";
            });
        }

        console.log("Current Selected Category ID:", globalCategoryId);
    }

    // Set the default tab on page load (first tab)
    const firstTab = tabs[0]; // Select the first tab
    if (firstTab) {
        firstTab.classList.add("active"); // Ensure the first tab is visually active
        selectCategory(firstTab);
    }

    // Handle tab click events
    tabs.forEach((tab) => {
        tab.addEventListener("shown.bs.tab", function (event) {
            selectCategory(event.target);
        });
    });
});


      </script>

      
      <script>
      const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('scene'), alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

// Lighting
const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(0, 1, 1).normalize();
scene.add(light);

// Load model
const loader = new THREE.GLTFLoader();
let model;
let clock = new THREE.Clock();

loader.load('Explorer_Kid_0409113720_texture.glb', gltf => {
    model = gltf.scene;
    model.scale.set(1, 1, 1);
    model.position.y = -1;
    scene.add(model);
}, undefined, error => {
    console.error(error);
});

// Wave effect
let time = 0;
function animate() {
    requestAnimationFrame(animate);
    time += 0.01;

    if (model) {
        model.traverse(child => {
            if (child.isMesh) {
                const geometry = child.geometry;
                if (geometry && geometry

      
      </script>
      
       <script src="https://cdn.jsdelivr.net/npm/three@0.157.0/build/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.157.0/examples/js/loaders/GLTFLoader.js"></script>
      
      
      
          <script>
    document.addEventListener("DOMContentLoaded", function () {
        const numberSteps = document.querySelectorAll(".number");
        const dashedLines = document.querySelectorAll(".dashed-line");

        window.updateNumberLine = function (catId, color) {
            if (catId === null && color === null) {
                // Hide number steps and lines
                numberSteps.forEach(step => step.style.display = 'none');
                dashedLines.forEach(line => line.style.display = 'none');
                return;
            }

            if (!color) {
                console.warn("No color provided for category ID:", catId);
                return;
            }

            // Show number steps and lines (in case they were hidden)
            numberSteps.forEach((step) => {
                step.style.display = '';
                step.classList.remove("text-gray-600");
                step.classList.add("text-white");
                step.style.backgroundColor = color;
            });

            dashedLines.forEach((line) => {
                line.style.display = '';
                line.style.backgroundColor = color;
            });
        };

        // Set default color on page load
        const defaultColor = "#2f80ed";
        numberSteps.forEach((step) => {
            step.classList.remove("text-gray-600");
            step.classList.add("text-white");
            step.style.backgroundColor = defaultColor;
        });

        dashedLines.forEach((line) => {
            line.style.backgroundColor = defaultColor;
        });
    });
</script>
      
      
      
      
      
      
      
      

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate() . '.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/pages/home.blade.php ENDPATH**/ ?>