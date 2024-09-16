@extends('layouts.admin')
@section('content')
@can('hole_booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.new-bookings.index') }}">
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
            <table class="table table-bordered table-striped table-hover datatable datatable-HoleBooking">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.holeBooking.fields.name') }}</th>
                        <th>Booked Dates</th>
                        <th>{{ trans('cruds.holeBooking.fields.mobile_1') }}</th>
                        <th>Event Type</th>
                        <th>{{ trans('cruds.holeBooking.fields.total_amount') }}</th>
                        <th>Discount</th>
                        <th>Discount By</th>
                        <th>Comment</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="show-all" id="showAll"> All</td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="date search" type="text"></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($holeBookings as $key => $holeBooking)
                        <tr data-entry-id="{{ $holeBooking->id }}" >
                            <td style="display:flex;flex-gap:2px">
                                @can('hole_booking_show')
                                <a class="" href="{{ route('admin.hall-bookings.show', $holeBooking->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                @endcan
                                @can('hole_booking_delete')
                                <button class="btn btn-xs btn-danger cancel-booking-btn" data-booking-id="{{ $holeBooking->id }}" style="margin-left:4px">Cancel</button>
                                @endcan
                            </td>
                            <td>
                                <a class="" href="{{ route('admin.hall-bookings.edit', $holeBooking->id) }}">{{ $holeBooking->name ?? '' }}</a>
                            </td>
                            <td>{{ $holeBooking->booked_dates ?? '' }}</td>
                            <td>{{ $holeBooking->mobile_1 ?? '' }}</td>
                            <td>{{ $holeBooking->event_type ?? '' }}</td>
                            <td>{{ $holeBooking->total_amount ?? '' }}</td>
                            <td>{{ $holeBooking->discount ?? '' }}</td>
                            <td>{{ $holeBooking->discount_by ?? '' }}</td>
                            <td>{{ $holeBooking->comment ?? '' }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelBookingModalLabel">Cancel Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please enter the cancellation amount:</p>
                <form id="cancelBookingForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="cancellationAmount">Amount:</label>
                        <input type="number" class="form-control" id="cancellationAmount" name="cancellation_amount" value="" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmCancellationBtn">Confirm Cancellation</button>
            </div>
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
            if (amount.trim() === '') {
                alert('Please enter the cancellation amount.');
            } else {
                $('#cancelBookingForm').submit();
            }
        });

        // Custom sorting for date column
        jQuery.fn.dataTable.ext.type.order['date-dd-mmm-yyyy-pre'] = function(d) {
            return moment(d, 'DD/MM/YYYY').toDate();
        };

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
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 2, 'asc' ]],
            pageLength: 25,
        });

        // Initialize DataTable
        let table = $('.datatable-HoleBooking:not(.ajaxTable)').DataTable({
            buttons: dtButtons,
            columnDefs: [
                {
                    targets: 2, // Index of the 'Booked Dates' column
                    type: 'date-dd-mmm-yyyy'
                }
            ]
        });

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
    });

    document.addEventListener('DOMContentLoaded', function() {
        const showAllCheckbox = document.getElementById('showAll');

        // Check the query string to set the initial state of the checkbox
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('showAll') === 'true') {
            showAllCheckbox.checked = true;
        }

        showAllCheckbox.addEventListener('change', function() {
            const showAll = showAllCheckbox.checked;
            const queryParams = new URLSearchParams(window.location.search);
            queryParams.set('showAll', showAll);

            // Reload the page with the updated query string
            window.location.search = queryParams.toString();
        });
    });

</script>
@endsection
