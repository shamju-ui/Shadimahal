@extends('layouts.admin')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.students.create') }}">
                Student Registration
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        Student List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Student">
                <thead>
                    <tr>
                        <th></th>
                        <!-- <th>id</th> -->
                        <th>Name</th>
                        <th>Course</th>
                        <th>Stream</th>
                        <th>Guardian Name</th>
                     
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr data-entry-id="{{ $student->id }}">
                            <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.students.show', $student->id) }}">
                                        View
                                    </a>
                               
                                    <!-- <a class="btn btn-xs btn-info" href="{{ route('admin.students.edit', $student->id) }}">
                                        Edit
                                    </a> -->
                               
                            
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                
                            </td>
                            <!-- <td>{{ $student->id ?? '' }}</td> -->
                            <td><a class="" href="{{ route('admin.students.edit', $student->id) }}">{{ $student->student_name ?? '' }}</a></td>
                            <td>{{ $student->course->name ?? '' }}</td>
                            <td>{{ $student->stream->name ?? '' }}</td>
                            <td>{{ $student->guardian_name ?? ''}}</td>
                            
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
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('student_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.students.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        });
        $('.datatable-Student:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    })
</script>
@endsection
