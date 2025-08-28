@extends('admin.layouts.app')

@push('styles_top')
<!-- Add any additional CSS if required -->
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item">{{ trans('admin/main.qrcodes') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="{{ getAdminPanelUrl() }}/financial/qrcodes/{{ !empty($qrcode) ? $qrcode->id.'/update' : 'store' }}" method="Post">
                            {{ csrf_field() }}

                            <!-- Batch Name -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.batch_name') }}</label>
                                <input type="text" name="batch_name" class="form-control @error('batch_name') is-invalid @enderror"
                                       value="{{ old('batch_name', !empty($qrcode) ? $qrcode->batch_name : '') }}" placeholder="Enter batch name" />
                                @error('batch_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
<!-- Code Case Options -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.code_case') }}</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="code_case[]" value="uppercase" id="uppercase"
                                           {{ is_array(old('code_case', !empty($qrcode->code_case) ? json_decode($qrcode->code_case) : [])) && in_array('uppercase', old('code_case', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="uppercase">{{ trans('admin/main.uppercase') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="code_case[]" value="lowercase" id="lowercase"
                                           {{ is_array(old('code_case', !empty($qrcode->code_case) ? json_decode($qrcode->code_case) : [])) && in_array('lowercase', old('code_case', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lowercase">{{ trans('admin/main.lowercase') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="code_case[]" value="numeric" id="numeric"
                                           {{ is_array(old('code_case', !empty($qrcode->code_case) ? json_decode($qrcode->code_case) : [])) && in_array('numeric', old('code_case', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="numeric">{{ trans('admin/main.numeric') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="code_case[]" value="special" id="special"
                                           {{ is_array(old('code_case', !empty($qrcode->code_case) ? json_decode($qrcode->code_case) : [])) && in_array('special', old('code_case', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="special">{{ trans('admin/main.special_characters') }}</label>
                                </div>
                            </div>
                            <!-- Code Length -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.code_length') }}</label>
                                <input type="number" name="code_length" class="form-control @error('code_length') is-invalid @enderror"
                                       value="{{ old('code_length', 8) }}" min="1" max="50" />
                                @error('code_length')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Number of QR Codes to Generate -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.number_of_qrcodes') }}</label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}" min="1" max="1000" />
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Expiration Date -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.expiration_date') }}</label>
                                <input type="date" name="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror"
                                       value="{{ old('expiration_date', !empty($qrcode) ? $qrcode->expiration_date : '') }}" id="expiration_date" />
                                <small id="type-hint" class="form-text text-muted">
                                {{ trans('update.expiration_hint') }}
                            </small>  
                              @error('expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Expiration Period -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.expiration_period') }} (days)</label>
                                <input type="number" name="expiration_period" class="form-control @error('expiration_period') is-invalid @enderror"
                                       value="{{ old('expiration_period', !empty($qrcode) ? $qrcode->expiration_period : '') }}" id="expiration_period" readonly />
                              
                              @error('expiration_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type Selection -->
                            <div class="form-group">
                                <label>{{ trans('admin/main.type') }}</label>
                                <select name="type" id="type-select" class="form-control @error('type') is-invalid @enderror">
                                    <option value="categories" {{ old('type', $qrcode->type ?? '') === 'categories' ? 'selected' : '' }}>
                                        {{ trans('update.categories') }}
                                    </option>
                                    <option value="bundles" {{ old('type', $qrcode->type ?? '') === 'bundles' ? 'selected' : '' }}>
                                        {{ trans('update.bundles') }}
                                    </option>
                                  <option value="webinars" {{ old('type', $qrcode->type ?? '') === 'webinars' ? 'selected' : '' }}>
    {{ trans('admin/main.webinar') }}
</option>

                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
<!-- Webinars -->
<div id="webinar-field" class="form-group d-none">
    <label>{{ trans('admin/main.webinar') }}</label>
    <select name="webinar_id" class="form-control search-webinar-select2"
            data-placeholder="{{ trans('update.search_webinars') }}">
        <!-- Options will be populated dynamically -->
    </select>
  <!-- Validation Hint for Course/Category/Bundle -->
                            
    @error('webinar_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                            <!-- Categories -->
<div id="category-field" class="form-group d-none">
    <label>{{ trans('admin/main.category') }}</label>
    <select name="category_id" class="form-control search-category-select2"
            data-placeholder="{{ trans('update.search_categories') }}">
        <!-- Options will be populated dynamically -->
    </select>
    @error('category_id')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<!-- Bundles -->
<div id="bundle-field" class="form-group d-none">
    <label>{{ trans('update.bundle') }}</label>
    <select name="bundle_id" class="form-control search-bundle-select2"
            data-placeholder="{{ trans('update.search_and_select_bundle') }}">
        <!-- Options will be populated dynamically -->
    </select>
    @error('bundle_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script>
$(document).ready(function () {
    const typeSelect = $('#type-select');
    const categoryField = $('#category-field');
    const bundleField = $('#bundle-field');
    const webinarField = $('#webinar-field'); // New webinar field

    // Handle batch name input to replace spaces with underscores
    $('input[name="batch_name"]').on('input', function () {
        const updatedValue = $(this).val().replace(/\s+/g, '_');
        $(this).val(updatedValue);
    });

    // Show/hide fields based on the selected type
    typeSelect.on('change', function () {
        const selectedType = $(this).val();
        if (selectedType === 'categories') {
            categoryField.removeClass('d-none');
            bundleField.addClass('d-none');
            webinarField.addClass('d-none');
        } else if (selectedType === 'bundles') {
            bundleField.removeClass('d-none');
            categoryField.addClass('d-none');
            webinarField.addClass('d-none');
        } else if (selectedType === 'webinars') {  
            webinarField.removeClass('d-none');
            categoryField.addClass('d-none');
            bundleField.addClass('d-none');
        }
    });

    // Initialize select2 for categories, bundles, and webinars
    $('.search-category-select2').select2({
        placeholder: "{{ trans('admin/main.search_categories') }}",
        allowClear: true
    });

    $('.search-bundle-select2').select2({
        placeholder: "{{ trans('update.search_and_select_bundle') }}",
        allowClear: true
    });

    $('.search-webinar-select2').select2({
        placeholder: "{{ trans('admin/main.search_webinars') }}",
        allowClear: true
    });

    // Trigger change event on page load to set the correct state
    typeSelect.trigger('change');

    // Calculate expiration period based on expiration date
    $('#expiration_date').on('change', function () {
        const expirationDate = new Date($(this).val());
        const creationDate = new Date('{{ now() }}');
        const expirationPeriod = Math.max(Math.floor((expirationDate - creationDate) / (1000 * 60 * 60 * 24)), 0);
        $('#expiration_period').val(expirationPeriod);
    });
});

</script>
@endpush
