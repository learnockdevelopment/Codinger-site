@extends("admin.layouts.app")
@php
    \Illuminate\Support\Facades\Log::info('LangContent data:', ['langContent' => $requestData]);
@endphp

@push('styles_top')
<style>
    .scrollable-card-body {
        max-height: 300px;
        min-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .search-box {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 15px;
        font-size: 14px;
        border: 2px solid #ccc;
        border-radius: 25px;
        transition: all 0.3s ease-in-out;
        outline: none;
    }

    .search-box:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .search-box::placeholder {
        color: #aaa;
        font-style: italic;
    }

    .search-container {
        position: relative;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #aaa;
    }

    .search-box:focus + .search-icon {
        color: #007bff;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ trans('update.manual_translate') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('update.manual_translate') }}</div>
        </div>
    </div>

    <div class="section-body">
        <form id="manualTranslateForm" action="{{ getAdminPanelUrl('/translator/translate/manual/translate') }}" method="POST">
            {{ csrf_field() }}

            {{-- Hidden Inputs for Request Data --}}
            <input type="hidden" name="language" value="{{ $requestData['language'] }}">
            <input type="hidden" name="specific_file" value="{{ $requestData['specific_file'] }}">
            <input type="hidden" name="lang_files[]" value="{{ implode(',', (array) $requestData['lang_files']) }}">

            <div class="row">
                @foreach($langContent as $key => $value)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $key }}</h4>
                            </div>
                            <div class="card-body scrollable-card-body">
                                <div class="search-container">
                                    <input type="text" class="search-box" id="search-{{ $key }}" placeholder="Search for key...">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.translation') }}</label>
                                    @if(is_array($value))
                                        @foreach($value as $subKey => $subValue)
                                            <div class="form-group translation-item" data-key="{{ $subKey }}">
                                                <label>{{ $subKey }}</label>
                                                <input type="text" class="form-control" name="translations[{{ $key }}][{{ $subKey }}]" value="{{ $subValue }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <input type="text" class="form-control" name="translations[{{ $key }}]" value="{{ $value }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">{{ trans('update.save_changes') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('manualTranslateForm').addEventListener('submit', function(e) {
        e.preventDefault();  // Prevent default form submission

        var form = this;

        // Show loading indicator with Swal
        Swal.fire({
            title: 'Submitting...',
            text: 'Please wait while we update the translations.',
            didOpen: () => {
                Swal.showLoading(); // Show the loading spinner
            },
            allowOutsideClick: false,
            showConfirmButton: false,
        });

        // Send the form data using AJAX
        var formData = new FormData(form);

        console.log("Form data being sent:", formData);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response Data:", data);

            Swal.close(); // Close the loading spinner
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Translations Updated!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload(); // Reload the page after success
                  window.location.reload(); // Reload the page after success
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'There was an issue updating the translations.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);

            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Something went wrong.',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
@endpush
