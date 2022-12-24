@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employees.create') }}">
                Add Employee
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            List of Employees
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ContactEmployee">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Employee ID
                            </th>
                            <th>
                                Company
                            </th>
                            <th>
                                First Name
                            </th>
                            <th>
                                Last Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Phone No.
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $key => $employee)
                            <tr data-entry-id="{{ $employee->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $employee->id ?? '' }}
                                </td>
                                <td>
                                    {{ $employee->company->company_name ?? '' }}
                                </td>
                                <td>
                                    {{ $employee->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $employee->last_name ?? '' }}
                                </td>
                                <td>
                                    {{ $employee->email ?? '' }}
                                </td>
                                <td>
                                    {{ $employee->phone ?? '' }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.employees.edit', $employee->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}"
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
                    url: "{{ route('admin.employees.massDestroy') }}",
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
                    [1, 'desc']
                ],
                pageLength: 10,
            });
            let table = $('.datatable-ContactEmployee:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
