@extends(getTemplate() . '.layouts.app')

@php
    $videos  = [
        '/store/1/frog game.mp4',
        '/store/1/fruit game.mp4',
        '/store/1/maze game.mp4',
		'/store/1/jumping ant.mp4',
// '/store/1/reel1.mp4'

    ];

@endphp

@php
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
@endphp



@push('styles_top')
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
@endpush

@section('content')
   
      
      
      
      
      
                                            
      
      
<!--
<section>
    <div class="home-sections position-relative subscribes-container pe-none user-select-none tabs-home">
        <div class="your_learning_path">
            <div class="container">
              <h1 class="section-title text-center" style="font-size:40px; color:#112058;">
    {{ __('home.select_age_title') }}
</h1>
<div class="section-hint text-center text-[10px]">
    {{ __('home.select_age_hint') }}
</div>

                <div class="tabs py-10">
                    <ul class="nav nav-tabs tabs-container grid xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-2 gap-10 justify-center" 
                        id="tabsMenu2" role="tablist" style="border:0px !important;">
                      
                        @foreach ($mainCategories as $index => $category)
                            <li class="nav-item w-full col-span-1 max-w-[212px] mx-auto" role="presentation">
                                <a class="nav-link {{ $index == 0 ? 'active' : '' }} flex flex-col items-center py-2 px-0
                                   transition duration-300 transform hover:scale-105"
                                   style="background: {{ $category['color'] }}; 
                                          color: {{ $category['text_color'] }}; 
                                          border-radius: 50px;"
                                   id="tab-{{ $category['id'] }}" 
                                   data-bs-toggle="tab" 
                                   href="#tab{{ $category['id'] }}"
                                   role="tab" 
                                   aria-controls="tab{{ $category['id'] }}" 
                                   aria-selected="{{ $index == 0 ? 'true' : 'false' }}"
                                   data-color="{{ $category['color'] }}" 
                                   data-text-color="{{ $category['text_color'] }}"
                                   data-category-id="{{ $category['id'] }}">
                            
                                    <p class="tab-text tab-title text-lg sm:text-xl md:text-2xl font-semibold" 
                                       style="color: {{ $category['text_color'] }}">
                                       Grade {{ $category['grade'] }}
                                    </p>

                                    <p class="tab-text font-bold text-3xl sm:text-4xl md:text-5xl lg:text-[48px] my-1">
                                        {{ $category['age_min'] }} - {{ $category['age_max'] }}
                                    </p>

                                    <p class="tab-text px-4 py-1 text-lg sm:text-xl md:text-2xl font-medium"
                                       style="background: {{ $category['text_color'] }}; 
                                              color: {{ $category['color'] }}; 
                                              border-radius: 50px;">
                                        Years
                                    </p>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
              
              
              
              
              
              
@php
    $filteredCourses = $courses->where('category_id', 0);
@endphp

@if($filteredCourses->isNotEmpty())
     <h1 class="section-title text-center dynamic-title" style="font-size:40px; color:#112058;">
    {{ __('home.learning_path_title') }}
</h1>

              
    @foreach ($filteredCourses as $course)
        <a href="{{ url('/course/' . $course['slug']) }}" style="text-decoration: none; color: inherit;">
            <div class="card update-card text-center"
                data-index="{{ $course['id'] }}"
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
                    {{ $course['slug'] }}
                </p>
            </div>
        </a>
    @endforeach
              
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
@endif
              
              
              
              
              
              
              
      


            </div>
        </div>
    </div>
</section>
-->
      
<script>
console.log(@json($subscribe_id))
console.log(@json($mainCategories))
console.log(@json($subscribes))

</script>
<script>
  
</script>


<section>
    <div class="home-sections position-relative subscribes-container pe-none user-select-none tabs-home">
        <div class="your_learning_path">
            <div class="container">
            <!--  <h1 class="section-title text-center xl:text-[40px]! lg:text-[34px]! text-[28px]!" style=" color:#112058;">
    {{ __('home.select_age_title') }}
</h1> -->


             
               <div class=" py-10">
    <ul class="flex justify-center gap-4 md:gap-6 justify-center" 
        id="tabsMenu2" role="tablist">
      
        @foreach ($mainCategories as $index => $category)
            <li class="nav-item w-full col-span-1 mx-auto" role="presentation">
                <div class="flex flex-col items-center">
                    <p class="tab-title text-xl md:text-3xl font-semibold text-center text-black mb-2">
                        Grade {{ $category['grade'] }}
                    </p>
                    <button class="flex flex-col items-center justify-center w-full p-4 md:p-6 lg:p-8
                        transition duration-300 transform hover:scale-105 focus:outline-none
                        rounded-full  text-secondary"
                        id="tab-{{ $category['id'] }}" 
                        data-bs-toggle="tab" 
                        href="#"
                        role="tab" 
                        aria-controls="tab{{ $category['id'] }}" 
                        aria-selected="{{ $index == 0 ? 'true' : 'false' }}"
                        data-color="{{ $category['color'] }}" 
                        data-text-color="{{ $category['text_color'] }}"
                        data-category-id="{{ $category['id'] }}"
