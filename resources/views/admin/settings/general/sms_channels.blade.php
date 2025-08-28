@php
    use Illuminate\Support\Facades\Log;
    
    if (!empty($itemValue) && !is_array($itemValue)) {
        $itemValue = json_decode($itemValue, true);
    }
@endphp

<div class="tab-pane mt-3 fade" id="sms_channels" role="tabpanel" aria-labelledby="sms_channels-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{ getAdminPanelUrl() }}/settings/sms_channels" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="page" value="general">
                <input type="hidden" name="sms_channels" value="sms_channels">

                <div class="mb-5">
                    <h5>{{ trans('update.sms_channel') }}</h5>

                    <div class="form-group">
                        <label class="input-label">{{ trans('update.sms_sending_channel') }}</label>
                        <select name="value[sms_sending_channel]" class="form-control">
                            <option value="">{{ trans('update.select_a_sms_channel') }}</option>
                            @foreach(\App\Mixins\Notifications\SendSMS::allChannels as $smsChannel)
                                @php Log::info("sms_sending_channel: $smsChannel"); @endphp
                                <option value="{{ $smsChannel }}" {{ (!empty($itemValue) && !empty($itemValue["sms_sending_channel"]) && $itemValue["sms_sending_channel"] == $smsChannel) ? 'selected' : '' }}>
                                    {{ trans("update.sms_channel_{$smsChannel}") }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Twilio Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.twilio_api_settings') }}</h5>
                    @foreach(['twilio_sid', 'twilio_auth_token', 'twilio_number'] as $twilioConf)
                        @php Log::info("twilio_$twilioConf: ".($itemValue[$twilioConf] ?? 'N/A')); @endphp
                        <div class="form-group">
                            <label>{{ trans("update.{$twilioConf}") }}</label>
                            <input type="text" name="value[{{ $twilioConf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$twilioConf}"])) ? $itemValue["{$twilioConf}"] : old("{$twilioConf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <!-- Msegat Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.msegat_settings') }}</h5>
                    @foreach(['msegat_username', 'msegat_user_sender', 'msegat_api_key'] as $msegatConf)
                        @php Log::info("msegat_$msegatConf: ".($itemValue[$msegatConf] ?? 'N/A')); @endphp
                        <div class="form-group">
                            <label>{{ trans("update.{$msegatConf}") }}</label>
                            <input type="text" name="value[{{ $msegatConf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$msegatConf}"])) ? $itemValue["{$msegatConf}"] : old("{$msegatConf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <!-- Vonage Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.vonage_settings') }}</h5>
                    @foreach(['vonage_number', 'vonage_key', 'vonage_secret', 'vonage_application_id', 'vonage_private_key'] as $vonageConf)
                        @php Log::info("vonage_vonageConf: ".($itemValue[$vonageConf] ?? 'N/A')); @endphp
                        <div class="form-group">
                            <label>{{ trans("update.{$vonageConf}") }}</label>
                            <input type="text" name="value[{{ $vonageConf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$vonageConf}"])) ? $itemValue["{$vonageConf}"] : old("{$vonageConf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <!-- MSG91 Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.msg91_settings') }}</h5>
                    @foreach(['msg91_key', 'msg91_flow_id'] as $msg91Conf)
                        @php Log::info("msg91_$msg91Conf: ".($itemValue[$msg91Conf] ?? 'N/A')); @endphp
                        <div class="form-group">
                            <label>{{ trans("update.{$msg91Conf}") }}</label>
                            <input type="text" name="value[{{ $msg91Conf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$msg91Conf}"])) ? $itemValue["{$msg91Conf}"] : old("{$msg91Conf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <!-- 2Factor Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.2factor_settings') }}</h5>
                    @foreach(['2factor_api_key'] as $factorConf)
                        <div class="form-group">
                            <label>{{ trans("update.{$factorConf}") }}</label>
                            <input type="text" name="value[{{ $factorConf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$factorConf}"])) ? $itemValue["{$factorConf}"] : old("{$factorConf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <!-- SMS Misr Settings -->
                <div class="mb-5">
                    <h5>{{ trans('update.smsmisr_settings') }}</h5>
                    @foreach(['smsmisr_username', 'smsmisr_password', 'smsmisr_sender'] as $smsMisrConf)
                        @php Log::info("smsmisr_smsMisrConf: ".($itemValue[$smsMisrConf] ?? 'N/A')); @endphp
                        <div class="form-group">
                            <label>{{ trans("update.{$smsMisrConf}") }}</label>
                            <input type="text" name="value[{{ $smsMisrConf }}]" value="{{ (!empty($itemValue) && !empty($itemValue["{$smsMisrConf}"])) ? $itemValue["{$smsMisrConf}"] : old("{$smsMisrConf}") }}" class="form-control"/>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
            </form>
        </div>
    </div>
</div>
