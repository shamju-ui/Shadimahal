@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.holeBooking.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hall-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                {{-- <a class="btn btn-primary" href="{{ route('admin.hole-bookings.downloadPdf', [$holeBooking->id]) }}">
                    {{ trans('global.download_pdf') }}
                </a> --}}
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 200px;">{{ trans('cruds.holeBooking.fields.name') }}</th>
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
                        <th>Booked Date</th>
                        <td>{{  $holeBooking->booked_dates??"" }}</td>
                    </tr>
                    <tr>
                        <th>Event type</th>
                        <td>{{ $holeBooking->event_type }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.total_amount') }}</th>
                        <td>{{ $holeBooking->total_amount }}</td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td>{{ $holeBooking->discount }}</td>
                    </tr>
                    <tr>
                        <th>Discount By</th>
                        <td>{{ $holeBooking->discount_by }}</td>
                    </tr>
                    <tr>
                        <th>Advance Paid</th>
                        <td>{{ $bookingPayments->first()->amount ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Adavnce receipt</th>
                        <td>{{ $bookingPayments->first()->receipt ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Advance Entry Date</th>
                        <td>{{ $bookingPayments->first()->date_1 ?? '' }}</td>
                    </tr>
                    @if($bookingPayments->count() > 1)
                    <tr>
                        <th>Balance Amount</th>
                        <td>{{ $bookingPayments->get(1)->amount ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Balace receipt</th>
                        <td>{{ $bookingPayments->get(1)->receipt ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Balance Entry Date</th>
                        <td>{{ $bookingPayments->get(1)->date_1 ?? '' }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>{{ trans('cruds.holeBooking.fields.comment') }}</th>
                        <td>{{ $holeBooking->comment }}</td>
                    </tr>

                    <tr>
                        <th>Entry Created At</th>
                        <td>{{ $holeBooking->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Entry Updated</th>
                        <td>{{ $holeBooking->updated_at }}</td>
                    </tr>
                    <tr>
                        <th>Payment Updated</th>
                        @foreach ($bookingPayments as $bookingPayment)
                     
                            <td> 1.{{ $bookingPayment->updated_at }}, Amount {{$bookingPayment->amount}}</td><br/>
                    
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
