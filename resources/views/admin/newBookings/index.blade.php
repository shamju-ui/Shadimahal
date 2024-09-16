@extends('layouts.admin')

<style>
    /* Style for the seat checkboxes */
    .seat-checkbox {
        display: none; /* Hide the actual checkboxes */
    }
.green
{
    color:blue;
    margin-left:2px;
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

    .seat-checkbox:disabled + .seat-label {
        background-color: #ff0000; /* Color for unavailable seats */
    }

    .seat-label:hover {
        background-color: #ccc; /* Hover color */
    }
    .red-checkbox {
        background-color: red !important;
        pointer-events: none !important;
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
            @csrf
            <!-- Date Range Selection -->
            <div class="row mb-3">
                <div class="col">
                    <label for="fromDate">From</label>
                    <input class="form-control date" type="text" name="fromDate" id="fromDate" value="">
                </div>
                <div class="col">
                    <label for="toDate">To</label>
                    <input class="form-control date" type="text" name="toDate" id="toDate" value="" min=""max="">
                </div>
                {{-- <div class="col-4">
                    <div class="form-check mt-3 pt-3">
                        <input type="checkbox" class="form-check-input" id="showAvailableDays">
                        <label class="form-check-label" for="showAvailableDays">Show available days only</label>
                    </div>
                </div> --}}
                <div class="col pt-3 mt-3">
                    <button type="button" class="btn btn-primary" onclick="getBookedData()">Search</button>
                </div>
            </div>

            <!-- Table -->
            <table class="table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time Slots</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows with data will be added dynamically by JavaScript -->
                </tbody>
            </table>

            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="goToHoleBookings()">Continue</button>
            </div>
        </div>

        <script>
     
        $('#fromDate').on('blur', function() {
                setToDateBasedOnFromDate();
                generateDates();
                getBookedData();
            });
            function generateDates() {
                const fromDateStr = document.getElementById('fromDate').value;
                const toDateStr = document.getElementById('toDate').value;

                const [fromDay, fromMonth, fromYear] = fromDateStr.split('/');
                const fromDate = new Date(fromYear, fromMonth - 1, fromDay);

                const [toDay, toMonth, toYear] = toDateStr.split('/');
                const toDate = new Date(toYear, toMonth - 1, toDay);

                const tableBody = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = '';

                while (fromDate <= toDate) {
                    const row = tableBody.insertRow();
                    const dateCell = row.insertCell(0);
                    const timeSlotsCell = row.insertCell(1);

                    const formattedDate = formatDateWithWeekday(fromDate);
                    const timeSlots = generateTimeSlots(formattedDate);

                    dateCell.textContent = formattedDate;
                    timeSlotsCell.appendChild(timeSlots);

                    fromDate.setDate(fromDate.getDate() + 1);
                }
                
            }

            function formatDateWithWeekday(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                const weekday = getWeekdayShortName(date);
                return `${day}/${month}/${year} (${weekday})`;
            }

            function generateTimeSlots(formattedDate) {
                const timeSlotsContainer = document.createElement('div');
                const timeSlots = ['AM', 'PM'];

                timeSlots.forEach(slot => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'timeSlots[]';
                    checkbox.value = formattedDate + '-' + slot;
                    checkbox.id = formattedDate.split(' ')[0] + '-' + slot;
                    checkbox.classList.add('seat-checkbox');

                    const label = document.createElement('label');
                    label.classList.add('seat-label');
                    label.htmlFor = formattedDate + '-' + slot;
                    label.textContent = slot;

                    timeSlotsContainer.appendChild(checkbox);
                    timeSlotsContainer.appendChild(label);
                });

                return timeSlotsContainer;
            }

            function getCheckedValues() {
                const checkedCheckboxes = document.querySelectorAll('.seat-checkbox:checked');
                const values = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
                return values;
            }

            function lastDate() {
                const currentDate = new Date();
                const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                const lastDate = lastDayOfMonth.getDate();
                const currentYear = lastDayOfMonth.getFullYear();
                const currentMonth = lastDayOfMonth.getMonth() + 1;

                const lastDateString = `${String(lastDate).padStart(2, '0')}/${String(currentMonth).padStart(2, '0')}/${currentYear}`;
                const firstDateString = `${currentDate.getDate()}/${String(currentMonth).padStart(2, '0')}/${currentYear}`;

                document.getElementById('toDate').value = lastDateString;
           

// Create a new date object in MM/DD/YYYY format
                // const firstDate = new Date(`${month}/${day}/${year}`);
                document.getElementById('fromDate').value = firstDateString;
            }

            function goToHoleBookings() {
                const checkedValues = getCheckedValues();
                console.log(checkedValues)
                const checkedValuesFiltered = checkedValues.filter(value => !checkedBoxValues.includes(value));
                const encryptedValues = encryptValues(checkedValuesFiltered);
                const queryString = 'values=' + encodeURIComponent(encryptedValues);
                window.location.href = '{{ route("admin.hall-bookings.create") }}?' + queryString;
            }

            function getWeekdayShortName(date) {
                const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                const inputDate = new Date(date);
                return weekdays[inputDate.getDay()];
            }

            function encryptValues(values) {
                return btoa(JSON.stringify(values.join(',')));
            }

            var checkedBoxValues = [];
            function getBookedData() {
                checkedBoxValues = [];
                const formattedFromDate = formatDateToYYYYMMDD(document.getElementById('fromDate').value);
                const formattedToDate = formatDateToYYYYMMDD(document.getElementById('toDate').value);

                $.ajax({
                    headers: { 'x-csrf-token': _token },
                    method: 'POST',
                    url: '{{ route("admin.hall-bookings.search") }}',
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
                        if ($(checkboxId).length) {
                            $(checkboxId).prop('checked', true).prop('disabled', true); // Mark as selected and disabled
                        }
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', errorThrown);
                });
            }

            function formatDateToYYYYMMDD(dateString) {
                var parts = dateString.split('/');
                if (parts.length !== 3) {
                    return null;
                }
                var day = parts[0];
                var month = parts[1];
                var year = parts[2];
                return `${year}-${month}-${day}`;
            }

            $(document).ready(function () {
                lastDate();
                generateDates();
            });
        </script>
    </div>
</div>

@endsection
@section('scripts')
<script>
$(document).ready(function () {
    // $('#fromDate').datepicker({
    //     format: 'dd/mm/yyyy',
    //     autoclose: true
    // });
    lastDate(); 
    generateDates();
    getBookedData();
});

function goToHoleBookings()
{
    const checkedCheckboxes = document.querySelectorAll('.seat-checkbox:checked');
    
    // Convert the NodeList to an array, filter out those with 'red-checkbox' class, and map to extract the value
    const checkedValues = Array.from(checkedCheckboxes)
        .filter(checkbox => !checkbox.classList.contains('red-checkbox'))
        .map(checkbox => checkbox.value);
    const checkedValuesFiltered = checkedValues.filter(value => !checkedBoxValues.includes(value));
    if(checkedValuesFiltered.length==0)
    {
        alert("Please select at least one slot");
        return;
    }
    const encryptedValues = encryptValues(checkedValuesFiltered);
    const queryString = 'values=' + encodeURIComponent(encryptedValues);
    window.location.href = '{{ route("admin.hall-bookings.create") }}?' + queryString;
}

function generateDates()
{
    const fromDateStr = document.getElementById('fromDate').value;
    const toDateStr = document.getElementById('toDate').value;

    const [fromDay, fromMonth, fromYear] = fromDateStr.split('/');
    const fromDate = new Date(fromYear, fromMonth - 1, fromDay);

    const [toDay, toMonth, toYear] = toDateStr.split('/');
    const toDate = new Date(toYear, toMonth - 1, toDay);

    const tableBody = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';

    while (fromDate <= toDate) {
        const row = tableBody.insertRow();
        const dateCell = row.insertCell(0);
        const timeSlotsCell = row.insertCell(1);

        const formattedDate = formatDateWithWeekday(fromDate);
        const timeSlots = generateTimeSlots(formattedDate);

        dateCell.innerHTML  = formattedDate;
        timeSlotsCell.appendChild(timeSlots);

        fromDate.setDate(fromDate.getDate() + 1);
    }
}

function formatDateWithWeekday(date)
{
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const weekday = getWeekdayShortName(date);
    return `${day}/${month}/${year} ${(weekday === 'Sat' || weekday === 'Sun') ? `<span class="green">(${weekday})</span>` : `(${weekday})`}`;
}

function generateTimeSlots(formattedDate)
{
    const timeSlotsContainer = document.createElement('div');
    const timeSlots = ['AM', 'PM'];
    
    timeSlots.forEach(slot => {
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'timeSlots[]';
        checkbox.value = formattedDate.split(' ')[0] + '-' + slot;
        checkbox.id = formattedDate.split(' ')[0] + '-' + slot;
        checkbox.classList.add('seat-checkbox');

        const label = document.createElement('label');
        label.classList.add('seat-label');
        label.htmlFor = formattedDate.split(' ')[0] + '-' + slot;
        label.textContent = slot;

        timeSlotsContainer.appendChild(checkbox);
        timeSlotsContainer.appendChild(label);
    });

    return timeSlotsContainer;
}

function getCheckedValues()
{
    const checkedCheckboxes = document.querySelectorAll('.seat-checkbox:checked');
    const values = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
    return values;
}

function getWeekdayShortName(date) {
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const inputDate = new Date(date);
    return weekdays[inputDate.getDay()];
}

function encryptValues(values) {
    return btoa(JSON.stringify(values.join(',')));
}

var checkedBoxValues = [];
function getBookedData() {
        let checkedBoxValues = [];
        const formattedFromDate = formatDateToYYYYMMDD(document.getElementById('fromDate').value);
        const formattedToDate = formatDateToYYYYMMDD(document.getElementById('toDate').value);
         generateDates();

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'POST',
            url: '{{ route("admin.hall-bookings.search") }}',
            data: {
                _method: 'POST', 
                fromDate: formattedFromDate, 
                toDate: formattedToDate
            }
        })
        .done(function(data) {
            for (let i = 0; i < data.length; i++) {
                const item = data[i];
                checkedBoxValues.push(item.booked_date + '-' + item.time_slot);
                const checkboxId = '#' + item.booked_date.replace(/\//g, '\\/') + '-' + item.time_slot;
              
                if ($(checkboxId).length) {
                    $(checkboxId).prop('checked', true).prop('disabled', true).addClass('red-checkbox'); // Mark as selected, disabled, and red
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', errorThrown);
        });
    }


function formatDateToYYYYMMDD(dateString) {
        const [day, month, year] = dateString.split('/');
        return `${year}-${month}-${day}`;
    }

    function setToDateBasedOnFromDate() {
            const fromDateInput = document.getElementById('fromDate');
            const toDateInput = document.getElementById('toDate');
            const fromDateValue = new Date(fromDateInput.value);

        //    if (!isNaN(fromDateValue.getTime())) {
                // Set the minimum value of the "To" date to the selected "From" date
                const minToDate = fromDateInput.value;
                // toDateInput.min = minToDate;
                const [day, month, year] = fromDateInput.value.split('/');
                // Calculate the last day of the month for the selected "From" date
                // const year = fromDateValue.getFullYear();
                // const month = fromDateValue.getMonth() + 1; // JavaScript months are 0-11
                const lastDayOfMonth = new Date(year, month, 0).getDate();

                // Set the maximum value of the "To" date to the last day of the month
                const maxToDate = `${year}-${String(month).padStart(2, '0')}-${String(lastDayOfMonth).padStart(2, '0')}`;
                 console.log(`${lastDayOfMonth}/${String(month).padStart(2, '0')}/${year}`)
                 toDateInput.value =  `${lastDayOfMonth}/${month}/${year}`
                //toDateInput.max = `${lastDayOfMonth}/${month}/${year}`;
           // }
            }

           
            setToDateBasedOnFromDate();
</script>
@endsection