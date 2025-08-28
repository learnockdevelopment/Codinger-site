@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }
    // Fetch general security settings
    $securitySettings = getGeneralSecuritySettings();

    // Log the security settings for debugging
    \Log::info('Security Settings:', ['securitySettings' => $securitySettings]);
    $navBtnUrl = null;
    $navBtnText = null;

    if (request()->is('forums*')) {
        $navBtnUrl = '/forums/create-topic';
        $navBtnText = trans('update.create_new_topic');
    } else {
        $navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null, empty($authUser));

        if (!empty($navbarButton)) {
            $navBtnUrl = $navbarButton->url;
            $navBtnText = $navbarButton->title;
        }
    }
@endphp

@php
    $userLanguages = !empty($generalSettings['site_language']) ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])] : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }

@endphp
@push('styles_top')
<link href="https://cdn.tailwindcss.com/3.4.1" rel="stylesheet">
<link rel="preload" href="{{ $generalSettings['logo'] }}" as="image">
<style>
    @media (min-width: 1200px) {
        .custom-padding {
            padding-right: 15px !important;
            padding-left: 15px !important;
        }

        .nav-cutome-container {
            max-width: 1650px !important;
        }
    }

 /* Increase specificity to override Bootstrap */

</style>
@endpush
<div id="navbarVacuum"></div>
<nav id="navbar" class="sticky top-0 z-50 shadow-none navbar navbar-expand-lg p-1  transition-all duration-300 p-[15px_10px] transparent-nav">    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container ' }}">
  <style>
nav#navbar.transparent-nav {
    background-color: transparent !important;
    box-shadow: none !important;
}

nav#navbar {
    background-color: white !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    transition: background-color 0.3s, box-shadow 0.3s !important;
    }
  
  .menu-category > ul > li:hover > ul {
    display: block !important;
}
.menu-category li ul {
    display: none;
}
.menu-category li:hover > ul {
    display: block;
}
[x-cloak] { display: none !important; }

  
  </style>   
  <div class="d-flex align-items-center lg:justify-between justify-between w-100 py-2!">

    
    
    
    
     @push('scripts')
<script>
    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        document.querySelectorAll('[x-data]').forEach(el => {
            if (!el.contains(e.target)) {
                el.__x.$data.open = false;
            }
        });
    });
</script>
@endpush

<li class="mr-lg-25 relative delayed-fade-in" style="opacity: 0; animation: fadeIn 500ms forwards 500ms;">
  

    <div class="menu-category">
        <ul>
<li id="my-li"
    class="cursor-pointer user-select-none d-flex text-primary relative"
    style="background: transparent; border-radius: 5px;">
  
 
<script>
// Run when the page is fully loaded
window.addEventListener('load', function() {
    var li = document.getElementById('my-li');
    li.style.display = 'none'; // Hide it immediately
    setTimeout(function() {
        li.style.display = 'block'; // Show it again after 500ms
    }, 500);
});
</script>
  
               <i class="fa-solid fa-bars d-none d-lg-block" width="30" height="30"></i>

                <!-- Dropdown Menu -->
<ul
    x-show="open"
    x-transition
    class="dropdown-hidden absolute top-[100%] mt-0 bg-white border border-gray-200 shadow-md rounded z-50 w-64 {{ in_array(app()->getLocale(), ['ar']) ? 'left-[-170px]!' : 'left-0' }}"
