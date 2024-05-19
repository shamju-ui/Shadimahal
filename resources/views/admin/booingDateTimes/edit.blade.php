@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booingDateTime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.booing-date-times.update", [$booingDateTime->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="booked_date">{{ trans('cruds.booingDateTime.fields.booked_date') }}</label>
                <input class="form-control date {{ $errors->has('booked_date') ? 'is-invalid' : '' }}" type="text" name="booked_date" id="booked_date" value="{{ old('booked_date', $booingDateTime->booked_date) }}">
                @if($errors->has('booked_date'))
                    <span class="text-danger">{{ $errors->first('booked_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booingDateTime.fields.booked_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_slot">{{ trans('cruds.booingDateTime.fields.time_slot') }}</label>
                <input class="form-control {{ $errors->has('time_slot') ? 'is-invalid' : '' }}" type="text" name="time_slot" id="time_slot" value="{{ old('time_slot', $booingDateTime->time_slot) }}">
                @if($errors->has('time_slot'))
                    <span class="text-danger">{{ $errors->first('time_slot') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booingDateTime.fields.time_slot_helper') }}</span>
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