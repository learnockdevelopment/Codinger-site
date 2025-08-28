@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.qrcodes') }}</div>
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
                                    <div class="input-group date" id="createdDate" data-target-input="nearest">
                                        <input type="date" class="form-control datetimepicker-input" name="from" value="{{ request()->get('from') }}" placeholder="Start Date" data-target="#createdDate">
                                        <div class="input-group-append" data-target="#createdDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.expiration_date') }}</label>
                                    <div class="input-group date" id="expirationDate" data-target-input="nearest">
                                        <input type="date" class="form-control datetimepicker-input" name="to" value="{{ request()->get('to') }}" placeholder="End Date" data-target="#expirationDate">
                                        <div class="input-group-append" data-target="#expirationDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
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
                                        <th class="text-left" width="150">{{ trans('admin/main.qrcodes_count') }}</th>
                                      <th class="text-left" width="150">{{ trans('admin/main.type') }}</th>
                                        <th class="text-left" width="150">{{ trans('admin/main.used_qrcodes') }}</th> <!-- Used QR Codes -->
                                        <th class="text-left" width="150">{{ trans('admin/main.expiration_date') }}</th> <!-- Expiration Date -->
                                        <th class="text-left" width="150">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($qrCodeGroups as $group)
                                        <tr>
                                            <td class="text-left">{{ $group->batch_name }}</td>
                                            <td class="text-left">{{ \Carbon\Carbon::parse($group->created_at)->format('Y-m-d | h:m') }}</td>

                                            <td class="text-left">{{ $group->qrcodes_count }}</td>
<td class="text-left">
    @if ($group->bundle)
        <a href="{{ $group->bundle->getUrl() }}" target="_blank">
            {{ trans('admin/main.bundle') }} - <strong>{{ $group->bundle->title }}</strong>
        </a>
    @elseif ($group->category)
        <a href="{{ $group->category->getUrl() }}" target="_blank">
            {{ trans('admin/main.category') }} - <strong>{{ $group->category->title }}</strong>
        </a>
    @elseif ($group->webinar)
        <a href="{{ $group->webinar->getUrl() }}" target="_blank">
            {{ trans('admin/main.webinar') }} - <strong>{{ $group->webinar->title }}</strong>
        </a>
    @else
        {{ trans('admin/main.no_type') }}
    @endif
</td>

                                            <!-- Combined Progress Bar for Used and Unused QR Codes -->
                                            <td class="text-left">
                                                <div class="progress" style="height: 20px;">
                                                    <!-- Used QR Codes Segment -->
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $group->used_count / $group->qrcodes_count * 100 }}%;" aria-valuenow="{{ $group->used_count }}" aria-valuemin="0" aria-valuemax="{{ $group->qrcodes_count }}">
                                                        {{ $group->used_count }}
                                                    </div>

                                                    <!-- Unused QR Codes Segment -->
                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $group->unused_count / $group->qrcodes_count * 100 }}%;" aria-valuenow="{{ $group->unused_count }}" aria-valuemin="0" aria-valuemax="{{ $group->qrcodes_count }}">
                                                        {{ $group->unused_count }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Displaying Expiration Date -->
                                            <td class="text-left">{{ \Carbon\Carbon::parse($group->expiration_date)->format('Y-m-d') }}</td>

                                            <td class="text-left">
                                                <a href="{{ getAdminPanelUrl() }}/financial/qrcodes/{{ $group->batch_name }}/qrcodes" class="btn-transparent text-primary" title="{{ trans('admin/main.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                <!-- Export as ZIP button -->
                                                <a href="{{ getAdminPanelUrl() }}/financial/qrcodes/group/{{ $group->batch_name }}/zip" class="btn-transparent text-primary" title="{{ trans('admin/main.export_zip') }}">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>

                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/financial/qrcodes/'. $group->batch_name.'/qrcodes/delete','btnClass' => ''])
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $qrCodeGroups->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