onclick="selectCategory({{ $mainCategories[0]['id'] }});">
                    <span class="font-bold text-2xl sm:text-3xl md:text-4xl lg:text-[42px] leading-tight">
    {{ trans('home.age_range', ['min' => $category['age_min'], 'max' => $category['age_max']]) }}
</span>


                       
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
              
              
           
     
              
              
              
              
              <div class="courses-container grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 lg:gap-16! gap-6! mt-8! 2xl:px-58!"></div>
      


            </div>
             
  
      </div>
      
    </div>
</section>
<script>
     (function () {
        const subscribeId = @json($subscribe_id);
        const mainCategories = @json($mainCategories);
        const subscribes = @json($subscribes);
		console.log(typeof(mainCategories))
        // Global variable to hold the matched category ID
        window.matchedCategoryId = null;

        // Find the first matching category ID
        for (let i = 0; i < subscribes.length; i++) {
            const subscribe = subscribes[i];
            const match = mainCategories.find(cat => cat.id === subscribe.category_id);

            if (match) {
                window.matchedCategoryId = subscribe.category_id;
                break; // since you only need one match
            }
        }

        console.log('Matched Category ID:', window.matchedCategoryId);
    })();
  
  
  //-------------------
  
  
  
    const accessDaysText = @json(trans('home.access_days'));
    const subscribeText = @json(trans('home.subscribe'));
    const purchaseText = @json(trans('home.purchase'));

    const courses = @json($courses); 
const categories = @json($mainCategories);

    console.log('Categories:', categories);
    console.log('Courses:', courses);
function selectCategory(catId) {
    console.log("Selected Category:", catId);
    const category = categories.find(c => c.id == catId);
    if (!category) {
        console.error('Category not found for ID:', catId);
        return;
    }

    // Visually mark the selected tab & clear previous selections
    document.querySelectorAll('.tabs-container button').forEach(btn => {
        const btnCatId = btn.getAttribute('data-category-id');
        if (btnCatId == catId) {
            btn.classList.add('scale-105'); // example active style (optional)
            btn.setAttribute('aria-selected', 'true');
        } else {
            btn.classList.remove('scale-105');
            btn.setAttribute('aria-selected', 'false');
        }
    });

    const filteredCourses = courses.filter(course => course.category_id == catId);
    console.log('filtered Courses:', filteredCourses);

    const container = document.querySelector(".courses-container");
    if (!container) return;

    updateNumberLine(catId, category.color);

    if (filteredCourses.length > 0) {
        const mainColor = category.color || '#000';
        const supColor = category.text_color || '#fff';
        const age_min = category.age_min;
        const age_max = category.age_max;

        container.innerHTML = filteredCourses.map(course => `
            <a href="/course/${course.slug}" class=" min-h-84! px-7! py-2.5! bg-white! rounded-[40px]! outline! outline-1! outline-offset-[-1px]! inline-flex! flex-col! justify-center! items-center! gap-6! overflow-hidden!" style="outline-color: #812895!; border-color: #812895!">
    <div class="self-stretch! flex! flex-col! justify-center! items-center! gap-6!">
        <div class="self-stretch! flex! flex-col! justify-start! items-center! gap-4!">
            <div class="self-stretch! flex! flex-col! justify-start! items-center! gap-4!">
                <div class="self-stretch! flex! flex-col! justify-start! items-center! gap-1!">
                    <div class="text-center! justify-start! text-zinc-900! text-2xl! font-medium! font-['Mitr']! capitalize!">${course.title}</div>
                </div>
                <div class="w-32! bg-[#C833E2]! rounded-[20px]! flex! flex-col! justify-start! items-center! gap-1!">
                    <div class="text-center! justify-start! text-white! text-2xl! font-normal! font-['Segoe_UI']!">${age_min} - ${age_max}</div>
                </div>
            </div>
            <div class="w-48! inline-flex! justify-center! items-center! gap-4!">
                <div class="flex-1! inline-flex! flex-col! justify-center! items-center! gap-4!">
                    <div class="self-stretch! flex! flex-col! justify-start! items-start! gap-1!">
                        ${course.subscribe ? `<div class="self-stretch! justify-start! text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">{{trans('home.subscribe')}} : ${course.subscribe}</div>` : ''}
                       ${course.duration ? `<div class="self-stretch! justify-start! text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">{{ trans('home.duration') }} : ${course.duration} ${course.duration === 1 ? 'hour' : 'hours'}</div>` : ''}
                        ${course.access_days ? `<div class="self-stretch! justify-start! text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">{{trans('home.access_days')}} : ${course.access_days}</div>` : ''}
                        <!-- ${course.description ? `<div class="self-stretch! justify-start! text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">${course.description}</div>` : ''}  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="self-stretch! flex! flex-col! justify-start! items-center! gap-6!">
            <div class="justify-start! text-[#812895]! text-xs! font-normal! font-['Segoe_UI']!">Updated</div>
            <div class="self-stretch! h-11! px-20! py-2.5! bg-[#812895]! rounded-[40px]! inline-flex! justify-center! items-center! gap-2.5! overflow-hidden!">
                <div class="justify-start! text-white! text-base! font-bold! font-['Segoe_UI']!">{{trans('home.purchase')}}</div>
            </div>
        </div>
    </div>
</a>
        `).join('');
    } else {
        updateNumberLine(null, null);
      const mainColor = category.color || '#000';
        container.innerHTML = `<p class="col-span-3 text-3xl! w-full font-bold! text-center! text-[#000000]! ">No courses in this category.</p>`;
    }
}


    window.addEventListener("load", function () {
    // Check if a category is already selected (you can use any condition that checks the state)
    const selectedCategoryId = document.querySelector('.tabs-container button[aria-selected="true"]');
    
    if (!selectedCategoryId && categories.length > 0) {
        // If no category is selected, select the first one
        selectCategory(categories[0].id);
    }
});

