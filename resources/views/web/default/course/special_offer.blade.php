<div class="special-offer-card d-flex flex-column flex-md-row align-items-center justify-content-between rounded-lg shadow-xs bg-white p-15 p-md-30">
    <div class="d-flex flex-column">
        <strong class="special-offer-title font-16 text-light font-weight-bold">{{ trans('panel.special_offer') }}</strong>
        <span class="font-14 text-muted">{{ $activeSpecialOffer->name }}</span>
    </div>

    <div class="mt-20 mt-md-0 mb-30 mb-md-0">
        @php
            $remainingTimes = $activeSpecialOffer->getRemainingTimes()
        @endphp
        <div id="offerCountDown" class="d-flex time-counter-down"
             data-day="{{ $remainingTimes['day'] }}"
             data-hour="{{ $remainingTimes['hour'] }}"
             data-minute="{{ $remainingTimes['minute'] }}"
             data-second="{{ $remainingTimes['second'] }}">

            <div class="d-flex align-items-center flex-column mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-weight-bold text-dark time-item days"></span>
                <span class="font-12 mt-1 text-light">{{ trans('public.day') }}</span>
            </div>
            <div class="d-flex align-items-center flex-column mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-weight-bold text-dark time-item hours"></span>
                <span class="font-12 mt-1 text-light">{{ trans('public.hr') }}</span>
            </div>
            <div class="d-flex align-items-center flex-column mr-10">
                <span class="bg-gray300 rounded p-10 font-16 font-weight-bold text-dark time-item minutes"></span>
                <span class="font-12 mt-1 text-light">{{ trans('public.min') }}</span>
            </div>
            <div class="d-flex align-items-center flex-column">
                <span class="bg-gray300 rounded p-10 font-16 font-weight-bold text-dark time-item seconds"></span>
                <span class="font-12 mt-1 text-light">{{ trans('public.sec') }}</span>
            </div>
        </div>
    </div>

    <div class="offer-percent-box d-flex flex-column align-items-center justify-content-center">
        <span class="percent text-white">{{ $activeSpecialOffer->percent }}%</span>
        <span class="off text-white">{{ trans('public.off') }}</span>
    </div>
</div>

@push('styles_top')
<style>
  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0); /* Starting and ending position */
    }
    40% {
        transform: translateY(15px); /* Move down */
    }
    60% {
        transform: translateY(10px); /* Slight bounce back */
    }
}

.special-offer-card .offer-percent-box {
    animation: bounce 2s infinite; /* Apply bounce animation to the entire box */
}
  .special-offer-card{
      background-color: #ffffff36 !important;

  }
  .special-offer-card .bg-gray300{
  	    background-color: #ececec40 !important;

  }
</style>
@endpush
