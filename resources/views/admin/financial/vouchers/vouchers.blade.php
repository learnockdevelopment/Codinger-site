@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.vouchers') }}</div>
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
                                    <a href="{{ getAdminPanelUrl() }}/financial/vouchers/{{ $vouchers[0]->batch_name }}/vouchers/excel" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                                </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
    <tr>
        <th class="text-left">{{ trans('admin/main.status') }}</th>
        <th class="text-left">{{ trans('admin/main.code') }}</th>
        <th class="text-left">{{ trans('admin/main.amount') }}</th>
        <th class="text-left">{{ trans('admin/main.used_by') }}</th>
        <th class="text-left">{{ trans('admin/main.used_at') }}</th>
        <th class="text-left">{{ trans('admin/main.actions') }}</th>
    </tr>

    @foreach($vouchers as $voucher)
        <tr>
            <!-- Status Column -->
            <td class="text-left">
                <span class="{{ $voucher->is_used ? 'text-danger' : 'text-success' }}">
                    {{ $voucher->is_used ? "Used" : "Not Used" }}
                </span>
            </td>

            <!-- Code Column -->
            <td class="text-left">{{ $voucher->code }}</td>

            <!-- Amount Column -->
            <td class="text-left">{{ handlePrice($voucher->amount) }}</td>

            <!-- Used By Column -->
            <td class="text-left">
                {{ $voucher->user ? $voucher->user->full_name : '-' }}
            </td>

            <!-- Used At Column -->
            <td class="text-left">{{ $voucher->used_at ? $voucher->used_at : "-" }}</td>

            <!-- Actions Column -->
            <td class="text-left">
                <a href="{{ getAdminPanelUrl() }}/financial/vouchers/{{ $voucher->id }}/edit" class="btn-transparent text-primary" title="{{ trans('admin/main.edit') }}">
                    <i class="fa fa-edit"></i>
                </a>
<!-- Export as PDF button -->
            <a href="{{ getAdminPanelUrl() }}/financial/vouchers/{{ $voucher->id }}/pdf" class="btn-transparent text-primary" title="{{ trans('admin/main.export_pdf') }}">
                <i class="fa fa-file-pdf"></i>
            </a>

                @include('admin.includes.delete_button', ['url' => getAdminPanelUrl().'/financial/vouchers/'.$voucher->id.'/delete', 'btnClass' => ''])
            </td>
        </tr>
    @endforeach
</table>

                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $vouchers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
