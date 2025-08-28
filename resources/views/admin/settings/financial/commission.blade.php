@php
    if (!empty($itemValue) && !is_array($itemValue)) {
        $itemValue = json_decode($itemValue, true);
    }

    // Log the itemValue before checking
    \Log::info('Item Value:', ['itemValue' => $itemValue]);

    // Ensure the commission_for key exists in the itemValue array for all sources
    foreach (\App\Models\UserCommission::$sources as $commissionSource) {
        if (!isset($itemValue[$commissionSource]['commission_for'])) {
            $itemValue[$commissionSource]['commission_for'] = 'instructor'; // default to 'instructor' if not set
        }
    }

    // Log the updated itemValue with commission_for added
    \Log::info('Updated Item Value:', ['itemValue' => $itemValue]);

    // Ensure the commission_for key exists globally
    $commissionFor = isset($itemValue['commission_for']) ? $itemValue['commission_for'] : 'instructor'; // default to 'instructor' if not set

    // Log the result of getFinancialSettings()
    $financialSettings = getFinancialSettings();
    \Log::info('Financial Settings:', ['financialSettings' => $financialSettings]);
@endphp

<div class="tab-pane mt-3 fade @if(request()->get('tab') == 'commissions') active show @endif" id="commissions" role="tabpanel" aria-labelledby="commissions-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{ getAdminPanelUrl() }}/settings/main" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="page" value="financial">
                <input type="hidden" name="name" value="{{ \App\Models\Setting::$commissionSettingsName }}">

                @foreach(\App\Models\UserCommission::$sources as $commissionSource)
              @if($commissionSource === 'bundles')
        @continue
    @endif
                    <div class="form-group">
                        <label class="mb-0">{{ trans("update.{$commissionSource}_commission") }}</label>

                        <div class="row">
                            <div class="col-6">
                                <label class="">{{ trans("admin/main.type") }}</label>
                                <select name="value[{{ $commissionSource }}][type]" class="js-commission-type-input form-control" data-currency="{{ $currency }}">
                                    <option value="percent" {{ (!empty($itemValue) && !empty($itemValue[$commissionSource]) && !empty($itemValue[$commissionSource]['type']) && $itemValue[$commissionSource]['type'] == "percent") ? 'selected' : '' }}>{{ trans('update.percent') }}</option>
                                    <option value="fixed_amount" {{ (!empty($itemValue) && !empty($itemValue[$commissionSource]) && !empty($itemValue[$commissionSource]['type']) && $itemValue[$commissionSource]['type'] == "fixed_amount") ? 'selected' : '' }}>{{ trans('update.fixed_amount') }}</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <div class="">
                                    <label class="">{{ trans("update.value") }}
                                        <span class="ml-1 js-commission-value-span">@if(!empty($itemValue) && !empty($itemValue[$commissionSource]) && !empty($itemValue[$commissionSource]['type'])) ({{ ($itemValue[$commissionSource]['type'] == "percent") ? '%' : $currency }}) @else (%)  @endif</span>
                                    </label>

                                    <input type="number" name="value[{{ $commissionSource }}][value]" value="{{ (!empty($itemValue) && !empty($itemValue[$commissionSource]) && !empty($itemValue[$commissionSource]['value'])) ? $itemValue[$commissionSource]['value'] : '' }}" class="js-commission-value-input form-control text-center" />
                                </div>
                            </div>
                        </div>

                        <div class="text-muted text-small mt-1">{{ trans("update.{$commissionSource}_commission_hint") }}</div>

                        <!-- Add Commission For Field to Each Source -->
                        <div class="form-group">
                            <label for="commissionForSelect_{{ $commissionSource }}">{{ trans('panel.commission_for_instructor_or_system') }}</label>
                            <select name="value[{{ $commissionSource }}][commission_for]" id="commissionForSelect_{{ $commissionSource }}" class="form-control">
                                <option value="instructor" {{ isset($itemValue[$commissionSource]['commission_for']) && $itemValue[$commissionSource]['commission_for'] == 'instructor' ? 'selected' : '' }}>
                                    Instructor
                                </option>
                                <option value="system" {{ isset($itemValue[$commissionSource]['commission_for']) && $itemValue[$commissionSource]['commission_for'] == 'system' ? 'selected' : '' }}>
                                    System
                                </option>
                            </select>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success">{{ trans('admin/main.save_change') }}</button>
            </form>
        </div>
    </div>
</div>
