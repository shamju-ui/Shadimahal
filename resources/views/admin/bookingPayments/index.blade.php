@extends('layouts.admin')
@section('content')
@can('booking_payment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.booking-payments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bookingPayment.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bookingPayment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BookingPayment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.amount_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.booking') }}
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
                            {{ trans('cruds.holeBooking.fields.address_line_1') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingPayments as $key => $bookingPayment)
                        <tr data-entry-id="{{ $bookingPayment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $bookingPayment->id ?? '' }}
                            </td>
                            <td>
                                {{ $bookingPayment->amount ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\BookingPayment::AMOUNT_TYPE_SELECT[$bookingPayment->amount_type] ?? '' }}
                            </td>
                            <td>
                                {{ $bookingPayment->booking->date ?? '' }}
                            </td>
                            <td>
                                @if($bookingPayment->booking)
                                    {{ $bookingPayment->booking::TIME_SLOT_SELECT[$bookingPayment->booking->time_slot] ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $bookingPayment->booking->name ?? '' }}
                            </td>
                            <td>
                                {{ $bookingPayment->booking->mobile_1 ?? '' }}
                            </td>
                            <td>
                                {{ $bookingPayment->booking->address_line_1 ?? '' }}
                            </td>
                            <td>
                                @can('booking_payment_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.booking-payments.show', $bookingPayment->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('booking_payment_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.booking-payments.edit', $bookingPayment->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('booking_payment_delete')
                                    <form action="{{ route('admin.booking-payments.destroy', $bookingPayment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('booking_payment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.booking-payments.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-BookingPayment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection