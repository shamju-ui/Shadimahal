@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Stream
    </div>

    <div class="card-body">
        <form action="{{ route('admin.streams.update', $stream->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Stream Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $stream->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="course_id">Course</label>
                <select name="course_id" class="form-control" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $stream->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <span class="text-danger">{{ $errors->first('course_id') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.streams.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
