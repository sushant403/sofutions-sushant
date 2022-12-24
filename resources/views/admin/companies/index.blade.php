@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.companies.create') }}">
                Add Company
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            List of Companies
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ContactCompany">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Company ID
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Logo
                            </th>
                            <th>
                                Website
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $key => $company)
                            <tr data-entry-id="{{ $company->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $company->id ?? '' }}
                                </td>
                                <td>
                                    {{ $company->company_email ?? '' }}
                                </td>
                                <td>
                                    {{ $company->company_name ?? '' }}
                                </td>
                                <td>
                                    {{ $company->company_logo ?? '' }}
                                </td>
                                <td>
                                    {{ $company->company_website ?? '' }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.companies.edit', $company->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.companies.destroy', $company->id) }}"
                                        method="POST" onsubmit="return confirm('Are you sure?');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="Delete">
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                let deleteButtonTrans = 'Delete Selected'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.companies.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('Zero Selected')

                            return
                        }

                        if (confirm('Are you sure?')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [2, 'asc']
                ],
                pageLength: 10,
            });
            let table = $('.datatable-ContactCompany:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
