@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Add Stream
    </div>

    <div class="card-body">
        <form action="{{ route('admin.streams.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Stream Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="course_id">Course</label>
                <select name="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $stream->course_id ?? '') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <span class="text-danger">{{ $errors->first('course_id') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('admin.streams.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
