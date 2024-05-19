@extends('layouts.admin')
@section('content')
@can('hole_booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.hole-bookings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.holeBooking.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.holeBooking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-HoleBooking">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.time_slot') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.mobile_1') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.total_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.elactric_charges') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.am') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.pm') }}
                        </th>
                        <th>
                            {{ trans('cruds.holeBooking.fields.ad') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\HoleBooking::TIME_SLOT_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($holeBookings as $key => $holeBooking)
                        <tr data-entry-id="{{ $holeBooking->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $holeBooking->id ?? '' }}
                            </td>
                            <td>
                                {{ $holeBooking->date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\HoleBooking::TIME_SLOT_SELECT[$holeBooking->time_slot] ?? '' }}
                            </td>
                            <td>
                                {{ $holeBooking->name ?? '' }}
                            </td>
                            <td>
                                {{ $holeBooking->mobile_1 ?? '' }}
                            </td>
                            <td>
                                {{ $holeBooking->total_amount ?? '' }}
                            </td>
                            <td>
                                {{ $holeBooking->elactric_charges ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $holeBooking->am ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $holeBooking->am ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $holeBooking->pm ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $holeBooking->pm ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $holeBooking->ad ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $holeBooking->ad ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('hole_booking_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.hole-bookings.show', $holeBooking->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('hole_booking_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.hole-bookings.edit', $holeBooking->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('hole_booking_delete')
                                    <form action="{{ route('admin.hole-bookings.destroy', $holeBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('hole_booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.hole-bookings.massDestroy') }}",
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-HoleBooking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection