@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Streams
        <a href="{{ route('admin.streams.create') }}" class="btn btn-primary float-right">Add Stream</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($streams as $stream)
                <tr>
                    <td>{{ $stream->id }}</td>
                    <td>{{ $stream->name }}</td>
                    <td>{{ $stream->course->name ?? '' }}</td>
                    <td>
                        <a href="{{ route('admin.streams.edit', $stream->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.streams.destroy', $stream->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
