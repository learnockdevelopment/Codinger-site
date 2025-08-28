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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}" placeholder="{{ trans('admin/main.search_placeholder') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.created_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.expiration_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" data-plugin-selectTwo class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Active</option>
                                        <option value="expired" @if(request()->get('status') == 'expired') selected @endif>Expired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left" width="150">{{ trans('admin/main.batch_name') }}</th>
                                        <th class="text-left" width="150">{{ trans('admin/main.created_date') }}</th>
                                        <th class="text-left" width="150">{{ trans('admin/main.vouchers_count') }}</th>
                                        <th class="text-left" width="150">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($voucherGroups as $group)
                                        <tr>
                                            <td class="text-left">{{ $group->batch_name }}</td>
                                            <td class="text-left">{{ $group->created_at }}</td>
                                            <td class="text-left">{{ $group->vouchers_count }}</td>
                                            <td class="text-left">
                                                <a href="{{ getAdminPanelUrl() }}/financial/vouchers/{{ $group->batch_name }}/vouchers" class="btn-transparent text-primary" title="{{ trans('admin/main.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <!-- Export as PDF button 
            <a href="{{ getAdminPanelUrl() }}/financial/vouchers/group/{{ $group->batch_name }}/pdf" class="btn-transparent text-primary" title="{{ trans('admin/main.export_pdf') }}">
                <i class="fa fa-file-pdf"></i>
            </a>
-->
                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/financial/vouchers/'. $group->batch_name.'/vouchers/delete','btnClass' => ''])
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $voucherGroups->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
