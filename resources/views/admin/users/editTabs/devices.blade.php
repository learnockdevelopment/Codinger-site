<div class="tab-pane mt-3 fade" id="devices" role="tabpanel" aria-labelledby="devices-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{ getAdminPanelUrl() }}/users/{{ $user->id .'/updateDevice' }}" method="Post">
                {{ csrf_field() }}
<div class="form-group">
    <label>{{ trans('/admin/main.mac_address') }}</label>
    <input type="text" name="mac_address"
           class="form-control @error('mac_address') is-invalid @enderror"
           value="{{ !empty($user) ? $user->mac_address : old('mac_address') }}"
           placeholder="{{ trans('admin/main.create_field_mac_address_placeholder') }}"/>
    @error('mac_address')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
              <div class="form-group">
    <label>{{ trans('/admin/main.device_id') }}</label>
    <input type="text" name="device_id"
           class="form-control @error('device_id') is-invalid @enderror"
           value="{{ !empty($user) ? $user->device_id : old('device_id') }}"
           placeholder="{{ trans('admin/main.create_field_device_id_placeholder') }}"/>
    @error('device_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

                <div class=" mt-4">
                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
