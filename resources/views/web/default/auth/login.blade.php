@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
	@php
		        $logo = getGeneralSettings('logo') ?? '';
@endphp

    <div class="container">
        @if(!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container d-flex justify-content-center border-none! shadow-none! ">
            
<div class="col-12 col-md-6 border-0 shadow-xl! border-1!  " style="background: white; border-radius: 24px;">

                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">{{ trans('auth.login_h1') }}</h1>

                    <form method="Post" action="/login" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('web.default.auth.includes.register_methods')


                        <div class="form-group">
    <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
    <div style="position: relative;">
        <input 
            name="password" 
            type="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password" 
            aria-describedby="passwordHelp" 
            style="padding-right: 40px; border: 1px solid rgba(31,42,85,.15)">
        
        <button 
            type="button" 
            id="togglePassword" 
            aria-label="Show/Hide Password" 
            style="border: none; background: none; position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #495057;">
            <i data-feather="eye" width="20" height="20" id="togglePasswordIcon"></i>
        </button>
    </div>
    @error('password')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the icon
            if (type === 'password') {
                togglePasswordIcon.getAttribute('data-feather') ;
                togglePasswordIcon.classList.add('fa-eye');
            } else {
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            }
        });
    });
</script>


                        @if(!empty(getGeneralSecuritySettings('captcha_for_login')))
                            @include('web.default.includes.captcha_input')
                        @endif

                        <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.login') }}</button>
                    </form>

                    @if(session()->has('login_failed_active_session'))
                        <div class="d-flex align-items-center mt-20 p-15 danger-transparent-alert ">
                            <div class="danger-transparent-alert__icon d-flex align-items-center justify-content-center">
                                <i data-feather="alert-octagon" width="18" height="18" class=""></i>
                            </div>
                            <div class="ml-10">
                                <div class="font-14 font-weight-bold ">{{ session()->get('login_failed_active_session')['title'] }}</div>
                                <div class="font-12 ">{{ session()->get('login_failed_active_session')['msg'] }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-20">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center">{{ trans('auth.or') }}</span>
                    </div>

                    @if(!empty(getFeaturesSettings('show_google_login_button')))
                        <a href="/google" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
                            <img src="/assets/default/img/auth/google.svg" class="mr-auto" alt=" google svg"/>
                            <span class="flex-grow-1">{{ trans('auth.google_login') }}</span>
                        </a>
                    @endif

                    @if(!empty(getFeaturesSettings('show_facebook_login_button')))
                        <a href="{{url('/facebook/redirect')}}" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center ">
                            <img src="/assets/default/img/auth/facebook.svg" class="mr-auto" alt="facebook svg"/>
                            <span class="flex-grow-1">{{ trans('auth.facebook_login') }}</span>
                        </a>
                    @endif

                    <div class="mt-30 text-center">
                        <a href="/forget-password" target="_blank">{{ trans('auth.forget_your_password') }}</a>
                    </div>

                    <div class="mt-20 text-center">
                        <span>{{ trans('auth.dont_have_account') }}</span>
                        <a href="/register" class="text-secondary font-weight-bold">{{ trans('auth.signup') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/js/parts/forgot_password.min.js"></script>
@endpush