>


                    <!-- Static dropdown items -->
                  <!--  <li class="relative group">
                        <a href="/contact-us"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                                <i data-feather="mail" width="20" height="20" class="mr-2"></i>
                                {{trans('home.menu_contact')}}
                            </div>
                        </a>
                    </li> -->
                                                   
 <li class="d-flex pl-1! pr-6! ">

               
	
                @if(!empty($localLanguage) and count($localLanguage) > 1)
                    <form action="/locale" method="post" class="mr-15 mx-md-20">
                        {{ csrf_field() }}

                        <input type="hidden" name="locale">

                        @if(!empty($previousUrl))
                            <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
                        @endif

                        <div class="language-select">
                            <div id="localItems"
                                 data-selected-country="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) }}"
                                 data-countries='{{ json_encode($localLanguage) }}'
                            ></div>
                        </div>
                    </form>
                @else
                    <div class="mr-15 mx-md-20"></div>
                @endif
              
              
            </li>
                  <li class="relative group">
                        <a href="#aboutUs"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                                <i data-feather="info" width="20" height="20" class="mx-2"></i>
                                {{trans('home.menu_about_us')}}
                            </div>
                        </a>
                    </li>
                  <li class="relative group">
                        <a href="#vision"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                              <i class="fa-solid fa-diagram-project mx-2"  width="20" height="20" ></i>
                              {{trans('home.menu_vision')}}
                            </div>
                        </a>
                    </li>
                    
                    <li class="relative group">
                        <a href="#aq"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                                <i data-feather="help-circle" width="20" height="20" class="mx-2"></i>
                                {{trans('home.menu_faq')}}
                            </div>
                        </a>
                    </li>
                  <li class="relative group">
                        <a href="#projects"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                              <i class="fa-solid fa-diagram-project mx-2"  width="20" height="20" ></i>
                               {{trans('home.menu_projects')}} 
                            </div>
                        </a>
                    </li>
                     <li class="relative group">
                        <a href="#testmonials"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                                
                              <i class="fa-solid fa-comment mx-2"  width="20" height="20" ></i>
                               {{trans('home.menu_testimonials')}}
                            </div>
                        </a>
                    </li>
                   
                   <li class="relative group">
                        <a href="#prize"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                             
                              <i class="fa-solid fa-trophy mx-2"  width="20" height="20" ></i>
                               {{trans('home.menu_prizes')}}
                            </div>
                        </a>
                    </li>
  
              
                
                </ul>
            </li>
        </ul>
    </div>
</li>


    
    
    
    
    
    
        <a class="navbar-brand navbar-order d-flex align-items-center order-1 lg:order-none mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}"
   href="/" style="width:auto !important;">
    @if (!empty($generalSettings['logo']))
        <img src="{{ $generalSettings['logo'] }}" alt="site logo"
             width="160" height="57"
             class="object-contain mr-auto w-[130px] sm:w-[18vw] md:w-[16vw]  h-auto "
             style=" height: auto; max-width: 160px; max-height: 57px;"> <!-- Inline fallback -->
    @endif
</a>
            @if (!empty($authUser) && !empty($securitySettings['watermark_enabled']) && $securitySettings['watermark_enabled'] !== 0)
                <div id="floating-user-id" class="floating-user-id"
                    style="
                        position: absolute;
                        color: black;
                        padding: 10px;
                        border-radius: 5px;
                        font-size: 11px;
                        z-index: 99999;
                        box-shadow: 0 4px 8px rgb(0 0 0 / 0%);
                    ">
                    Email: {{ $authUser->email }} <br>
                    <span id="current-time"></span>
                </div>
            @endif

           <button class="navbar-toggler bg-white shadow-sm rounded-lg px-3 py-2 lg:mx-[-50px]!" type="button" id="navbarToggle" style="">
    <i class="fa-solid fa-bars text-gray-600 text-2xl" ></i>
