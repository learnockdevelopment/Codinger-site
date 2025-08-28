@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.subject_section') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('categories.subjects') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.icon') }}</th>
                                        <th class="text-left">{{ trans('update.order') }}</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>
                                    @foreach($subjects as $category)

                                        <tr>
                                            <td>
                                                @if(!empty($category->icon))
                                                    <img src="{{ $category->icon }}" width="30" alt="">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-left">{{ $category->order }}</td>
                                            <td class="text-left">{{ $category->title }}</td>
                                            <td>
                                                @can('admin_categories_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/subject/{{ $category->id }}/edit"
                                                       class="btn-transparent btn-sm text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_categories_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/subject/'.$category->id.'/delete', 'deleteConfirmMsg' => trans('update.category_delete_confirm_msg')])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $subjects->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
