@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Add Course
    </div>

    <div class="card-body">
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Course Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
