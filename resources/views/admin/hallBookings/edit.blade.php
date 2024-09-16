@extends('layouts.admin')
@section('content')
@php
    $today = \Carbon\Carbon::today()->format('d/m/Y');
    $dateValue = old('date_1')??$today;
  
@endphp
<div class="card">
    <div class="card-header">
        Edit Booking
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
        <table id="bookingDetailsTable" class="table">
            <thead>
                <tr style="color: green">
                    <th>Date</th>
                    <th>Time Slot</th>
                </tr>
            </thead>
            <tbody id="bookingDetailsBody" tyle="color: gold">
                <!-- Table rows with data will be added dynamically by JavaScript -->
            </tbody>
        </table>
    </div>
</div>
        <form id="bookingDetailsForm" method="POST" action="{{ route('admin.hall-bookings.update', [$holeBooking]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="text" name="booking_details" id="booking_details" value="" hidden>
            <input type="text" name="id" id="id" value="{{$holeBooking->id}}" hidden>
     
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.holeBooking.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $holeBooking->name) }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="required" for="mobile_1">{{ trans('cruds.holeBooking.fields.mobile_1') }}</label>
                        <input class="form-control {{ $errors->has('mobile_1') ? 'is-invalid' : '' }}" type="text" name="mobile_1" id="mobile_1" value="{{ old('mobile_1', $holeBooking->mobile_1) }}" required>
                        @if($errors->has('mobile_1'))
                            <span class="text-danger">{{ $errors->first('mobile_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_1_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_2">{{ trans('cruds.holeBooking.fields.mobile_2') }}</label>
                        <input class="form-control {{ $errors->has('mobile_2') ? 'is-invalid' : '' }}" type="text" name="mobile_2" id="mobile_2" value="{{ old('mobile_2', $holeBooking->mobile_2) }}">
                        @if($errors->has('mobile_2'))
                            <span class="text-danger">{{ $errors->first('mobile_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_2_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="address_line_1">{{ trans('cruds.holeBooking.fields.address_line_1') }}</label>
                        <input type="text"  class="form-control {{ $errors->has('address_line_1') ? 'is-invalid' : '' }}" name="address_line_1" id="address_line_1" value="{{ old('address_line_1', $holeBooking->address_line_1) }}">
                        @if($errors->has('address_line_1'))
                            <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_1_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="address_line_2">{{ trans('cruds.holeBooking.fields.address_line_2') }}</label>
                        <input type="text" class="form-control {{ $errors->has('address_line_2') ? 'is-invalid' : '' }}" name="address_line_2" id="address_line_2" value="{{ old('address_line_2', $holeBooking->address_line_2) }}">
                        @if($errors->has('address_line_2'))
                            <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_2_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="event_type" class="col-form-label">Event Type</label>
                        <input required type="text" class="form-control {{ $errors->has('event_type') ? 'is-invalid' : '' }}" name="event_type" id="event_type" list="event_types" value="{{ old('event_type', $holeBooking->event_type) }}" required>
                        <datalist id="event_types">
                            <option selected value="marriage">
                            <option value="engagement">
                            <option value="house warming">
                        </datalist>
                        @if($errors->has('event_type'))
                            <span class="text-danger">Need Event Type</span>
                        @endif
                        <span class="help-block">Need Event Type</span>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="total_amount">{{ trans('cruds.holeBooking.fields.total_amount') }}</label>
                        <input required class="form-control {{ $errors->has('total_amount') ? 'is-invalid' : '' }}" type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', $holeBooking->total_amount) }}" step="0.01">
                        @if($errors->has('total_amount'))
                            <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.total_amount_helper') }}</span>
                    </div>
                </div>

                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="discount" class="col-form-label">Discount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="discount" id="discount" value="{{ old('discount', $holeBooking->discount) }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="by" class="col-form-label">By:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="discount_by" id="by" value="{{ old('discount_by', $holeBooking->discount_by) }}">
                        </div>
                    </div>
                    <div class="form-group col-4">
                        <label for="by" class="col-form-label">Balance:</label>
                        <div class="col-md-9">
                            <span id="bal_amt" style="color:red; font-size:15"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="advance_paid" class="col-form-label">Advance Paid</label>
                        <div class="col-md-9">
                            <input required type="text" class="form-control" name="advance_paid" id="advance_paid" value="{{ old('amount', $bookingPayments->first()->amount ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="receipt_1" class="col-form-label">Receipt:</label>
                        <div class="col-md-9">
                            <input required type="text" class="form-control" name="receipt_1" id="receipt_1" value="{{ old('receipt', $bookingPayments->first()->receipt ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="date_1" class="col-form-label">Date:</label>
                        <div class="col-md-9">
                            <input required type="date" class="form-control" name="date_1" id="date_1" value="{{ old('date_1', $bookingPayments->first()->date_1) }}">
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="balance_amount" class="col-form-label">Balance Amount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="balance_amount" id="balance_amount" value="{{ old('balance_amount', $bookingPayments->get(1)->amount ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="receipt_2" class="col-form-label">Receipt:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="receipt_2" id="receipt_2" value="{{ old('receipt', $bookingPayments->get(1)->receipt ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="date_2" class="col-form-label">Date:</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="date_2" id="date_2" value="{{ old('date_1', $bookingPayments->get(1)->date_1 ?? '') }}">
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="comment">{{ trans('cruds.holeBooking.fields.comment') }}</label>
                        <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment">{{ old('comment', $holeBooking->comment) }}</textarea>
                        @if($errors->has('comment'))
                            <span class="text-danger">{{ $errors->first('comment') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.comment_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="button" id="submitBtn">
                  update
                </button>
                <a style="margin-left:30px" class="btn btn-default" href="{{ route('admin.hall-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
            
            <div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Function to calculate the balance amount
    function calculateBalance() {
        var totalAmount = parseFloat($('#total_amount').val()) || 0;
        var discount = parseFloat($('#discount').val()) || 0;
        var advancePaid = parseFloat($('#advance_paid').val()) || 0;
        var balanceAmount = parseFloat($('#balance_amount').val()) || 0;
        var balance = totalAmount - discount - advancePaid - balanceAmount;

        $('#bal_amt').html(balance.toFixed(2)); // Use .html() or .text() to update the span
    }

    $(document).ready(function () {
        // Attach event listeners to the input fields
        $('#total_amount, #discount, #advance_paid, #balance_amount').on('input', calculateBalance);

        // Initial calculation
        calculateBalance();

        // Populate the booking details table
        const initialBookings = {!! json_encode($bookingDateTimes) !!};
        const bookingDetailsBody = $('#bookingDetailsBody');
        const bookingDetailsInput = $('#booking_details');

        initialBookings.forEach(booking => {
            const row = $('<tr>');
            const dateCell = $('<td>').text(booking.booked_date);
            const slotCell = $('<td>').text(booking.time_slot);
            row.append(dateCell, slotCell);
            bookingDetailsBody.append(row);
        });

        const bookingDetails = initialBookings.map(booking => `${booking.booked_date}-${booking.time_slot}`).join(',');
        bookingDetailsInput.val(bookingDetails);
    });

    $('#submitBtn').click(function() {
        var advancePaid = $('#advance_paid').val().trim();
        var receipt = $('#receipt_1').val().trim();
        if (advancePaid !== "" && receipt === "") {
            alert("If 'Advance Paid' is filled, 'Receipt' must also be filled.");
            return false;
        }
        var balance_amount = $('#balance_amount').val().trim();
        var receipt_2 = $('#receipt_2').val().trim();
        if (receipt_2 !== "" && receipt_2 === "") {
            alert("If 'Balance amount Paid' is filled, 'Receipt' must also be filled.");
            return false;
        }
        for (const el of document.getElementById('bookingDetailsForm').querySelectorAll("[required]")) {
        if (!el.reportValidity()) {
            return;
        }
    }
        $('#bookingDetailsForm').submit();
    });
</script>
@endsection
