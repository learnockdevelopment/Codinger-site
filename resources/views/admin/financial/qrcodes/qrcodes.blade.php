@extends('admin.layouts.app')

@section('content')
 @php
        // Log the QR codes data
        \Illuminate\Support\Facades\Log::info('QR Codes Data in Blade:', $qrCodes->toArray());
    @endphp
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.qr_codes') }}</div>
            </div>
        </div>

        <div class="section-body">
            <section class="card">
                <div class="card-body">
                    <form class="mb-0" method="GET">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" data-plugin-selectTwo class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Not Used</option>
                                        <option value="expired" @if(request()->get('status') == 'expired') selected @endif>Used</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="{{ getAdminPanelUrl() }}/qr-codes/{{ $qrCodes[0]->batch_name }}/export" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.status') }}</th>
                                        <th class="text-left">{{ trans('admin/main.code') }}</th>
                                        <th class="text-left">{{ trans('admin/main.code_image') }}</th>
                                        <th class="text-left">{{ trans('admin/main.expiration_date') }}</th>
                                        <th class="text-left">{{ trans('admin/main.used_at') }}</th> <!-- Added Used At Column -->
                                      
                                        <th class="text-left">{{ trans('admin/main.used_in') }}</th> <!-- Added Used At Column -->
                                        <th class="text-left">{{ trans('admin/main.type') }}</th> <!-- Combined Type Column -->
                                        <th class="text-left">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($qrCodes as $qrCode)
                                        <tr>
                                            <!-- Status Column -->
                                            <td class="text-left">
                                                <span class="{{ $qrCode->is_used ? 'text-danger' : 'text-success' }}">
                                                    {!! $qrCode->is_used ? "Used By <a href='{$qrCode->user_url}'><strong>{$qrCode->user_full_name}</strong></a>" : "Not Used" !!}
                                                </span>
                                            </td>

                                            <!-- Code Column -->
                                            <td class="text-left">{{ $qrCode->code }}</td>

                                            <!-- QR Code Image Column -->
                                            <td class="text-left p-3">
                                                <img src="data:image/png;base64,{{ $qrCode->qr_image }}" alt="QR Code" />
                                            </td>

                                            <!-- Expiration Date Column -->
                                            <td class="text-left">
                                                {{ $qrCode->expiration_date ? \Carbon\Carbon::parse($qrCode->expiration_date)->format('Y-m-d') : '-' }}
                                            </td>

                                            <!-- Used At Column -->
                                            <td class="text-left">
                                                {{ $qrCode->used_at ? \Carbon\Carbon::parse($qrCode->used_at)->format('Y-m-d') : '-' }}
                                            </td>
<!-- Used At Column -->
                                            <td class="text-left fw-bold">
                                                {{ $qrCode->used_in_course ? $qrCode->used_in_course->title : '-' }}
                                            </td>
                                            <!-- Combined Type Column -->
                                            <td class="text-left">
                                                @if ($qrCode->bundle_id)
                                                    {{ trans('admin/main.bundle') }} - <strong>{{ $qrCode->bundle->title }}</strong>
                                                @elseif ($qrCode->category_id)
                                                    {{ trans('admin/main.category') }} - <strong>{{ $qrCode->category->title }}</strong>
                                                @elseif ($qrCode->webinar_ids)
                                                    {{ trans('admin/main.webinar') }} - <strong>{{ $qrCode->webinar->title }}</strong>
                                                @else
                                                    {{ trans('admin/main.no_type') }}
                                                @endif
                                            </td>

                                            <!-- Actions Column -->
                                            <td class="text-left">
                                                <a href="{{ getAdminPanelUrl() }}/financial/qrcodes/{{ $qrCode->id }}/pdf" class="btn-transparent text-primary" title="{{ trans('admin/main.export_pdf') }}">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $qrCodes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
