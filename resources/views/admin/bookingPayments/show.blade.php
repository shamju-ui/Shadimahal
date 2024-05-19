@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bookingPayment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.booking-payments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.id') }}
                        </th>
                        <td>
                            {{ $bookingPayment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.amount') }}
                        </th>
                        <td>
                            {{ $bookingPayment->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.amount_type') }}
                        </th>
                        <td>
                            {{ App\Models\BookingPayment::AMOUNT_TYPE_SELECT[$bookingPayment->amount_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bookingPayment.fields.booking') }}
                        </th>
                        <td>
                            {{ $bookingPayment->booking->date ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.booking-payments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection