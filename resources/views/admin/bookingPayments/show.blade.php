@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.holeBooking.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hole-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                <a class="btn btn-primary" href="{{ route('admin.hole-bookings.downloadPdf', [$holeBooking->id]) }}">
                    {{ trans('global.download_pdf') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.name') }}</th>
                        <td>{{ $holeBooking->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.mobile_1') }}</th>
                        <td>{{ $holeBooking->mobile_1 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.mobile_2') }}</th>
                        <td>{{ $holeBooking->mobile_2 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.address_line_1') }}</th>
                        <td>{{ $holeBooking->address_line_1 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.address_line_2') }}</th>
                        <td>{{ $holeBooking->address_line_2 }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.event_type') }}</th>
                        <td>{{ $holeBooking->event_type }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.total_amount') }}</th>
                        <td>{{ $holeBooking->total_amount }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.discount') }}</th>
                        <td>{{ $holeBooking->discount }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.discount_by') }}</th>
                        <td>{{ $holeBooking->discount_by }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.advance_paid') }}</th>
                        <td>{{ $bookingPayments->first()->amount ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.receipt') }}</th>
                        <td>{{ $bookingPayments->first()->receipt ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.date_1') }}</th>
                        <td>{{ $bookingPayments->first()->date_1 ?? '' }}</td>
                    </tr>
                    @if($bookingPayments->count() > 1)
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.balance_amount') }}</th>
                        <td>{{ $bookingPayments->get(1)->amount ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.receipt_2') }}</th>
                        <td>{{ $bookingPayments->get(1)->receipt ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.date_2') }}</th>
                        <td>{{ $bookingPayments->get(1)->date_2 ?? '' }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.comment') }}</th>
                        <td>{{ $holeBooking->comment }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
