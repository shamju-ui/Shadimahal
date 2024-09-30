{{-- @extends('layouts.admin')

@section('content')
<div class="card">
    @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    <div class="card-header">
        Attendence Record
       
    </div>
    <div class="card-body">
        <form id="attendance-form">
            @csrf
            <input type="hidden" name="seminar_id" id="seminar_id" value="{{ $seminarId }}">

            <table id="students-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Student Name</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Students will be dynamically loaded here -->
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Save Attendance</button>
        </form>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        // Load students when streams are selected
        $('#streams').change(function() {
            let streamIds = $(this).val();

            if (streamIds) {
                $.ajax({
                    url: '{{ route('get.students.for.attendance') }}',
                    type: 'POST',
                    data: {
                        stream_ids: streamIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#students-table tbody').empty(); // Clear previous students
                        response.forEach(function(student) {
                            $('#students-table tbody').append(
                                '<tr>' +
                                    '<td><input type="checkbox" name="student_ids[]" value="' + student.id + '"></td>' +
                                    '<td>' + student.student_name + '</td>' +
                                '</tr>'
                            );
                        });

                        // Initialize DataTable after loading students
                        $('#students-table').DataTable();
                    }
                });
            } else {
                $('#students-table tbody').empty(); // Clear table if no streams selected
            }
        });

        // Handle form submission
        $('#attendance-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            $.ajax({
                url: '{{ route('save.attendance') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response.success); // Show success message
                },
                error: function(xhr) {
                    alert('Error recording attendance'); // Show error message
                }
            });
        });
    });
</script>
@endsection



 --}}

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


    <!-- Filter Form -->
    {{-- <form  method="GET">
        <div class="row">
            <!-- Filter by Student Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="student_name">Student Name</label>
                    <input type="text" name="student_name" class="form-control" value="{{ request('student_name') }}" placeholder="Enter student name">
                </div>
            </div>

            <!-- Filter by Course -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="course">Course</label>
                    <select name="course" class="form-control">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filter by Stream -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="stream">Stream</label>
                    <select name="stream" class="form-control">
                        <option value="">All Streams</option>
                        @foreach($streams as $stream)
                            <option value="{{ $stream->id }}" {{ request('stream') == $stream->id ? 'selected' : '' }}>
                                {{ $stream->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form> --}}

    <!-- Attendance Table -->
    <form action="{{ route('admin.save.attendance') }}" method="POST" id="attendance-form">
        @csrf
        <input type="hidden" name="seminar_id" value="{{ $seminarId }}">
        <table id="attendance-table" class="table table-bordered table-striped">
            <thead>
                <tr>
              
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Stream</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($streams as $stream)
                    @foreach($stream->students as $student)
                    <tr>
                      
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->course->name ?? 'N/A' }}</td>
                        <td>{{ $stream->name }}</td>
                        <td>
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="attendance-checkbox" 
                            {{ in_array($student->id, $existingAttendances) ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Save Attendance</button>
    </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#attendance-table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
    });

    $('#attendance-form').submit(function(event) {
        var checked = $('.attendance-checkbox:checked').length;
        if (checked === 0) {
            event.preventDefault();
            alert('Please select at least one student for attendance.');
        }
    });
});
</script>
@endsection
