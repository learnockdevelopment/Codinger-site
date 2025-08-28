@php
    $canReserve = !empty($instructor->meeting) 
        && !$instructor->meeting->disabled 
        && !empty($instructor->meeting->meetingTimes) 
        && $instructor->meeting->meeting_times_count > 0;
@endphp

<div class="rounded-lg mt-25 p-20 course-teacher-card instructors-list text-center d-flex align-items-center flex-column position-relative">
    <!-- Instructor Profile Link -->
    <a href="{{ $instructor->getProfileUrl() }}" class="text-center d-flex flex-column align-items-center justify-content-center">
        <div class="teacher-avatar mt-5 position-relative">
            <img src="{{ $instructor->getAvatar(190) }}" class="img-cover" alt="{{ $instructor->full_name }}">
        </div>

        <h3 class="mt-20 font-16 font-weight-bold text-dark-blue text-center" style="color: var(--primary); font-weight: bold;">
            {{ $instructor->full_name }}
        </h3>
    </a>

    <!-- Bio -->
    @if(!empty($instructor->bio))
        <div class="mt-5 font-14 text-gray" style="color: var(--primary); font-weight: bold;">
            {{ $instructor->bio }}
        </div>
    @endif

    <!-- Rating -->
    <div class="stars-card d-flex align-items-center">
        @include('web.default.includes.webinar.rate', ['rate' => $instructor->rates()])
    </div>

    <!-- Outline Button for Appointments -->
    @if($canReserve)
        <a href="{{ $instructor->getProfileUrl() }}?tab=appointments#appointments" 
           class="btn btn-outline-primary mt-3">
            {{ trans('site.book_an_appointment') }}
        </a>
    @endif
</div>
