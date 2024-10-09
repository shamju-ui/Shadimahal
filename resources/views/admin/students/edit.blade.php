@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        Student Registration
    </div>

    <div class="card-body">
        <form action="{{ route('admin.students.update', [$student->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                 <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Student Name -->
                    <div class="form-group row">
                        <label for="student_name" class="col-md-4 col-form-label">Student Name</label>
                        <div class="col-md-8">
                            <input type="text" name="student_name" id="student_name" class="form-control {{ $errors->has('student_name') ? 'is-invalid' : '' }}" value="{{ old('student_name', $student->student_name) }}" required>
                            @if($errors->has('student_name'))
                                <span class="text-danger">{{ $errors->first('student_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Student ID -->
                    <div class="form-group row">
                        <label for="student_id" class="col-md-4 col-form-label">Student ID</label>
                        <div class="col-md-8">
                            <input type="text" name="student_id" id="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" value="{{ old('student_id', $student->student_id) }}" required maxlength="12">
                            @if($errors->has('student_id'))
                                <span class="text-danger">{{ $errors->first('student_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Student Mobile -->
                    <div class="form-group row">
                        <label for="student_mobile" class="col-md-4 col-form-label">Student Mobile</label>
                        <div class="col-md-8">
                        <input type="text" name="student_mobile" id="student_mobile" class="form-control {{ $errors->has('student_mobile') ? 'is-invalid' : '' }}" value="{{ old('student_mobile', $student->student_mobile) }}" >
                        @if($errors->has('student_mobile'))
                            <span class="text-danger">{{ $errors->first('student_mobile') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Guardian Name -->
                    <div class="form-group row">
                        <label for="guardian_name" class="col-md-4 col-form-label">Guardian Name</label>
                        <div class="col-md-8">
                        <input type="text" name="guardian_name" id="guardian_name" class="form-control {{ $errors->has('guardian_name') ? 'is-invalid' : '' }}" value="{{ old('guardian_name', $student->guardian_name) }}" required>
                        @if($errors->has('guardian_name'))
                            <span class="text-danger">{{ $errors->first('guardian_name') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Guardian ID -->
                    <div class="form-group row">
                        <label for="guardian_id" class="col-md-4 col-form-label">Guardian ID</label>
                        <div class="col-md-8">
                        <input type="text" name="guardian_id" id="guardian_id" class="form-control {{ $errors->has('guardian_id') ? 'is-invalid' : '' }}" value="{{ old('guardian_id', $student->guardian_id) }}" required maxlength="12">
                        @if($errors->has('guardian_id'))
                            <span class="text-danger">{{ $errors->first('guardian_id') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Guardian Mobile -->
                    <div class="form-group row">
                        <label for="guardian_mobile" class="col-md-4 col-form-label">Guardian Mobile</label>
                        <div class="col-md-8">
                        <input type="text" name="guardian_mobile" id="guardian_mobile" class="form-control {{ $errors->has('guardian_mobile') ? 'is-invalid' : '' }}" value="{{ old('guardian_mobile', $student->guardian_mobile) }}" required maxlength="10" minlength="10">
                        @if($errors->has('guardian_mobile'))
                            <span class="text-danger">{{ $errors->first('guardian_mobile') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Address Line 1 -->
                    <div class="form-group row">
                        <label for="address_line_1" class="col-md-4 col-form-label">Address Line 1</label>
                        <div class="col-md-8">
                        <input type="text" name="address_line_1" id="address_line_1" class="form-control {{ $errors->has('address_line_1') ? 'is-invalid' : '' }}" value="{{ old('address_line_1', $student->address_line_1) }}">
                        @if($errors->has('address_line_1'))
                            <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Address Line 2 -->
                    <div class="form-group row">
                        <label for="address_line_2" class="col-md-4 col-form-label">Address Line 2</label>
                        <div class="col-md-8">
                        <input type="text" name="address_line_2" id="address_line_2" class="form-control {{ $errors->has('address_line_2') ? 'is-invalid' : '' }}" value="{{ old('address_line_2', $student->address_line_2) }}">
                        @if($errors->has('address_line_2'))
                            <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Educational Institution -->
                    <div class="form-group row">
                        <label for="educational_institution" class="col-md-4 col-form-label">Educational Institution</label>
                        <div class="col-md-8">
                        <input type="text" name="educational_institution" id="educational_institution" class="form-control {{ $errors->has('educational_institution') ? 'is-invalid' : '' }}" value="{{ old('educational_institution', $student->educational_institution) }}">
                        @if($errors->has('educational_institution'))
                            <span class="text-danger">{{ $errors->first('educational_institution') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Institution Mobile -->
                    <div class="form-group row">
                        <label for="institution_mobile" class="col-md-4 col-form-label">Institution Mobile</label>
                        <div class="col-md-8">
                        <input type="text" name="institution_mobile" id="institution_mobile" class="form-control {{ $errors->has('institution_mobile') ? 'is-invalid' : '' }}" value="{{ old('institution_mobile', $student->institution_mobile) }}">
                        @if($errors->has('institution_mobile'))
                            <span class="text-danger">{{ $errors->first('institution_mobile') }}</span>
                        @endif
                        </div>
                    </div>

                    

                    <!-- Course -->
                    <div class="form-group row">
                        <label for="course_id" class="col-md-4 col-form-label">Course</label>
                        <div class="col-md-8">
                            <select name="course_id" id="course_id" class="form-control {{ $errors->has('course_id') ? 'is-invalid' : '' }}">
                                <option value="">Select Course</option>
                                @foreach($courses as $id => $course)
                                    <option value="{{ $id }}" {{ (old('course_id', $student->course_id) == $id) ? 'selected' : '' }}>{{ $course }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('course_id'))
                                <span class="text-danger">{{ $errors->first('course_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Stream -->
                    <div class="form-group row">
                        <label for="stream_id" class="col-md-4 col-form-label">Stream</label>
                        <div class="col-md-8">
                            <select name="stream_id" id="stream_id" class="form-control {{ $errors->has('stream_id') ? 'is-invalid' : '' }}">
                                <option value="">Select Stream</option>
                                @foreach($streams as $id => $stream)
                                    <option value="{{ $id }}" {{ (old('stream_id', $student->stream_id) == $id) ? 'selected' : '' }}>{{ $stream }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('stream_id'))
                                <span class="text-danger">{{ $errors->first('stream_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Current Grade -->
                    <div class="form-group row">
                        <label for="current_grade" class="col-md-4 col-form-label">Standard</label>
                        <div class="col-md-8">
                            <select name="current_grade" id="current_grade" class="form-control {{ $errors->has('current_grade') ? 'is-invalid' : '' }}">
                                <option value="">Select Standard</option>
                                <!-- Options will be dynamically populated based on the selected course -->
                            </select>
                            @if($errors->has('current_grade'))
                                <span class="text-danger">{{ $errors->first('current_grade') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Total Fees -->
                    <div class="form-group row">
                        <label for="total_fees" class="col-md-4 col-form-label">Total Fees</label>
                        <div class="col-md-8">
                        <input type="text" name="total_fees" id="total_fees" class="form-control {{ $errors->has('total_fees') ? 'is-invalid' : '' }}" value="{{ old('total_fees', $student->total_fees) }}">
                        @if($errors->has('total_fees'))
                            <span class="text-danger">{{ $errors->first('total_fees') }}</span>
                        @endif
                        </div>
                    </div>

                    <!-- Allocated Fees -->
                    <div class="form-group row">
                        <label for="allocated_fees" class="col-md-4 col-form-label">Allocated Fees</label>
                        <div class="col-md-8">
                        <input type="text" name="allocated_fees" id="allocated_fees" class="form-control {{ $errors->has('allocated_fees') ? 'is-invalid' : '' }}" value="{{ old('allocated_fees', $student->allocated_fees) }}">
                        @if($errors->has('allocated_fees'))
                            <span class="text-danger">{{ $errors->first('allocated_fees') }}</span>
                        @endif
                        </div>
                    </div>
                </div>
                

                <!-- Right Column: Image Upload -->
                <div class="col-md-6">
                    <div class="form-group" style="display: grid; justify-content: center;">
                        <!-- Show the uploaded image if it exists (Preview Above the Input) -->
                        @if(isset($student) && $student->student_image)
                            <div class="mb-3">
                                <img id="image_preview" src="{{ asset('images/students/' . $student->student_image) }}" alt="Student Image" style="max-width: 200px; height: 200px;">
                            </div>
                        @else
                            <!-- Placeholder for live preview -->
                            <div class="border p-2" style="width: 200px; height: 200px;">
                                <img id="image_preview" style="max-height: 180px; max-width: 100%; display: none;">
                            </div>
                        @endif

                        <!-- Image Input Field -->
                        <input type="file" name="student_image" id="student_image" class="form-control-file mt-2 {{ $errors->has('student_image') ? 'is-invalid' : '' }}" onchange="previewImage(event)" accept="image/*">

                        <!-- Display validation error for image -->
                        @if($errors->has('student_image'))
                            <span class="text-danger">{{ $errors->first('student_image') }}</span>
                        @endif
                    </div>
                </div>
                
            </div>

            <!-- Payments Section -->
            <div class="card mt-4">
                <div class="card-header">
                    Fee Payments
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Standard</th>
                                <th>Fee Amount</th>
                                <th>Term</th>
                                <th>Date</th>
                                <th>Receipt #</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody id="fee-payments-table">
                            @foreach($student->feePayment as $payment)
                            <tr>
                                <td>
                                    <input type="text" name="grade[]" class="form-control" value="{{ $payment->grade }}" required>
                                    <input type="hidden" name="payment_id[]" value="{{ $payment->id }}">
                                </td>
                                <td><input type="number" name="fee_amount[]" class="form-control" value="{{ $payment->fee_amount }}" required></td>
                                <td><input type="number" name="term[]" class="form-control" value="{{ $payment->term }}" required></td>
                                <td><input type="date" name="date[]" class="form-control" value="{{ $payment->date }}" required></td>
                                <td><input type="text" name="receipt_number[]" class="form-control" value="{{ $payment->receipt_number }}" required></td>
                                <!-- <td><button type="button" class="btn btn-danger remove-payment-row">Remove</button></td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-2" id="add-payment-row">Add Payment</button>
                </div>
            </div>

            <!-- Mark List Section -->
            <div class="card mt-4">
                <div class="card-header">
                    Mark List
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>standard</th>
                                <th>Term</th>
                                <th>Grade/Percentage</th>
                                <th>Year</th>
                                <th>Comments</th>
                                <th>Mark List File</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody id="mark-list-table">
                            <!-- @foreach($student->markList as $mark)
                            <tr>
                                <td><input type="text" name="marklist_class_name[]" class="form-control" value="{{ $mark->class_name }}" required></td>
                                <td><input type="number" name="marklist_term[]" class="form-control" value="{{ $mark->term }}" required></td>
                                <td><input type="text" name="marklist_grade[]" class="form-control" value="{{ $mark->grade }}" required></td>
                                <td><input type="date" name="marklist_date[]" class="form-control" value="{{ $mark->date }}" required></td>
                                <td><input type="text" name="marklist_comments[]" class="form-control" value="{{ $mark->comments }}" required></td>
                                <td>
                                    @if($mark->marklist_file)
                                        <a href="{{ asset('files/marklists/' . $mark->marklist_file) }}" target="_blank">View</a>
                                    @endif
                                    <input type="file" name="marklist_file[]" class="form-control-file mt-2">
                                </td>
                                <td><button type="button" class="btn btn-danger remove-marklist-row">Remove</button></td>
                            </tr>
                            @endforeach -->

                            @foreach($student->markList as $mark)
                            <tr>
                                <td>
                                    <input type="text" name="marklist_class_name[]" class="form-control" value="{{ $mark->class_name }}" required>
                                    <input type="hidden" name="marklist_id[]" value="{{ $mark->id }}">
                                </td>
                                <td><input type="number" name="marklist_term[]" class="form-control" value="{{ $mark->term }}" required></td>
                                <td><input type="text" name="marklist_grade[]" class="form-control" value="{{ $mark->grade }}" required></td>
                                <td><input type="text" name="marklist_date[]" class="form-control" value="{{ $mark->date }}" required></td>
                                <td><input type="text" name="marklist_comments[]" class="form-control" value="{{ $mark->comments }}" required></td>
                                <td>
                                    @if($mark->marklist_file)
                                        <a href="{{ asset('files/marklists/' . $mark->marklist_file) }}" target="_blank">View</a>
                                    @endif
                                    <input type="file" name="marklist_file[]" class="form-control-file mt-2">
                                </td>
                                <!-- <td><button type="button" class="btn btn-danger remove-marklist-row">Remove</button></td> -->
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-2" id="add-marklist-row">Add Mark List</button>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    Seminar List
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Seminar</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData as $data)
                                <tr>
                                    <td>{{ $data['seminar'] }}</td>
                                    <td>{{ $data['date'] }}</td>
                                    <td>{{ $data['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- Save Button -->
            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
    }

    .form-group.row {
        margin-bottom: 1rem !important; 
    }

    .form-control {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        font-size: 1rem;
        transition: box-shadow 0.2s;
    }

    .form-control:focus {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .btn {
        border-radius: 8px;
        transition: background-color 0.2s, transform 0.2s;
    }

    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.02);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    /* Additional spacing between rows */
    .form-group.row {
        margin-bottom: 1.2rem;
    }

    .card-header {
        background-color: #007bff;
        color: #fff;
        padding: 1rem;
        font-size: 1.25rem;
    }

    #imagePreview {
        border: 2px solid #007bff;
    }

    input[type="file"] {
        margin-top: 10px;
    }

    label {
        font-weight: 500 !important;
        font-size: 1rem;
    }
</style>
@endsection

@section('scripts')

<script>
   function previewImage(event) {

    const image = document.getElementById('image_preview');
    if (event.target.files[0]) {
        image.style.display = 'block'; // Show the image tag
        image.src = URL.createObjectURL(event.target.files[0]); // Set the src to the selected image
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const addPaymentRowBtn = document.getElementById('add-payment-row');
    const feePaymentsTable = document.getElementById('fee-payments-table');

    addPaymentRowBtn.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="grade[]" class="form-control" required></td>
            <td><input type="number" name="fee_amount[]" class="form-control" required></td>
            <td><input type="number" name="term[]" class="form-control" required></td>
            <td><input type="date" name="date[]" class="form-control" required></td>
            <td><input type="text" name="receipt_number[]" class="form-control" required></td>
            
        `;
        feePaymentsTable.appendChild(newRow);
    });

    feePaymentsTable.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-payment-row')) {
            event.target.closest('tr').remove();
        }
    });

});

// document.addEventListener('DOMContentLoaded', function() {
//     const markListTable = document.getElementById('mark-list-table');
//     const addMarkListRowBtn = document.getElementById('add-marklist-row');

//     if (!markListTable || !addMarkListRowBtn) {
//         console.error('Required elements are missing');
//         return;
//     }

//     addMarkListRowBtn.addEventListener('click', function() {
//         const newRow = document.createElement('tr');
//         newRow.innerHTML = `
//             <td><input type="text" name="marklist_class_name[]" class="form-control" required></td>
//             <td><input type="number" name="marklist_term[]" class="form-control" required></td>
//             <td><input type="text" name="marklist_grade[]" class="form-control" required></td>
//             <td><input type="date" name="marklist_date[]" class="form-control" required></td>
//             <td><input type="text" name="marklist_comments[]" class="form-control" required></td>
//             <td><input type="file" name="marklist_file[]" class="form-control-file"></td>
//             <td><button type="button" class="btn btn-danger remove-marklist-row">Remove</button></td>
//         `;
//         markListTable.appendChild(newRow);
//     });

//     markListTable.addEventListener('click', function(event) {
//         if (event.target.classList.contains('remove-marklist-row')) {
//             event.target.closest('tr').remove();
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    const markListTable = document.getElementById('mark-list-table');
    const addMarkListRowBtn = document.getElementById('add-marklist-row');

    addMarkListRowBtn.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="marklist_class_name[]" class="form-control" required></td>
            <td><input type="number" name="marklist_term[]" class="form-control" required></td>
            <td><input type="text" name="marklist_grade[]" class="form-control" required></td>
            <td><input type="text" name="marklist_date[]" class="form-control" required></td>
            <td><input type="text" name="marklist_comments[]" class="form-control" required></td>
            <td><input type="file" name="marklist_file[]" class="form-control-file"></td>
            
        `;
        markListTable.appendChild(newRow);
    });

    markListTable.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-marklist-row')) {
            const row = event.target.closest('tr');
            const markId = row.querySelector('input[name="marklist_id[]"]');
            if (markId) {
                // Add a hidden input to mark this row as removed
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'marklist_delete_ids[]';
                deleteInput.value = markId.value;
                document.querySelector('form').appendChild(deleteInput);
            }
            row.remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const courseDropdown = document.getElementById('course_id');
    const gradeDropdown = document.getElementById('current_grade');

    // Define the grade options
    const gradeOptions = {
        default: [
            'PREKG', 'LKG', 'UKG', '1st', '2nd', '3rd', '4th', '5th',
            '6th', '7th', '8th', '9th', '10th'
        ],
        HSE: ['+1', '+2'],
        DEGREE: [
            '1st Sem', '2nd Sem', '3rd Seme', '4th Sem', 
            '5th Sem', '6th Sem', '7th Sem', '8th sem'
        ],
        PG: [
            '1st Sem', '2nd Sem', '3rd Sem', '4th Sem'
        ],
        PROFESSIONAL: [
            '1st Year', '2nd Year', '3rd Year', '4th Year'
        ]
    };

    function populateGrades(course) {
        gradeDropdown.innerHTML = ''; // Clear existing options
        
        // Add the initial "Select Standard" option
        const placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = 'Select Standard';
        gradeDropdown.appendChild(placeholderOption);

        // Determine which options to use based on the selected course
        let options;
        switch (course) {
            case 'HSE':
                options = gradeOptions.HSE;
                break;
            case 'DEGREE':
                options = gradeOptions.DEGREE;
                break;
            case 'PG':
                options = gradeOptions.PG;
                break;
            case 'PROFESSIONAL':
                options = gradeOptions.PROFESSIONAL;
                break;
            default:
                options = gradeOptions.default;
                break;
        }

        // Populate the dropdown with the appropriate options
        options.forEach(grade => {
            const option = document.createElement('option');
            option.value = grade;
            option.textContent = grade;

            // Set the selected attribute if the grade matches the old or current grade value
            const selectedGrade = "{{ old('current_grade', $student->current_grade) }}";
            if (selectedGrade === grade) {
                option.selected = true;
            }

            gradeDropdown.appendChild(option);
        });
    }

    // Initially populate grades based on the selected course if available
    const initialCourse = courseDropdown.options[courseDropdown.selectedIndex].text;
    populateGrades(initialCourse);

    // Change event listener for the course dropdown
    courseDropdown.addEventListener('change', function () {
        const selectedCourse = courseDropdown.options[courseDropdown.selectedIndex].text;
        populateGrades(selectedCourse);
    });
});

</script>

@endsection 