</script> 
<!-- {{--  the card from before 

<a href="/course/${course.slug}" class="course-card border-4 col-span-1 rounded-[50px] px-6! py-8! text-center flex flex-col h-full hover:scale-105! transition-all! duration-300!" style="border-color: ${mainColor};">
                <div class="flex-grow">
                    <h3 class="text-3xl! font-semibold my-8! capitalize!" style="color: ${mainColor}">${course.title}</h3>
                    <p class="text-[${supColor}] bg-[${mainColor}] w-1/3 px-3! rounded-full mx-auto! my-6! text-xl!">${age_min} - ${age_max}</p>
                    <div class="my-6 p-2 text-3xl! font-medium!" style="color: ${mainColor}">${course.price > 0 ? `$${course.price}` : 'FREE'}</div>
                    <p class="mt-6! text-2xl! font-semibold!">${course.description || ''}</p>
                    ${course.access_days ? `<p class="mt-6! text-lg!">{{trans('home.access_days')}} : ${course.access_days}</p>` : ''}
                </div>
                <p class="mt-6! text-xl!">{{trans('home.subscribe')}} : <span class="text-[${mainColor}]">${course.subscribe}</span></p>
                <p class="mt-6! text-xl!">{{ trans('home.duration') }} : <span class="text-[${mainColor}]">${course.duration} ${course.duration === 1 ? 'hour' : 'hours'}</span></p>
                <a href="/course/${course.slug}" class="mt-8! text-2xl! font-medium text-[${supColor}]! bg-[${mainColor}]! px-6! py-4! rounded-3xl! w-3/4! mx-auto! uppercase! hover:bg-white hover:scale-110 transition-all duration-300 border-4 border-[${mainColor}]">{{trans('home.purchase')}}</a>
            </a>--}} --> 
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
                        {{ trans('home.learning_memberships') }}
                    </h1>
                </div>

                <div class="position-relative mt-30">
                    <div class="">
                        <div class=" py-20" style="display: flex; align-items: stretch !important;justify-content:center;">
                          <script>console.log(@json($subscribes))</script>
@foreach ($subscribes as $index => $subscribe)
                          
    @php
        $color = $colors[$index % count($colors)]; // Cycle through colors
        $mainColor = $color['main'];
        $supColor = $color['sup'];
        $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
    @endphp

    <div class="">
        <div class="min-h-96! px-7! py-3! bg-white! relative rounded-[40px]! flex! flex-col! justify-start! items-center! gap-8! overflow-hidden! border-1! border-[#64C83A]! shadow-lg!">
           
          
          <div class="absolute left-0 top-0 h-16 w-16">
    <div
      class="absolute transform rotate-[-45deg]! @if($subscribe->is_popular) bg-secondary @else bg-primary @endif text-center text-white font-semibold py-1 right-[-65px] top-[32px] w-[170px]">
      20% off
    </div>
  </div>
          
          <!-- Banner Section -->
            <div class=" text-center! py-4! rounded-full! mb-4!" style="background: {{ $mainColor }};">
               <div class="self-stretch! w-44 h-36!  rounded-[70px]! flex! flex-col! justify-center! items-center! gap-2.5!"
                     style="background: {{ $mainColor }};">
                   <div class="justify-start! text-white! lg:text-4xl! text-3xl! font-bold! font-['Segoe_UI']!">
    {{ Str::of($subscribe->title)->before(' ') }}
