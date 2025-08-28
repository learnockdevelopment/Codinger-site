<div id="topFilters" class="rounded-sm p-10 p-md-20">
    <div class="row align-items-center justify-content-between">
        

        <div class="col-lg-6 d-block d-md-flex align-items-center justify-content-end my-25 my-lg-0">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center mx-0 mx-md-20 my-20 my-md-0">
                <label style="color: var(--primary); font-weight: bold;" class="mb-0 mr-10 cursor-pointer" for="upcoming">{{ trans('panel.upcoming') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="upcoming" class="custom-control-input" id="upcoming" @if(request()->get('upcoming', null) == 'on') checked="checked" @endif>
                    <label class="custom-control-label" for="upcoming"></label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                <label style="color: var(--primary); font-weight: bold;" class="mb-0 mr-10 cursor-pointer" for="free">{{ trans('public.free') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="free" class="custom-control-input" id="free" @if(request()->get('free', null) == 'on') checked="checked" @endif>
                    <label class="custom-control-label" for="free"></label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between justify-content-md-center mx-0 mx-md-20 my-20 my-md-0">
                <label style="color: var(--primary); font-weight: bold;" class="mb-0 mr-10 cursor-pointer" for="discount">{{ trans('public.discount') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="discount" class="custom-control-input" id="discount" @if(request()->get('discount', null) == 'on') checked="checked" @endif>
                    <label class="custom-control-label" for="discount"></label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                <label style="color: var(--primary); font-weight: bold;" class="mb-0 mr-10 cursor-pointer" for="download">{{ trans('home.download') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="downloadable"  class="custom-control-input" id="download" @if(request()->get('downloadable', null) == 'on') checked="checked" @endif>
                    <label   class="custom-control-label" for="download"></label>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
    <div class="col-lg-4">
        <label for="sort" style="color: var(--primary); font-weight: bold; class="mb-0">{{ trans('public.sort_by') }}</label>
    </div>
    <div class="col-lg-8">
        <select name="sort"  class="form-control font-14">
            <option disabled selected>{{ trans('public.sort_by') }}</option>
            <option value="">{{ trans('public.all') }}</option>
            <option  value="newest" @if(request()->get('sort', null) == 'newest') selected="selected" @endif style="color: orange;">{{ trans('public.newest') }}</option>
            <option value="expensive" @if(request()->get('sort', null) == 'expensive') selected="selected" @endif>{{ trans('public.expensive') }}</option>
            <option value="inexpensive" @if(request()->get('sort', null) == 'inexpensive') selected="selected" @endif>{{ trans('public.inexpensive') }}</option>
            <option value="bestsellers" @if(request()->get('sort', null) == 'bestsellers') selected="selected" @endif>{{ trans('public.bestsellers') }}</option>
            <option value="best_rates" @if(request()->get('sort', null) == 'best_rates') selected="selected" @endif>{{ trans('public.best_rates') }}</option>
        </select>
    </div>
</div>


    </div>
</div>
