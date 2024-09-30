@extends('layouts.admin')

@section('content')
<div class="card">
    @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    <div class="card-header">
        Seminars
        <a href="{{ route('admin.seminars.create') }}" class="btn btn-primary float-right">Add Seminar</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Seminar Name</th>
                    <th>Date</th>
                    <th>Runner</th>
                    <th>Courses</th>
                    <th>Streams</th>
                    <th>Attendence</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seminars as $seminar)
                    <tr>
                        <td>
                             
                            <a href="{{ route('admin.seminars.edit', $seminar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.seminars.destroy', $seminar->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form></td>
                        <td>{{ $seminar->seminar_name }}</td>
                        <td>{{ $seminar->seminar_date }}</td>
                        <td>{{ $seminar->runner }}</td>
                        <td>
                            @foreach ($seminar->courses as $course)
                                <span class="badge badge-info">{{ $course->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($seminar->streams as $stream)
                                <span class="badge badge-info">{{ $stream->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.get.student.attendance', $seminar->id) }}" class="btn btn-warning btn-sm">Attendence</a> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $seminars->links() }}
    </div>
</div>
@endsection







