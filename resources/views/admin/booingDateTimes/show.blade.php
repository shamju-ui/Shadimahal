@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.booingDateTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.booing-date-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.booingDateTime.fields.id') }}
                        </th>
                        <td>
                            {{ $booingDateTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booingDateTime.fields.booked_date') }}
                        </th>
                        <td>
                            {{ $booingDateTime->booked_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booingDateTime.fields.time_slot') }}
                        </th>
                        <td>
                            {{ $booingDateTime->time_slot }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.booing-date-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection