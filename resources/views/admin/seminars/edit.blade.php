@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Seminars
    </div>

    <div class="card-body">
        <form action="{{ route('admin.seminars.update', $seminar->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="seminar_name">Seminar Name</label>
                <input type="text" name="seminar_name" class="form-control" id="seminar_name" value="{{ old('seminar_name', $seminar->seminar_name) }}">
                @error('seminar_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="seminar_date">Seminar Date</label>
                <input type="date" name="seminar_date" class="form-control" id="seminar_date" value="{{ old('seminar_date', $seminar->seminar_date) }}">
                @error('seminar_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="runner">Runner</label>
                <input type="text" name="runner" class="form-control" id="runner" value="{{ old('runner', $seminar->runner) }}">
                @error('runner')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="courses">Select Courses</label>
                <select name="course_ids[]" id="courses" class=" select2 form-control" multiple>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ in_array($course->id, $seminar->courses->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_ids')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="streams">Select Streams</label>
                <select name="stream_ids[]" id="streams" class=" select2 form-control select2" multiple>
                    @foreach($streams as $stream)
                    <option value="{{ $stream->id }}" {{ in_array($stream->id, $seminar->streams->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $stream->name }}</option>
                @endforeach <!-- Streams will be dynamically loaded here -->
                </select>
                @error('stream_ids')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Update Seminar</button>
        </form>
    </div>
</div>
@endsection





@section('scripts')
<script>
    $(document).ready(function() {
      
        
        // Listen to changes in the course selection
        $('#courses').change(function() {
            loadStreams();
        });
    });


    function loadStreams() {
    
            let courseIds = $('#courses').val();

            if (courseIds) {
                // Make AJAX request to fetch streams based on selected courses
                $.ajax({
                    url: '{{ route('admin.getStreamsForCourses') }}', // Assuming this is your route
                    type: 'POST',
                    data: {
                        course_ids: courseIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Clear the existing streams
                        $('#streams').empty();

                        // Append new stream options
                        response.forEach(function(stream) {
                            $('#streams').append('<option value="' + stream.id + '">' + stream.name + '</option>');
                        });
                    }
                });
            } else {
                // Clear the streams dropdown if no courses are selected
                $('#streams').empty();
            }
        
    }
</script>
@endsection

           







@section('scripts')
<script>
    $(document).ready(function() {
        // Listen to changes in the course selection
        $('#courses').change(function() {
            let courseIds = $(this).val();

            if (courseIds) {
                // Make AJAX request to fetch streams based on selected courses
                $.ajax({
                    url: '{{ route('admin.getStreamsForCourses') }}', // Assuming this is your route
                    type: 'POST',
                    data: {
                        course_ids: courseIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Clear the existing streams
                        $('#streams').empty();

                        // Append new stream options
                        response.forEach(function(stream) {
                            $('#streams').append('<option value="' + stream.id + '">' + stream.name + '</option>');
                        });
                    }
                });
            } else {
                // Clear the streams dropdown if no courses are selected
                $('#streams').empty();
            }
        });
    });
</script>
@endsection


