@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <style>
        .progress-container {
            width: 100%;
            background-color: blue;
            border-radius: 24px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .progress-bar {
            width: 0%;
            height: 5px;
            background-color: var(--primary);
            border-radius: 24px;
            transition: width 0.3s ease-in-out;
        }
    </style>
@endpush

@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
        $selectRolesDuringRegistration = getFeaturesSettings('select_the_role_during_registration') ?? null;
        $logo = getGeneralSettings('logo') ?? '';
    @endphp

    <div class="container">
        <div class="row login-container d-flex justify-content-center border-0" style="margin-top:60px !important">
           {{-- <div class="w-100" style="height: 35%; background-color: var(--primary);position: absolute; top: 6%;"></div>
            <div class="text-center">
                <img src="{{ $logo }}" class="img-cover col-6" alt="site logo"
                    style="z-index:10; width:40%; margin-bottom:30px">
            </div> --}}

            <div class="col-9 col-md-12 d-flex justify-content-center ">
                <div class="col-8 shadow-xl! border-1!" style="border-radius: 24px; background: white">
                    <div class="login-card d-flex flex-column" style="position: relative;z-index:10;">
                        <h1 class="font-20 font-weight-bold">{{ trans('auth.signup') }}</h1>
                        <form method="post" action="/register" class="mt-35">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="progress position-relative mt-3 text-center " style="background:#3551a430;box-shadow:none;margin-bottom:20px;height:5px;overflow:visible;">
                              <div class="position-absolute bg-white " style="left:0;top:-7px; border:  2px solid var(--secondary); width:20px; height:20px;border-radius:1000px;"><p>3</p></div>
                              <div class="position-absolute bg-white  " style="left:49%;top:-7px; border: var(--secondary) 2px solid; width:20px; height:20px;border-radius:1000px;"><p>2</p></div>  
                              <div class="position-absolute bg-white  " style="right:0;top:-7px; border: var(--secondary) 2px solid; width:20px; height:20px;border-radius:1000px;"><p>1</p></div>  
  
                              
                              <div id="progress-bar" class="progress-bar bg-primary" style="width: 33%; height:100%;"
                                    role="progressbar"></div>
                            </div>

                            <div id="step-1">
                                <div class="form-group">
                                    <label class="input-label" for="full_name">{{ trans('auth.full_name') }}:</label>
                                    <input name="full_name" type="text" value="{{ old('full_name') }}"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control @error('full_name') is-invalid @enderror">
                                    @error('full_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label" for="email">{{ trans('auth.email') }}:</label>
                                    <input name="email" type="email" value="{{ old('email') }}"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <button type="button" class="btn btn-primary w-100 mt-3" id="next-step-1">{{trans('auth.continue')}}</button>
                            </div>
<script>
    async function loadCountries() {
        const select = document.getElementById('countrySelect');

        try {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();

            // Sort countries alphabetically
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.cca2; // ISO Alpha-2 Code (e.g., US, EG)
                option.text = country.name.common;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading countries:', error);
        }
    }

    // Call it on page load
    window.addEventListener('DOMContentLoaded', loadCountries);
</script>

                            <div id="step-2" style="display: none;">
<div class="form-group" style="padding-right:0px !important;">
    <label class="input-label" for="country_code">{{ trans('auth.country') }}:</label>
    <select id="countrySelect" name="country_code" class="form-control select2" 
            style="border-color: rgba(31, 42, 85, 0.15);" required>
        <option value="">Select Country</option>
    </select>
    @error('country_code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
                                <div class="form-group"
                                    style="padding-left:0px !important; padding-right:10px !important;">
                                    <label class="input-label" for="phone">{{ trans('auth.phone') }}:</label>
                                    <input name="phone" type="text" value="{{ old('phone') }}"
                                        style="border-color: rgba(31, 42, 85, 0.15);"
                                        class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

				<div class="d-flex  justify-content-between align-items-center mb-2 mt-3">
                                <button type="button" class="btn btn-secondary " style="width:48%;" id="prev-step-1">{{trans('auth.return')}}</button>
                                <button type="button" class="btn btn-primary " style="width:48%;"  id="next-step-2">{{trans('auth.continue')}}</button>
                              </div>
                            </div>

                            <div id="step-3" style="display: none;">
                                <div class="form-group">
                                    <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                                    <input name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        style="border-color: rgba(31, 42, 85, 0.15);">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                <div class="form-group">
                                    <label class="input-label"
                                        for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                                    <input name="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        style="border-color: rgba(31, 42, 85, 0.15);">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Additional Fields and Terms -->
                                @if ($showCertificateAdditionalInRegister)
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="certificate_additional">{{ trans('update.certificate_additional') }}</label>
                                        <input name="certificate_additional" style="border-color: rgba(31, 42, 85, 0.15);"
                                            id="certificate_additional"
                                            class="form-control @error('certificate_additional') is-invalid @enderror" />
                                        @error('certificate_additional')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif

                                             <div class="form-group">
    <label for="category_id">{{trans('auth.age_group')}}:</label>
    <select name="category_id" id="category_id" class="form-control" required>
        <option value="">{{ trans('public.select') }}</option>
        @foreach($ageRanges as $ageRange)
            <option value="{{ $ageRange['id'] }}" {{ old('category_id') == $ageRange['id'] ? 'selected' : '' }}>
                {{ $ageRange['ageRange'] }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
                                <div class="custom-control custom-checkbox">
                                    <input style="border-color: rgba(31, 42, 85, 0.15);" type="checkbox" name="term"
                                        value="1" {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }}
                                        class="custom-control-input @error('term') is-invalid @enderror" id="term">
                                    <label class="custom-control-label font-14"
                                        for="term">{{ trans('auth.i_agree_with') }}
                                        <a href="pages/terms" target="_blank"
                                            class="text-secondary font-weight-bold font-14">{{ trans('auth.terms_and_rules') }}</a>
                                    </label>
                                    @error('term')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


								<div class="d-flex align-items-center justify-content-between mb-2 mt-3">
                                <button type="button" class="btn btn-secondary"
                                    id="prev-step-2" style="width:48%;">{{trans('auth.return')}}</button>
                                <button type="submit" class="btn btn-primary " style="width:48%;">{{ trans('auth.signup') }}</button>
                              </div>
                              </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script>
    $(document).ready(function() {
        const isRTL = $('html').attr('dir') === 'rtl';

        function updateProgress(step) {
            let percentage = step === 1 ? 0 : step === 2 ? 50 : 100;
            if (isRTL) {
                $("#progress-bar").css({
                    "width": percentage + "%",
                    "left": "auto",
                    "right": 0
                });
            } else {
                $("#progress-bar").css({
                    "width": percentage + "%",
                    "right": "auto",
                    "left": 0
                });
            }
        }

        updateProgress(1); // Initialize at 0% for Step 1

        $("#next-step-1").click(function() {
            $("#step-1").hide();
            $("#step-2").show();
            updateProgress(2); // Move to 50%
        });

        $("#prev-step-1").click(function() {
            $("#step-2").hide();
            $("#step-1").show();
            updateProgress(1); // Back to 0%
        });

        $("#next-step-2").click(function() {
            $("#step-2").hide();
            $("#step-3").show();
            updateProgress(3); // Move to 100%
        });

        $("#prev-step-2").click(function() {
            $("#step-3").hide();
            $("#step-2").show();
            updateProgress(2); // Back to 50%
        });

        $("form").submit(function() {
            updateProgress(3); // Ensure progress bar is full on final submit
        });
    });
</script>

    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/forms.min.js"></script>
    <script src="/assets/default/js/parts/register.min.js"></script>
@endpush
