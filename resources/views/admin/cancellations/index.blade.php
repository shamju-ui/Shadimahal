@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
     Cancellations
    </div>

    <div class="card-body">
        <div class="table-responsive">
           <table class=" table table-bordered table-striped table-hover datatable datatable-HoleBooking">
                <thead>
                    <tr>
                        <th> Name</th>
                        <th> Mobile</th>
                        <th>Amount</th>
                        <th>Canceled At</th>
                        <th>Canceled By</th>
                    </tr>
                    <tr>
     
                        <td><input class="search" type="text" placeholder="Name"></td>
                     
                        <td><input class="search" type="text" placeholder="Mobile"></td>
                        {{-- <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td> --}}
                        <td><input class="search" type="text" placeholder="Amount"></td>
                        <td><input class="search" type="text" placeholder="Canceled At"></td>
                        <td><input class="search" type="text" placeholder="Canceled By"></td>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($cancellations as $cancellation)
                        <tr>
                     
                            <td>{{ $cancellation->hall ? $cancellation->hall->name : '' }}</td>
                            <td>{{ $cancellation->hall ? $cancellation->hall->mobile_1 : '' }}</td>
                            <td>{{ $cancellation->amount }}</td>
                            <td>{{ $cancellation->canceled_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $cancellation->user ? $cancellation->user->name : '' }}</td>
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
    // Handle cancel button click to open modal
    $('body').on('click', '.cancel-booking-btn', function() {
        var bookingId = $(this).data('booking-id');
        $('#id').val(bookingId);
        $('#cancelBookingForm').attr('action', "{{ url('admin/hall-bookings') }}" + '/' + bookingId);
        $('#cancelBookingModal').modal('show');
    });

    // Handle confirmation of cancellation
    $('#confirmCancellationBtn').on('click', function() {
        var amount = $('#cancellationAmount').val();
        $('#cancellationAmount').val()
        if (amount.trim() === '') {
            alert('Please enter the cancellation amount.');
        } else {
            $('#cancelBookingForm').submit();
        }
    });
});
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
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function () { location.reload() })
                }
            }
        }
      //  dtButtons.push(deleteButton)
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