</button>


            <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                <!-- Additional content here -->
            </div>

            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content" id="navbarContent">

                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose">
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                    <!-- Additional content here -->
             
                </div>

                <div class="top-contact-box border-bottom d-flex flex-column flex-md-row align-items-center justify-content-center">
                    @if (getOthersPersonalizationSettings('platform_phone_and_email_position') == 'header')
                        <div class="d-flex align-items-center justify-content-center mr-15 mr-md-30">
                            @if (!empty($generalSettings['site_phone']))
                                <div class="d-flex align-items-center py-10 py-lg-0 text-dark-blue font-14">
                                    <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                                    {{ $generalSettings['site_phone'] }}
                                </div>
                            @endif

                            @if (!empty($generalSettings['site_email']))
                                <div class="border-left mx-5 mx-lg-15 h-100"></div>

                                <div class="d-flex align-items-center py-10 py-lg-0 text-dark-blue font-14">
                                    <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                                    {{ $generalSettings['site_email'] }}
                                </div>
                            @endif
                        </div>
                    @endif
                  
                  
                  
                  
                  
                </div>
       
              

                <ul class="navbar-nav mr-auto d-flex align-items-center">
                   
 <div class="d-flex align-items-center justify-content-between justify-content-md-center  flex! lg:hidden!">

                {{-- Currency --}}

	
                @if(!empty($localLanguage) and count($localLanguage) > 1)
                    <form action="/locale" method="post" class="mr-15 mx-md-20">
                        {{ csrf_field() }}

                        <input type="hidden" name="locale">

                        @if(!empty($previousUrl))
                            <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
                        @endif

                        <div class="language-select">
                            <div id="localItems"
                                 data-selected-country="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) }}"
                                 data-countries='{{ json_encode($localLanguage) }}'
                            ></div>
                        </div>
                    </form>
                @else
                    <div class="mr-15 mx-md-20"></div>
                @endif
              
              
            </div>
              
                  
                  
                  
                  
                  @if (!empty($navbarPages) and count($navbarPages))
                                @foreach ($navbarPages as $navbarPage)
                            <li class="nav-item">
<a href="{{ $navbarPage['link'] }}" 
   class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
  {{ $navbarPage['title'] }}
</a>

</li>
                 @endforeach
                    @endif
                                <li class="nav-item ">
           <li id="my-li"
    class="cursor-pointer user-select-none d-flex text-primary relative pt-0! lg:hidden! flex"
    style="background: transparent; border-radius: 5px;">
             
