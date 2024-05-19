@extends('layouts.admin')

<style>
    /* Style for the seat checkboxes */
    .seat-checkbox {
        display: none; /* Hide the actual checkboxes */
    }

    .seat-label {
        display: inline-block;
        width: 40px; /* Adjust as needed */
        height: 40px; /* Adjust as needed */
        background-color: #eee;
        border: 1px solid #ccc;
        margin: 5px;
        cursor: pointer;
        text-align: center;
        line-height: 40px;
    }

    .seat-checkbox:checked + .seat-label {
        background-color: #00ff00; /* Change color when checked */
    }
</style>

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.newBooking.title') }}
    </div>

    <div class="card-body">
        <div class="container">
            <h2>New Bookings</h2>
            <!-- Date Range Selection -->
            <div class="row mb-3">
                <div class="col">
                    <label for="fromDate">From</label>
                    <input class="form-control date" type="text" name="fromDate" id="fromDate" value="">
                    {{-- <input type="date" id="fromDate" class="form-control" value="2024-01-01"> --}}
                </div>
                <div class="col">
                    <label for="toDate">To</label>
                    <input class="form-control date" type="text" name="toDate" id="toDate" value="">
                    {{-- <input type="date" id="toDate" class="form-control" value="2024-01-16"> --}}
                </div>
                <div class="col-4">
                    <div class="form-check mt-3 pt-3">
                        <input type="checkbox" class="form-check-input" id="showAvailableDays">
                        <label class="form-check-label" for="showAvailableDays">Show available days only</label>
                    </div>
                </div>
                <div class="col pt-3 mt-3">


                    <button type="button" class="btn btn-primary" onclick="generateDates()">Search</button>


                </div>
            </div>
            <!-- Search Button -->
            {{-- <div class="mb-3">
              <button type="button" class="btn btn-primary" onclick="generateDates()">Search</button>
            </div> --}}
            <!-- Table -->
            <table class="table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time Slots

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows with data will be added dynamically by JavaScript -->
                </tbody>
            </table>
            <!-- Restrict Search -->
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="goToHoleBookings()">Search</button>
              {{-- <label for="restrictSearch">Restrict search to a month</label>
              <input type="month" id="restrictSearch" class="form-control"> --}}
            </div>
        </div>

        <script>
            // function generateDates() {
            //     const fromDate = new Date(document.getElementById('fromDate').value);
            //     const toDate = new Date(document.getElementById('toDate').value);
            //     const tableBody = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0];
            //     tableBody.innerHTML = '';

            //     while (fromDate <= toDate) {
            //         const row = tableBody.insertRow();
            //         const dateCell = row.insertCell(0);
            //         const timeSlotsCell = row.insertCell(1);

            //         const formattedDate = formatDate(fromDate);
            //         const timeSlots = generateTimeSlots(formattedDate);

            //         dateCell.textContent = formattedDate;
            //         timeSlotsCell.appendChild(timeSlots); // Append generated checkboxes to cell

            //         fromDate.setDate(fromDate.getDate() + 1);
            //     }
            // }
            function generateDates() {
    const fromDateStr = document.getElementById('fromDate').value;
    const toDateStr = document.getElementById('toDate').value;

    // Parse the fromDate string into day, month, and year
    const [fromDay, fromMonth, fromYear] = fromDateStr.split('/');
    const fromDate = new Date(fromYear, fromMonth - 1, fromDay); // Month is zero-based

    // Parse the toDate string into day, month, and year
    const [toDay, toMonth, toYear] = toDateStr.split('/');
    const toDate = new Date(toYear, toMonth - 1, toDay); // Month is zero-based

    const tableBody = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';

    while (fromDate <= toDate) {
        const row = tableBody.insertRow();
        const dateCell = row.insertCell(0);
        const timeSlotsCell = row.insertCell(1);

        const formattedDate = formatDate(fromDate);
        const timeSlots = generateTimeSlots(formattedDate);

        dateCell.textContent = formattedDate;
        timeSlotsCell.appendChild(timeSlots); // Append generated checkboxes to cell

        fromDate.setDate(fromDate.getDate() + 1);
    }
}

            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            function generateTimeSlots(formattedDate) {
                const timeSlotsContainer = document.createElement('div');

                const timeSlots = ['AM', 'PM', 'AD'];

                timeSlots.forEach(slot => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'timeSlots[]';
                    checkbox.value = formattedDate + '-' + slot;
                    checkbox.id = formattedDate + '-' + slot;
                    checkbox.classList.add('time-slot');
                    checkbox.classList.add('seat-label');
                    const label = document.createElement('label');
                    label.textContent = slot;

                    timeSlotsContainer.appendChild(checkbox);
                    timeSlotsContainer.appendChild(label);
                    timeSlotsContainer.appendChild(document.createElement('sp'));
                });

                return timeSlotsContainer;
            }

           
            function lastDate() {
                var currentDate = new Date();
                var lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                var lastDate = lastDayOfMonth.getDate();
                var currentYear = lastDayOfMonth.getFullYear();
                var currentMonth = lastDayOfMonth.getMonth() + 1;
                // var lastDateString = currentYear + '-' + currentMonth + '-' + lastDate;
                // var firstDateString = currentYear + '-' + currentMonth + '-' + '01';

                var lastDateString = lastDate + '/' + currentMonth + '/' + currentYear;
var firstDateString = '01/' + currentMonth + '/' + currentYear;
                $("#toDate").val(lastDateString);
                $("#fromDate").val(firstDateString);
                getBookedData();
            }
            function getCheckedValues() {
                const checkedCheckboxes = document.querySelectorAll('.time-slot:checked'); // Select checked checkboxes with class 'time-slot'
                const values = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
                return values;
            }
            // function goToHoleBookings() {
            //     const checkedValues = getCheckedValues();   
            // }
        </script>
    </div>
