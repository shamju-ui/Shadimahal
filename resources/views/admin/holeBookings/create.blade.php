@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.holeBooking.title_singular') }}
    </div>

    <div class="card-body">
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
        <form method="POST" action="{{ route("admin.hole-bookings.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="booking_details" id="booking_details" value="" hidden>
            
            <div class="row">
                <div class="col-md-6">
                    {{-- <div class="form-group">
                        <label class="required" for="date">{{ trans('cruds.holeBooking.fields.date') }}</label>
                        <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}" required>
                        @if($errors->has('date'))
                            <span class="text-danger">{{ $errors->first('date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.date_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.holeBooking.fields.time_slot') }}</label>
                        <select class="form-control {{ $errors->has('time_slot') ? 'is-invalid' : '' }}" name="time_slot" id="time_slot" required>
                            <option value disabled {{ old('time_slot', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\HoleBooking::TIME_SLOT_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('time_slot', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('time_slot'))
                            <span class="text-danger">{{ $errors->first('time_slot') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.time_slot_helper') }}</span>
                    </div> --}}
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.holeBooking.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="mobile_1">{{ trans('cruds.holeBooking.fields.mobile_1') }}</label>
                        <input class="form-control {{ $errors->has('mobile_1') ? 'is-invalid' : '' }}" type="text" name="mobile_1" id="mobile_1" value="{{ old('mobile_1', '') }}" required>
                        @if($errors->has('mobile_1'))
                            <span class="text-danger">{{ $errors->first('mobile_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_1_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="address_line_1">{{ trans('cruds.holeBooking.fields.address_line_1') }}</label>
                        <textarea class="form-control {{ $errors->has('address_line_1') ? 'is-invalid' : '' }}" name="address_line_1" id="address_line_1">{{ old('address_line_1') }}</textarea>
                        @if($errors->has('address_line_1'))
                            <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_1_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="total_amount">{{ trans('cruds.holeBooking.fields.total_amount') }}</label>
                        <input oninput="calculateBalance()" class="form-control {{ $errors->has('total_amount') ? 'is-invalid' : '' }}" type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', '') }}" step="0.01">
                        @if($errors->has('total_amount'))
                            <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.total_amount_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="elactric_charges">{{ trans('cruds.holeBooking.fields.elactric_charges') }}</label>
                        <input class="form-control" oninput="calculateBalance()" {{ $errors->has('elactric_charges') ? 'is-invalid' : '' }}" type="number" name="elactric_charges" id="elactric_charges" value="{{ old('elactric_charges', '') }}">
                        @if($errors->has('elactric_charges'))
                            <span class="text-danger">{{ $errors->first('elactric_charges') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.elactric_charges_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="elactric_charges">Advance</label>
                        <input class="form-control }}" type="number" oninput="calculateBalance()" name="advance" id="advance" value="{{ old('advance', '') }}">
                        @if($errors->has('elactric_charges'))
                            <span class="text-danger">{{ $errors->first('elactric_charges') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.elactric_charges_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="elactric_charges">Balance</label>
                        <input class="form-control }}" readonly type="text" name="balance" id="balance" value="0">
                        @if($errors->has('elactric_charges'))
                            <span class="text-danger"></span>
                        @endif
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile_2">{{ trans('cruds.holeBooking.fields.mobile_2') }}</label>
                        <input class="form-control {{ $errors->has('mobile_2') ? 'is-invalid' : '' }}" type="text" name="mobile_2" id="mobile_2" value="{{ old('mobile_2', '') }}">
                        @if($errors->has('mobile_2'))
                            <span class="text-danger">{{ $errors->first('mobile_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.mobile_2_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="address_line_2">{{ trans('cruds.holeBooking.fields.address_line_2') }}</label>
                        <textarea class="form-control {{ $errors->has('address_line_2') ? 'is-invalid' : '' }}" name="address_line_2" id="address_line_2">{{ old('address_line_2') }}</textarea>
                        @if($errors->has('address_line_2'))
                            <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.address_line_2_helper') }}</span>
                    </div>
                    {{-- <div class="form-group">
                        <label for="elactric_charges">{{ trans('cruds.holeBooking.fields.elactric_charges') }}</label>
                        <input class="form-control {{ $errors->has('elactric_charges') ? 'is-invalid' : '' }}" type="text" name="elactric_charges" id="elactric_charges" value="{{ old('elactric_charges', '') }}">
                        @if($errors->has('elactric_charges'))
                            <span class="text-danger">{{ $errors->first('elactric_charges') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.elactric_charges_helper') }}</span>
                    </div> --}}
                    <div class="form-group">
                        <label for="comment">{{ trans('cruds.holeBooking.fields.comment') }}</label>
                        <input class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" type="text" name="comment" id="comment" value="{{ old('comment', '') }}">
                        @if($errors->has('comment'))
                            <span class="text-danger">{{ $errors->first('comment') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.comment_helper') }}</span>
                    </div>
                    {{-- <div class="form-group">
                        <div class="form-check {{ $errors->has('am') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="am" value="0">
                            <input class="form-check-input" type="checkbox" name="am" id="am" value="1" {{ old('am', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="am">{{ trans('cruds.holeBooking.fields.am') }}</label>
                        </div>
                        @if($errors->has('am'))
                            <span class="text-danger">{{ $errors->first('am') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.am_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('pm') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="pm" value="0">
                            <input class="form-check-input" type="checkbox" name="pm" id="pm" value="1" {{ old('pm', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="pm">{{ trans('cruds.holeBooking.fields.pm') }}</label>
                        </div>
                        @if($errors->has('pm'))
                            <span class="text-danger">{{ $errors->first('pm') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.pm_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('ad') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="ad" value="0">
                            <input class="form-check-input" type="checkbox" name="ad" id="ad" value="1" {{ old('ad', 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="ad">{{ trans('cruds.holeBooking.fields.ad') }}</label>
                        </div>
                        @if($errors->has('ad'))
                            <span class="text-danger">{{ $errors->first('ad') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.holeBooking.fields.ad_helper') }}</span>
                    </div> --}}
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
        
    </div>
</div>



@endsection

@section('scripts')
<script>
 // Function to parse query string and extract parameters
 function getQueryStringParams() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let values = urlParams.get('values');
    values = decodeURIComponent(values); // Decode URL parameter
    console.log(values);
    values = atob(values).replace(/"/g, ''); // Decode Base64
    console.log(values);
    $("#booking_details").val(values)
    return values ? values.split(',') : [];
}


// Function to update the table with booking details
function updateBookingDetails(bookingDetails) {
    const tableBody = document.getElementById('bookingDetailsBody');
    tableBody.innerHTML = ''; // Clear existing rows

    // Iterate over booking details and add rows to the table
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
function calculateBalance() {
    console.log("dd")
    var totalAmount = parseFloat(document.getElementById('total_amount').value);
    var electricCharges = parseFloat(document.getElementById('elactric_charges').value);
    var advance = parseFloat(document.getElementById('advance').value);
    
    // Check if any of the values are NaN, and if so, set them to zero
    if (isNaN(totalAmount)) {
        totalAmount = 0;
    }
    if (isNaN(electricCharges)) {
        electricCharges = 0;
    }
    if (isNaN(advance)) {
        advance = 0;
    }
    
    var balance = totalAmount + electricCharges - advance;
    
    document.getElementById('balance').value = balance.toFixed(2);
}
    </script>
@endsection