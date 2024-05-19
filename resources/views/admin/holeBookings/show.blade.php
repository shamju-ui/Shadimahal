@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.holeBooking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hole-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.id') }}
                        </th>
                        <td>
                            {{ $holeBooking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.date') }}
                        </th>
                        <td>
                            {{ $holeBooking->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.time_slot') }}
                        </th>
                        <td>
                            {{ App\Models\HoleBooking::TIME_SLOT_SELECT[$holeBooking->time_slot] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.name') }}
                        </th>
                        <td>
                            {{ $holeBooking->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.mobile_1') }}
                        </th>
                        <td>
                            {{ $holeBooking->mobile_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.mobile_2') }}
                        </th>
                        <td>
                            {{ $holeBooking->mobile_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.address_line_1') }}
                        </th>
                        <td>
                            {{ $holeBooking->address_line_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.address_line_2') }}
                        </th>
                        <td>
                            {{ $holeBooking->address_line_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.total_amount') }}
                        </th>
                        <td>
                            {{ $holeBooking->total_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.elactric_charges') }}
                        </th>
                        <td>
                            {{ $holeBooking->elactric_charges }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.comment') }}
                        </th>
                        <td>
                            {{ $holeBooking->comment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.am') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $holeBooking->am ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.pm') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $holeBooking->pm ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holeBooking.fields.ad') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $holeBooking->ad ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hole-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#booking_booking_payments" role="tab" data-toggle="tab">
                {{ trans('cruds.bookingPayment.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="booking_booking_payments">
            @includeIf('admin.holeBookings.relationships.bookingBookingPayments', ['bookingPayments' => $holeBooking->bookingBookingPayments])
        </div>
    </div>
</div>

@endsection