</div>

@endsection
@section('scripts')
<script>
$(document).ready(function () {
    lastDate(); // Call the function to set fromDate and toDate
    generateDates();

});

function goToHoleBookings()
{
    const checkedValues = getCheckedValues();
    const checkedValuesFiltered = checkedValues.filter(value => !checkedBoxValues.includes(value));
    const encryptedValues = encryptValues(checkedValuesFiltered);
    const queryString = 'values=' + encodeURIComponent(encryptedValues);
    window.location.href = '{{ route("admin.hole-bookings.create") }}?' + queryString;

}
function getCheckedValues() {
    const checkedCheckboxes = document.querySelectorAll('.time-slot:checked'); // Select checked checkboxes with class 'time-slot'
    const values = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
    return values;
}
function getWeekdays(date) {
    const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const inputDate = new Date(date);
    const dayIndex = inputDate.getDay(); // Get the day index (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
    const weekday = weekdays[dayIndex]; // Get the weekday name using the day index
    return weekday;
}

// Function to encrypt values (replace with your encryption method)
function encryptValues(values) {
    // Example: convert values to JSON string and encode it
    return btoa(JSON.stringify(values.join(',')));
}
var checkedBoxValues = [];
function getBookedData() {
    checkedBoxValues = []
    const formattedFromDate = formatDateToYYYYMMDD(document.getElementById('fromDate').value);
    const formattedToDate = formatDateToYYYYMMDD(document.getElementById('toDate').value);

    $.ajax({
    headers: { 'x-csrf-token': _token },
    method: 'POST',
    url:  '{{ route("admin.hole-bookings.search") }}',
    data: {
        _method: 'POST', 
        fromDate: formattedFromDate, 
        toDate: formattedToDate
    }
})
.done(function(data) {
    for (var i = 0; i < data.length; i++) {
    var item = data[i];
    checkedBoxValues.push(item.booked_date + '-' + item.time_slot);
    const checkboxId = '#' + item.booked_date.replace(/\//g, '\\/') + '-' + item.time_slot;
    // Check if the item's booked_date and time_slot match the checkbox value
    if ($(checkboxId).length) {
        // If there's a match, mark the checkbox as selected
        $(checkboxId).prop('checked', true);
    }
}


    // Example: Log the response to the console
})
.fail(function(jqXHR, textStatus, errorThrown) {
    // Handle any errors that occur during the AJAX request
    console.error('AJAX Error:', errorThrown);
});;
    }
    
function formatDateToYYYYMMDD(dateString) {
    // Split the date string into day, month, and year components
    var parts = dateString.split('/');
    
    // Ensure that we have exactly three parts (day, month, and year)
    if (parts.length !== 3) {
        return null; // Return null if the input format is invalid
    }

    var day = parts[0];
    var month = parts[1];
    var year = parts[2];
    var formattedDate = year + '-' + month + '-' + day;
    return formattedDate;
} 

</script>
@endsection