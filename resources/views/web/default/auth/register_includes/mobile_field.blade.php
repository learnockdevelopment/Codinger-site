@php
    $registerCountry = getGeneralSettings('country_code');
@endphp

<div class="row">
    <div class="col-5">
        <div class="form-group">
            <label class="input-label" for="mobile">{{ trans('auth.country') }}:</label>
            <select name="country_code" class="form-control select2" style="border: 1px solid rgba(31,42,85,.15)">
                @foreach(getCountriesMobileCode() as $country => $code)
                    <option value="{{ $code }}" @if($code == $registerCountry) selected @endif>{{ $country }}</option>
                @endforeach
            </select>

            @error('mobile')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-7">
        <div class="form-group">
            <label class="input-label" for="mobile">{{ trans('auth.mobile') }} {{ !empty($optional) ? "(". trans('public.optional') .")" : '' }}:</label>
            <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                   value="{{ old('mobile') }}" id="mobile" aria-describedby="mobileHelp" style="border: 1px solid rgba(31,42,85,.15)">

            @error('mobile')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>
