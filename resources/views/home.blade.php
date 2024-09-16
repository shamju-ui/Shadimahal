{{-- @extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Report
    </div>

    <div class="card-body">
        <form id="reportForm">
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="year">Select Year</label>
                        <select name="year" id="year" class="form-control">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4" style="align-content: end;">
                        <label for="year"></label>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div id="reportContent">
            <!-- Report data will be inserted here -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('#reportForm').on('submit', function(e) {
            e.preventDefault();
            var year = $('#year').val();
            $.ajax({
                url: '{{ route('admin.reports.data') }}',
                type: 'GET',
                data: { year: year },
                success: function(response) {
                    $('#reportContent').html(`
                        <div class="row">
                            <div class="col-6">
                                <h3>Current Year (${year})</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Booking Data</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Total Discount</th>
                                            <th>Amount Received</th>
                                            <th>Outstanding</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Bookings</td>
                                            <td>${response.totalCount}</td>
                                            <td>${response.totalAmount.toFixed(2)}</td>
                                            <td>${response.totalDiscount.toFixed(2)}</td>
                                            <td>${response.totalReceived.toFixed(2)}</td>
                                            <td>${response.totalOutstanding.toFixed(2)-response.totalDiscount.toFixed(2)}</td>
                                        </tr>
                                        <tr>
                                            <td>AM</td>
                                            <td>${response.amCount}</td>
                                            <td>${response.amTotal.toFixed(2)}</td>
                                            <td>${response.amDiscount}</td>
                                            <td>${response.amReceived.toFixed(2)}</td>
                                            <td>${(response.amTotal - response.amReceived-response.amDiscount).toFixed(2)}</td>
                                        </tr>
                                        <tr>
                                            <td>PM</td>
                                            <td>${response.pmCount}</td>
                                            <td>${response.pmTotal.toFixed(2)}</td>
                                            <td>${response.pmDiscount}</td>
                                            <td>${response.pmReceived.toFixed(2)}</td>
                                            <td>${(response.pmTotal - response.pmReceived-response.pmDiscount).toFixed(2)}</td>
                                        </tr>
                                      
                                        <tr>
                                            <td>Canceled</td>
                                            <td>${response.canceledCount}</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>${response.canceledAmount}</td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <h3>Booking By Month (${year})</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Received</th>
                                            <th>Outstanding</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${response.bookingsByMonth.map(month => `
                                            <tr>
                                                <td>${new Date(0, month.month - 1).toLocaleString('default', { month: 'long' })}</td>
                                                <td>${month.count}</td>
                                                <td>${response.bookingsByMonthAmount[month.month]?.total_amount.toFixed(2) || 0}</td>
                                                <td>${response.bookingsByMonthReceived[month.month]?.total_amount.toFixed(2) || 0}</td>
                                                <td>${(response.bookingsByMonthAmount[month.month]?.total_amount || 0 - (response.bookingsByMonthReceived[month.month]?.total_amount || 0)).toFixed(2)}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `);
                }
            });
        });

        // Trigger the initial load
        $('#reportForm').submit();
    });
</script>
@endsection --}}

@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Report
    </div>

    <div class="card-body">
        <form id="reportForm">
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="year">Select Year</label>
                        <select name="year" id="year" class="form-control">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4" style="align-content: end;">
                        <label for="year"></label>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div id="reportContent">
            <!-- Report data will be inserted here -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
  

$(document).ready(function() {
    const currentYear = new Date().getFullYear();
    $('#year').val(currentYear).change();
    $('#reportForm').on('submit', function(e) {
        e.preventDefault();
        var year = $('#year').val();
        $.ajax({
            url: '{{ route('admin.reports.data') }}',
            type: 'GET',
            data: { year: year },
            success: function(response) {
                // Debugging: Log the response
                console.log(response);

                // Check and convert values to numbers if necessary
                let refund = parseFloat(response.cancellations.refund);
                let retained = parseFloat(response.cancellations.retained);

                // If parsing fails, set default values
                if (isNaN(refund)) refund = 0;
                if (isNaN(retained)) retained = 0;

                $('#reportContent').html(`
                    <div class="row">
                        <div class="col-6">
                            <h3>Current Year (${year})</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Booking Data</th>
                                        <th>Count</th>
                                        <th>Booking Amount</th>
                                        <th>Discount</th>
                                        <th>Amount Received</th>
                                        <th>Outstanding</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Bookings</td>
                                        <td>${response.totalBookings.count}</td>
                                        <td>${response.totalBookings.amount}</td>
                                        <td>${response.totalBookings.discount}</td>
                                        <td>${response.totalBookings.received}</td>
                                        <td>${response.totalBookings.outstanding  - response.totalBookings.discount }</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3>Cancellations</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Count</th>
                                        <th>Total Refund</th>
                                        <th>Amount Retained</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${response.cancellations.count}</td>
                                        <td>${retained}</td>
                                        <td>${refund}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3>Monthly Revenue (${year})</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total Received</th>
                                        <th>Refund Processed</th>
                                        <th>Net Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${Object.keys(response.monthlyRevenue).map(month => `
                                        <tr>
                                            <td>${new Date(0, month - 1).toLocaleString('default', { month: 'long' })}</td>
                                            <td>${response.monthlyRevenue[month].total_received}</td>
                                            <td>${response.refundProcessed[month]?.refund_processed || 0}</td>
                                            <td>${(response.monthlyRevenue[month].total_received - (response.refundProcessed[month]?.refund_processed || 0))}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            
                        </div>
                    </div>
                `);
            }
        });
    });

    // Trigger the initial load
    $('#reportForm').submit();
});
</script>
@endsection
