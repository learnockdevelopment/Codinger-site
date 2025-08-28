@extends(getTemplate().'.layouts.app')

@push('styles_top')
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
  @media (max-width: 991px) {
  .search-top-banner .col-lg-6 img {
    display: none;
  }
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
@endpush


@section('content')
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
              <h1 class="font-30 mb-15 text-start">{{ !empty($category) ? $category->title : $pageTitle }}</h1>
              <span class="course-count-badge py-5 px-10 text-white rounded" style="background: var(--primary);">
                {{ $webinarsCount }} {{ trans('product.courses') }}
              </span>

              <div class="search-input p-10 mt-3" style="background:white;">
                <form action="/search" method="get">
                  <div class="form-group d-flex align-items-center m-0">
                    <input 
                      type="text" 
                      name="search" 
                      class="form-control border-0" 
                      placeholder="{{ trans('home.slider_search_placeholder') }}" />
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
              src="{{ getPageBackgroundSettings('categories') }}"
              alt="Top Banner Image" 
              class="img-fluid rounded-3"
              style="max-height: 400px; position: unset" />
          </div>

        </div>
      </div>
    </div>
  </section>
</div>


    <div class="container mt-30">

        @if(!empty($featureWebinars) and !$featureWebinars->isEmpty())
            <section class="mb-25 mb-lg-0">
                <h2 class="font-24 text-dark-blue">{{ trans('home.featured_webinars') }}</h2>
                <span class="font-14 text-gray font-weight-400">{{ trans('site.newest_courses_subtitle') }}</span>

                <div class="position-relative mt-20">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">

                            @foreach($featureWebinars as $featureWebinar)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card',['webinar' => $featureWebinar->webinar])
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

            </section>
        @endif

        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
            <form action="{{ $sortFormAction }}" method="get" id="filtersForm">

                @include('web.default.pages.includes.top_filters')

                <div class="row mt-20">
                    <div class="col-12 col-lg-8">

                        @if(empty(request()->get('card')) or request()->get('card') == 'grid')
                            <div class="row">
                                @foreach($webinars as $webinar)
                                    <div class="col-12 col-lg-6 mt-20">
                                        @include('web.default.includes.webinar.grid-card',['webinar' => $webinar])
                                    </div>
                                @endforeach
                            </div>

                        @elseif(!empty(request()->get('card')) and request()->get('card') == 'list')

                            @foreach($webinars as $webinar)
                                @include('web.default.includes.webinar.list-card',['webinar' => $webinar])
                            @endforeach
                        @endif

                    </div>


                    <div class="col-12 col-lg-4">
                        <div class="mt-20 p-20 rounded-sm shadow-lg filters-container" style="background: #cfbba06b;">

                            <div class="">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('public.type') }}</h3>

                                <div class="pt-10">
                                    @foreach(['webinar','course','text_lesson'] as $typeOption)
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="filterLanguage{{ $typeOption }}">{{ trans('webinars.'.$typeOption) }}</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="type[]" id="filterLanguage{{ $typeOption }}" value="{{ $typeOption }}" @if(in_array($typeOption, request()->get('type', []))) checked="checked" @endif class="custom-control-input">
                                                <label class="custom-control-label" for="filterLanguage{{ $typeOption }}"></label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(!empty($category) and !empty($category->filters))
                                @foreach($category->filters as $filter)
                                    <div class="mt-25 pt-25 border-top border-gray300">
                                        <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ $filter->title }}</h3>

                                        @if(!empty($filter->options))
                                            <div class="pt-10">
                                                @foreach($filter->options as $option)
                                                    <div class="d-flex align-items-center justify-content-between mt-20">
                                                        <label class="cursor-pointer" for="filterLanguage{{ $option->id }}">{{ $option->title }}</label>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="filter_option[]" id="filterLanguage{{ $option->id }}" value="{{ $option->id }}" @if(in_array($option->id, request()->get('filter_option', []))) checked="checked" @endif class="custom-control-input">
                                                            <label class="custom-control-label" for="filterLanguage{{ $option->id }}"></label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            <div class="mt-25 pt-25 border-top border-gray300">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('site.more_options') }}</h3>

                                <div class="pt-10">
                                    @foreach(['bundles','subscribe','certificate_included','with_quiz','featured'] as $moreOption)
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="filterLanguage{{ $moreOption }}">{{ trans('webinars.show_only_'.$moreOption) }}</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="moreOptions[]" id="filterLanguage{{ $moreOption }}" value="{{ $moreOption }}" @if(in_array($moreOption, request()->get('moreOptions', []))) checked="checked" @endif class="custom-control-input">
                                                <label class="custom-control-label" for="filterLanguage{{ $moreOption }}"></label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <button type="submit" class="btn btn-sm btn-primary btn-block mt-30">{{ trans('site.filter_items') }}</button>
                        </div>
                    </div>
                </div>

            </form>
            <div class="mt-50 pt-30">
                {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/categories.min.js"></script>
@endpush
