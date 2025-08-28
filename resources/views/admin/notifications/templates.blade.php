@extends('admin.layouts.app')

@push('libraries_top')
    <!-- Include custom CSS for styling if necessary -->
    <style>
        #search-bar-container {
            margin-bottom: 20px;
            text-align: center;
        }

        #search-input {
            width: 100%;
            padding: 25px 30px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        #search-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        #search-bar-container label {
            font-weight: 500;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.templates') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.templates') }}</div>
            </div>
        </div>

        <div id="search-bar-container" class="w-full section-header">
            <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Search templates">
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped font-14" id="templates-table">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/main.title') }}</th>
                                <th>{{ trans('admin/main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $template)
                                <tr class="template-row">
                                    <td class="template-title">{{ $template->title }}</td>
                                    <td width="100">
                                        @can('admin_notifications_template_edit')
                                            <a href="{{ getAdminPanelUrl() }}/notifications/templates/{{ $template->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('admin_notifications_template_delete')
                                            @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/notifications/templates/'. $template->id.'/delete','btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-center">
                    {{ $templates->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>

    @push('scripts_bottom')
        <script>
            // Function to filter table rows based on search input
            document.getElementById('search-input').addEventListener('input', function () {
                var searchValue = this.value.toLowerCase();
                var rows = document.querySelectorAll('.template-row'); // Select rows with the class 'template-row'

                rows.forEach(function (row) {
                    var title = row.querySelector('.template-title').textContent.toLowerCase(); // Get the title text content
                    if (title.includes(searchValue)) {
                        row.style.display = '';  // Show row
                    } else {
                        row.style.display = 'none';  // Hide row
                    }
                });
            });
        </script>
    @endpush
@endsection