</div>

               
            </div>
 </div>
                <div class="text-black! text-4xl! font-bold! font-['Segoe_UI']! mt-2!">
                    @if (!empty($subscribe->price) and $subscribe->price > 0)
                        @if (!empty($subscribeSpecialOffer))
                            {{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}
                        @else
                            {{ handlePrice($subscribe->price, true, true, false, null, true) }}
                        @endif
                    @else
                        {{ trans('public.free') }}
                    @endif
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
                            {{ $subscribe->days }} {{ trans('financial.days_of_subscription') }}
                        </span>
                       {{-- @if ($subscribe->is_popular)
                            <span class="ml-auto! text-fuchsia-600! text-sm! font-semibold! font-['Segoe_UI']!">
                                {{ trans('panel.popular') }}
                            </span>
                        @elseif(!empty($subscribeSpecialOffer))
                            <span class="ml-auto! text-fuchsia-600! text-sm! font-semibold! font-['Segoe_UI']!">
                                {{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}
                            </span>
                        @endif --}}
                    </div>
                    
                    <!-- Description -->
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                           {{trans('home.tecguid')}}Technical Guidance
                        </span>
                    </div>
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                          {{trans('home.group')}} Limited Group
                        </span>
                    </div>
                    
                    <!-- Usable Count -->
                    <div class="w-full! flex! items-center! py-2! border-b! border-gray-200!">
                        <svg class="w-5! h-5! mr-3! text-green-500!" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-neutral-700! text-sm! font-semibold! font-['Segoe_UI']!">
                            @if ($subscribe->infinite_use)
                                {{ trans('update.unlimited') }}
                            @else
                                {{ $subscribe->usable_count }}
                            @endif
                            <span>{{ trans('update.subscribes') }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Purchase Button -->
            @if (auth()->check())
                <form action="/panel/financial/pay-subscribes" method="post" class="w-full! text-center! mt-4!">
                    {{ csrf_field() }}
                    <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                    <input name="id" value="{{ $subscribe->id }}" type="hidden">

                    <button type="submit" class="w-48! h-11! px-20! py-2.5! rounded-[40px]! inline-flex! justify-center! items-center! gap-2.5! overflow-hidden! text-white! text-base! font-bold! font-['Segoe_UI']!" style="background: #812895;">
                        {{ trans('update.purchase') }}
                    </button>

                    @if (!empty($subscribe->has_installment))
                        <div class="mt-4!">
                            <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments" 
                               class="w-48! h-11! px-20! py-2.5! rounded-[40px]! inline-flex! justify-center! items-center! gap-2.5! overflow-hidden! text-white! text-base! font-bold! font-['Segoe_UI']!" style="background: #812895;">
                                {{ trans('update.installments') }}
                            </a>
                        </div>
                    @endif
                </form>
            @else
                <div class="w-full! text-center! mt-4!">
                    <a href="/login" class="w-48! h-11! px-20! py-2.5! rounded-[40px]! inline-flex! justify-center! items-center! gap-2.5! overflow-hidden! text-white! text-base! font-bold! font-['Segoe_UI']!" style="background: #812895;">
                        {{ trans('update.purchase') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endforeach
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
                {{-- <!--
 
 @foreach ($subscribes as $index => $subscribe)
                                @php
                                    $color = $colors[$index % count($colors)]; // Cycle through colors
                                    $mainColor = $color['main'];
                                    $supColor = $color['sup'];
                                    $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                                @endphp

                                <div class="swiper-slide">
                                    <div class="subscribe-plan position-relative d-flex flex-column align-items-center pt-50 pb-30 px-20 min-h-[817px]"
                                        style="background: transparent; border-radius: 50px; border: 5px solid {{ $mainColor }};">
                                        
                                        @if ($subscribe->is_popular)
                                            <span class="badge badge-popular px-15 py-5" style="color: {{ $supColor }}; background: {{ $mainColor }};">
                                                {{ trans('panel.popular') }}
                                            </span>
                                        @elseif(!empty($subscribeSpecialOffer))
                                            <span class="badge badge-danger badge-popular px-15 py-5">
                                                {{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}
                                            </span>
                                        @endif

                                        <h4 class="text-[{{ $mainColor }}] text-[1rem]">6 - 7 Years Old / Grades 1-2</h4>
                                        <h3 class="mt-20 text-[32px] font-semibold text-center" style="color: #112058;">
                                            {{ $subscribe->title }}
                                        </h3>

                                        @if (!empty($subscribe->price) and $subscribe->price > 0)
                                            @if (!empty($subscribeSpecialOffer))
                                                <div class="d-flex align-items-end line-height-1">
                                                    <span class="font-36" style="color: {{ $supColor }};">
                                                        {{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}
                                                    </span>
                                                    <span class="font-14 text-gray ml-5 text-decoration-line-through">
                                                        {{ handlePrice($subscribe->price, true, true, false, null, true) }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="font-48 line-height-1" style="color: {{ $supColor }};">
                                                    {{ handlePrice($subscribe->price, true, true, false, null, true) }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="font-36 line-height-1" style="color: {{ $mainColor }};">
                                                {{ trans('public.free') }}
                                            </span>
                                        @endif

                                        <ul class="mt-[16px] plan-feature flex flex-wrap gap-1 justify-center">
                                            <li class="text-[1rem] mt-2 inline-flex items-center justify-center px-4 py-2 bg-[{{ $mainColor }}] text-[{{ $supColor }}] font-semibold text-center rounded-full min-w-3/5 mx-auto">
                                                350 EGP Per Class
                                            </li>
                                            <li class="mt-2 inline-flex items-center px-4 py-2 bg-[{{ $mainColor }}] text-[{{ $supColor }}] text-sm font-semibold rounded-full">
                                                {{ $subscribe->days }} {{ trans('financial.days_of_subscription') }}
                                            </li>
                                            <li class="mt-2 inline-flex items-center px-4 py-2 bg-[{{ $mainColor }}] text-[{{ $supColor }}] text-sm font-semibold rounded-full">
                                                @if ($subscribe->infinite_use)
                                                    {{ trans('update.unlimited') }}
                                                @else
                                                    {{ $subscribe->usable_count }}
                                                @endif
                                                <span class="ml-2">{{ trans('update.subscribes') }}</span>
                                            </li>
                                        </ul>

                                        <div class="mt-1 text-center capitalize text-[16px] font-medium">
                                            Curriculum Includes
                                        </div>

                                    <div class="min-h-[100px] mt-3">
                                            <p class="text-[1rem] text-[#112058] font-medium mt-[6px]">
                                                LEVEL 1 Technology Around Us
                                            </p>
                                            <p class="text-[1rem] text-[#112058] font-medium mt-[6px]">
                                                LEVEL 1 Technology Around Us
                                            </p>
                                        </div>

                                  <div class="text-center rounded mx-auto mt-3 min-h-[100px]" style="width:170px; padding:10px;">
    <p class="text-center font-weight-500 text-black mt-10 text-[12px]">
        {!! $subscribe->description !!}
    </p>
</div>
                                        @if (auth()->check())
                                            <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                                {{ csrf_field() }}
                                                <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                                                <input name="id" value="{{ $subscribe->id }}" type="hidden">

                                                <div class="d-flex align-items-center justify-center w-100">
                                                    <button type="submit"
                                                        class="btn purchase-btn hover:bg-white! hover:text-[#112058]!"
                                                        style="border-radius: 25px; font-size:24px; border: 2px solid {{ $mainColor }}; background: {{ $mainColor }}; color: {{ $supColor }}; min-width: 180px; min-height: 70px;">
                                                        {{ trans('update.purchase') }}
                                                    </button>

                                                    @if (!empty($subscribe->has_installment))
                                                        <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments"
                                                            class="btn purchase-btn hover:bg-white! hover:text-[#112058]!"
                                                           style="border-radius: 25px; font-size:24px; border: 2px solid {{ $mainColor }}; background: {{ $mainColor }}; color: {{ $supColor }}; min-width: 180px; min-height: 70px;">
                                                           >
                                                            {{ trans('update.installments') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </form>
                                        @else
                                            <a href="/login"
                                     class="btn purchase-btn hover:bg-white! hover:text-[#112058]!"
                                                        style="border-radius: 25px; font-size:24px; border: 2px solid {{ $mainColor }}; background: {{ $mainColor }}; color: {{ $supColor }}; min-width: 180px; min-height: 70px;">
                                                {{ trans('update.purchase') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach


--> --}}      
                      


                      
   
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
 
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
@endpush
