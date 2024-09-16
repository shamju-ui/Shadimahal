@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        Student Details
    </div>
 
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <!-- Display Student Image -->
                <tr>
                    <th>
                        Student Image
                    </th>
                    <td>
                        @if($student->student_image)
                            <img src="{{ asset('images/students/' . $student->student_image) }}" alt="Student Image" style="max-width: 150px; height: auto;">
                        @else
                            <span>No image available</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        ID
                    </th>
                    <td>
                        {{ $student->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Name
                    </th>
                    <td>
                        {{ $student->student_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Student ID
                    </th>
                    <td>
                        {{ $student->student_id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Student Mobile
                    </th>
                    <td>
                        {{ $student->student_mobile }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Guardian Name
                    </th>
                    <td>
                        {{ $student->guardian_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Guardian ID
                    </th>
                    <td>
                        {{ $student->guardian_id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Guardian Mobile
                    </th>
                    <td>
                        {{ $student->guardian_mobile }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Address Line 1
                    </th>
                    <td>
                        {{ $student->address_line_1 }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Address Line 2
                    </th>
                    <td>
                        {{ $student->address_line_2 }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Educational Institution
                    </th>
                    <td>
                        {{ $student->educational_institution }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Institution Mobile
                    </th>
                    <td>
                        {{ $student->institution_mobile }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Course
                    </th>
                    <td>
                        {{ $student->course->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Stream
                    </th>
                    <td>
                        {{ $student->stream->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Standard
                    </th>
                    <td>
                        {{ $student->current_grade }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Total Fees
                    </th>
                    <td>
                        {{ $student->total_fees }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Allocated Fees
                    </th>
                    <td>
                        {{ $student->allocated_fees }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="card mt-4">
                <div class="card-header">
                    Fee Payments
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Standard</th>
                                <th>Fee Amount</th>
                                <th>Term</th>
                                <th>Date</th>
                                <th>Receipt #</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody id="fee-payments-table">
                            @foreach($student->feePayment as $payment)
                            <tr>
                                <td>
                                    <input type="text" name="grade[]" class="form-control" value="{{ $payment->grade }}" readonly>
                                    <input type="hidden" name="payment_id[]" value="{{ $payment->id }}">
                                </td>
                                <td><input type="number" name="fee_amount[]" class="form-control" value="{{ $payment->fee_amount }}" readonly></td>
                                <td><input type="number" name="term[]" class="form-control" value="{{ $payment->term }}" readonly></td>
                                <td><input type="date" name="date[]" class="form-control" value="{{ $payment->date }}" readonly></td>
                                <td><input type="text" name="receipt_number[]" class="form-control" value="{{ $payment->receipt_number }}" readonly></td>
                                <!-- <td><button type="button" class="btn btn-danger remove-payment-row">Remove</button></td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
