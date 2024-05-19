@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.bookingPayment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.booking-payments.update", [$bookingPayment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.bookingPayment.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $bookingPayment->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bookingPayment.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.bookingPayment.fields.amount_type') }}</label>
                <select class="form-control {{ $errors->has('amount_type') ? 'is-invalid' : '' }}" name="amount_type" id="amount_type">
                    <option value disabled {{ old('amount_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BookingPayment::AMOUNT_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('amount_type', $bookingPayment->amount_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('amount_type'))
                    <span class="text-danger">{{ $errors->first('amount_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bookingPayment.fields.amount_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="booking_id">{{ trans('cruds.bookingPayment.fields.booking') }}</label>
                <select class="form-control select2 {{ $errors->has('booking') ? 'is-invalid' : '' }}" name="booking_id" id="booking_id">
                    @foreach($bookings as $id => $entry)
                        <option value="{{ $id }}" {{ (old('booking_id') ? old('booking_id') : $bookingPayment->booking->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('booking'))
                    <span class="text-danger">{{ $errors->first('booking') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bookingPayment.fields.booking_helper') }}</span>
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