<script>
// Run when the page is fully loaded
window.addEventListener('load', function() {
    var li = document.getElementById('my-li');
    li.style.display = 'none'; // Hide it immediately
    setTimeout(function() {
        li.style.display = 'flex'; // Show it again as flex after 500ms
    }, 500);
});
</script>
               <i class="fa-solid fa-bars d-none d-lg-block" width="30" height="30"></i>

                <!-- Dropdown Menu -->
                <ul
                    x-show="open"
                    x-transition
                    class=""
                >
                    <!-- Static dropdown items -->
                  <!--  <li class="relative group">
                        <a href="/contact-us"
                           class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 text-dark">
                            <div class="flex items-center">
                                <i data-feather="mail" width="20" height="20" class="mr-2"></i>
                                {{trans('home.menu_contact')}}
                            </div>
                        </a>
                    </li> -->
                  <li class="relative group">
                        <a href="#aboutUs"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                                {{trans('home.menu_about_us')}}
                            </div>
                        </a>
                    </li>
                  <li class="relative group">
                        <a href="#vision"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                              {{trans('home.menu_vision')}}
                            </div>
                        </a>
                    </li>
                    
                    <li class="relative group">
                        <a href="#aq"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                                {{trans('home.menu_faq')}}
                            </div>
                        </a>
                    </li>
                  <li class="relative group">
                        <a href="#projects"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                               {{trans('home.menu_projects')}} 
                            </div>
                        </a>
                    </li>
                     <li class="relative group">
                        <a href="#testmonials"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                                
                               {{trans('home.menu_testimonials')}}
                            </div>
                        </a>
                    </li>
                   
                   <li class="relative group">
                        <a href="#prize"
                           class="text-[#0082D6]! hover:text-green-500 !important 
          text-base sm:text-lg md:text-xl lg:text-[1.5rem]  
          mr-6 sm:mr-8 md:mr-10 lg:mr-[30px] 
          transition duration-300 ease-in-out hover:text-[#4CD66D]!" @click="open = false">
                            <div class="flex items-center">
                             
                               {{trans('home.menu_prizes')}}
                            </div>
                        </a>
                    </li>
                  
                
                </ul>
            </li>
        </li>
               
                </ul>
            </div>
@if (empty($authUser))
            <div class="d-flex align-items-center lg:ml-12 md:ml-auto! order-2 lg:order-none">
                <a href="/login" class="lg:py-5 lg:px-10 md:text-[22px]! lg:mr-6! text-dark-blue font-14"
                    style="color:#C833E2;font-weight:bold;">{{ trans('auth.login') }}</a>
            </div>
@endif
            <div class="nav-icons-or-start-live navbar-order d-flex align-items-center justify-content-end ">
                @if (!empty($navBtnUrl))
                 <!-- Desktop Version (hidden on mobile) -->
<a href="{{ $navBtnUrl }}"
   class="hidden md:inline-flex items-center justify-center hover:bg-white hover:text-[#FFDD33] btn-primary nav-start-a-live-btn text-white text-base md:text-xl py-2 px-6 border-4 border-[#FFDD33] rounded-[25px] transition-colors duration-300"
   style="background-color: #65C83C;">
   {{ $navBtnText }}
</a>

<!-- Mobile Version (hidden on desktop) -->
<!--<a href="{{ $navBtnUrl }}" 
   class="lg:hidden inline-flex items-center justify-center hover:bg-white hover:text-[#FFDD33] btn-primary nav-start-a-live-btn text-white text-base py-[2px] px-[4px] border-4 border-[#FFDD33] rounded-[25px] transition-colors duration-300 text-nowrap
"
   style="background-color: #65C83C;">
   {{ $navBtnText }}
</a> -->
                @endif

                @if (!empty($isPanel))
                    @if ($authUser->checkAccessToAIContentFeature())
                        <div class="js-show-ai-content-drawer show-ai-content-drawer-btn d-flex-center mr-40">
                            <div class="d-flex-center size-32 rounded-circle bg-white">
                                <img src="/assets/default/img/ai/ai-chip.svg" alt="ai" class=""
                                    width="16px" height="16px">
                            </div>
                            <span
                                class="ml-5 font-weight-500 text-secondary font-14 d-none d-lg-block">{{ trans('update.ai_content') }}</span>
                        </div>
                    @endif
                @endif
              <li>            @include('web.default.includes.top_nav.user_menu')
                  </li>
        
               <div class="d-flex align-items-center justify-content-between justify-content-md-center  flex!">

                {{-- Currency --}}

	
                @if(!empty($localLanguage) and count($localLanguage) > 1)
                    <form action="/locale" method="post" class="mr-15 mx-md-20">
                        {{ csrf_field() }}

                        <input type="hidden" name="locale">

                        @if(!empty($previousUrl))
                            <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
                        @endif

                        <div class="language-select">
                            <div id="localItems"
                                 data-selected-country="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) }}"
                                 data-countries='{{ json_encode($localLanguage) }}'
                            ></div>
                        </div>
                    </form>
                @else
                    <div class="mr-15 mx-md-20"></div>
                @endif
              
              
            </div>
        </div>
    </div>
</nav>

@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    console.log('Navbar script loaded'); // Debug script execution

    const navbar = document.getElementById('navbar');

    function handleScroll() {
     
        if (window.scrollY > 0) {
            navbar.classList.remove('transparent-nav');
           
        } else {
            navbar.classList.add('transparent-nav');
           
        }
    }

    handleScroll(); // Set initial state

    window.addEventListener('scroll', function () {
        console.log('Scroll event fired'); // Debug scroll event
        handleScroll();
    });
});

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('current-time').textContent = 'Time: ' + timeString;
        }

        function changePosition() {
            const floatingUserId = document.getElementById('floating-user-id');

            // Get viewport dimensions
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;

            // Random position within the viewport
            const randomX = Math.random() * (viewportWidth - floatingUserId.offsetWidth);
            const randomY = Math.random() * (viewportHeight - floatingUserId.offsetHeight);

            // Set new position
            floatingUserId.style.left = randomX + 'px';
            floatingUserId.style.top = randomY + 'px';
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000); // Update time every second

        // Change position immediately and then every 2 seconds
        changePosition();
        setInterval(changePosition, 2000); // Change position every 2 seconds
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="//unpkg.com/alpinejs" defer></script>

    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

@endpush
