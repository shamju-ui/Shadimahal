@php
    $today = \Carbon\Carbon::today()->format('d-m-Y');
    $dateValue = old('date_1')??$today;
    $dateValue;
@endphp
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.holeBooking.title_singular') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class=" col-md-6">
        <table id="bookingDetailsTable" class="table">
           
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time Slot</th>
                </tr>
            </thead>
            <tbody id="bookingDetailsBody">
                <!-- Table rows with data will be added dynamically by JavaScript -->
            </tbody>
        </table>
    </div>
</div>
        <form method="POST" id="bookingDetailsForm" action="{{ route('admin.hall-bookings.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="booking_details" id="booking_details" value="" hidden>

            <div class="row">
                <div class=" col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.holeBooking.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="required" for="mobile_1">{{ trans('cruds.holeBooking.fields.mobile_1') }}</label>
                        <input class="form-control {{ $errors->has('mobile_1') ? 'is-invalid' : '' }}" type="text" name="mobile_1" id="mobile_1" value="{{ old('mobile_1', '') }}" required>
                        @if($errors->has('mobile_1'))
                            <span class="text-danger">{{ $errors->first('mobile_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_1_helper') }}</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_2">{{ trans('cruds.holeBooking.fields.mobile_2') }}</label>
                        <input class="form-control {{ $errors->has('mobile_2') ? 'is-invalid' : '' }}" type="text" name="mobile_2" id="mobile_2" value="{{ old('mobile_2', '') }}">
                        @if($errors->has('mobile_2'))
                            <span class="text-danger">{{ $errors->first('mobile_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_2_helper') }}</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="address_line_1">{{ trans('cruds.holeBooking.fields.address_line_1') }}</label>
                        <input type="text"  class="form-control {{ $errors->has('address_line_1') ? 'is-invalid' : '' }}" name="address_line_1" id="address_line_1" value="{{ old('address_line_1') }}">
                        @if($errors->has('address_line_1'))
                            <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_1_helper') }}</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="address_line_2">{{ trans('cruds.holeBooking.fields.address_line_2') }}</label>
                        <input type="text" class="form-control {{ $errors->has('address_line_2') ? 'is-invalid' : '' }}" name="address_line_2" id="address_line_2" value="{{ old('address_line_2') }}">
                        @if($errors->has('address_line_2'))
                            <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_2_helper') }}</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="event_type" class="col-form-label">Event Type</label>
                        <input required type="text" class="form-control {{ $errors->has('event_type') ? 'is-invalid' : '' }}" name="event_type" id="event_type" list="event_types" value="{{ old('event_type') }}" required>
                        <datalist id="event_types">
                            <option value="marriage">
                            <option value="engagement">
                            <option value="house warming">
                        </datalist>
                        @if($errors->has('event_type'))
                            <span class="text-danger">Need Event Type</span>
                        @endif
                        <span class="help-block">Need Event Type</span>
                    </div>
                </div>
                <div class=" col-md-6">
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="total_amount">{{ trans('cruds.holeBooking.fields.total_amount') }}</label>
                        <input required  class="form-control {{ $errors->has('total_amount') ? 'is-invalid' : '' }}" type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', '') }}" step="0.01">
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
                            <input type="text" class="form-control" name="discount" id="discount" value="{{ old('discount', '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="by" class="col-form-label">By:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="discount_by" id="by" value="{{ old('discount_by', '') }}">
                        </div>
                    </div>
                    <div class="form-group col-4">
                        <label for="by" class="col-form-label">Balance:</label>
                        <div class="col-md-9">
                            <span id ="bal_amt" style="color:red; font-size:15"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="advance_paid" class="col-form-label ">Advance Paid</label>
                        <div class="col-md-9">
                            <input  required type="number" class="form-control" name="advance_paid" id="advance_paid" value="{{ old('advance_paid', '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="receipt_1" class="col-form-label ">Receipt:</label>
                        <div class="col-md-9">
                            <input required type="text" class="form-control" name="receipt_1" id="receipt_1" value="{{ old('receipt_1', '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="date_1" class="col-form-label ">Date:</label>
                        <div class="col-md-9">
                            <input required type="date" class="form-control" name="date_1" id="date_1" value="{{old('date_1', $dateValue) }}">
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="balance_amount" class="col-form-label ">Balance Amount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="balance_amount" id="balance_amount" value="{{ old('balance_amount', '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="receipt_2" class="col-form-label ">Receipt:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="receipt_2" id="receipt_2" value="{{ old('receipt_2', '') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="date_2" class="col-form-label ">Date:</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="date_2" id="date_2" value="{{ old('date_2', '') }}">
                        </div>
                    </div>

    <div class="col-12 row">
                    <div class="form-group col-4">
                        <label for="comment">{{ trans('cruds.holeBooking.fields.comment') }}</label>
                        <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment">{{ old('comment', '') }}</textarea>
                        @if($errors->has('comment'))
                            <span class="text-danger">{{ $errors->first('comment') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.comment_helper') }}</span>
                    </div>
                </div>
            </div>
        </div>
            <div class="form-group">
                <button class="btn btn-danger" id="submitBtn"type="button">
                    {{ trans('global.save') }}
                </button>
                <a style="margin-left:30px" class="btn btn-default" href="{{ route('admin.new-bookings.index') }}">
                    Back to Booking Selection
                </a>
            </div>
            <div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
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
 // Function to parse query string and extract parameters
 function getQueryStringParams() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let values = urlParams.get('values');
    values = decodeURIComponent(values); // Decode URL parameter
    values = atob(values).replace(/"/g, ''); // Decode Base64
    console.log(values);
    $("#booking_details").val(values)
    return values ? values.split(',') : [];
}

function calculateBalance() {
            var totalAmount = parseFloat($('#total_amount').val()) || 0;
            var discount = parseFloat($('#discount').val()) || 0;
            var advancePaid = parseFloat($('#advance_paid').val()) || 0;

            var balance = totalAmount - discount - advancePaid;

            $('#bal_amt').text(balance.toFixed(2));
        }

        // Attach event listeners to the input fields
        $('#total_amount, #discount, #advance_paid').on('input', calculateBalance);
// Function to update the table with booking details
function updateBookingDetails(bookingDetails) {
    const tableBody = document.getElementById('bookingDetailsBody');
    tableBody.innerHTML = ''; // Clear existing rows
    bookingDetails.forEach(detail => {
        const [date, timeSlot] = detail.split('-');
        const row = tableBody.insertRow();
        const dateCell = row.insertCell(0);
        const timeSlotCell = row.insertCell(1);
        dateCell.textContent = date;
        timeSlotCell.textContent = timeSlot;
    });
}

// Function to run on page load
window.onload = function() {
    const bookingDetails = getQueryStringParams();
    updateBookingDetails(bookingDetails);
};

// function calculateBalance() {
//     var totalAmount = parseFloat(document.getElementById('total_amount').value);
//     var electricCharges = parseFloat(document.getElementById('elactric_charges').value);
//     var advance = parseFloat(document.getElementById('advance').value);

//     // Check if any of the values are NaN, and if so, set them to zero
//     if (isNaN(totalAmount)) {
//         totalAmount = 0;
//     }
//     if (isNaN(electricCharges)) {
//         electricCharges = 0;
//     }
//     if (isNaN(advance)) {
//         advance = 0;
//     }

//     var balance = totalAmount + electricCharges - advance;

//     document.getElementById('balance').value = balance.toFixed(2);
// }
</script>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
    lastDate(); 
    

        // Initial calculation
        calculateBalance();;
 
});

   function lastDate() {
                const currentDate = new Date();
                const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                const lastDate = lastDayOfMonth.getDate();
                const currentYear = lastDayOfMonth.getFullYear();
                const currentMonth = lastDayOfMonth.getMonth() + 1;

                const lastDateString = `${String(lastDate).padStart(2, '0')}/${String(currentMonth).padStart(2, '0')}/${currentYear}`;
                const firstDateString = `01/${String(currentMonth).padStart(2, '0')}/${currentYear}`;

                document.getElementById('date_1').value = lastDateString;
                document.getElementById('date_2').value = firstDateString;
               
            }
    </script>
@endsection