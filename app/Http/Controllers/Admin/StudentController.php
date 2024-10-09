<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Stream;
use App\Models\FeePayment;
use App\Models\MarkList;
use App\Models\Seminar;
use App\Models\Attendance;
class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::pluck('name', 'id'); // Assuming 'name' is the course name
        $streams = Stream::all(); // Fetch all streams

        return view('admin.students.create', compact('courses', 'streams'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'student_name' => 'required|string|max:255',
            // 'student_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'min:12|string|max:255|unique:students,student_id', // Ensure unique student_id
            // 'student_mobile' => 'min:10|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_id' => 'min:12|string|max:255',
            'guardian_mobile' => 'min:10|string|max:255',
            // 'address_line_1' => 'string|max:255',
            // 'address_line_2' => 'string|max:255',
            // 'educational_institution' => 'string|max:255',
            // 'institution_mobile' => 'min:10|string|max:255',
            // 'current_grade' => 'string|max:255',
            // 'total_fees' => 'integer',
            // 'allocated_fees' => 'integer',
            // 'grade' => 'array',
            // 'fee_amount' => 'array',
            // 'term' => 'required|array',
            // 'date' => 'required|array',
            'receipt_number' => 'required|array',
        ]);

        // Generate a UUID for the new student
        $studentUUID = Str::uuid()->toString();

        // Create a new Student instance
        $student = new Student([
            'id' => $studentUUID, // Use the generated UUID
            'student_name' => $request->student_name,
            'student_id' => $request->student_id, // Use the validated student ID
            'student_mobile' => $request->student_mobile,
            'guardian_name' => $request->guardian_name,
            'guardian_id' => $request->guardian_id,
            'guardian_mobile' => $request->guardian_mobile,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'educational_institution' => $request->educational_institution,
            'institution_mobile' => $request->institution_mobile,
            'course_id' => $request->course_id,
            'stream_id' => $request->stream_id,
            'current_grade' => $request->current_grade,
            'total_fees' => $request->total_fees,
            'allocated_fees' => $request->allocated_fees,
        ]);

        // Handle the student image upload if provided
        if ($request->hasFile('student_image')) {
            $imageName = time().'.'.$request->student_image->extension();  
            $request->student_image->move(public_path('images/students'), $imageName);

            // Save the image name in the database
            $student->student_image = $imageName;
        }

        // Save the student record to the database
        $student->save();

        // Get the authenticated user ID for record keeping
        $userId = Auth::id();

        // Loop through the fee details and save each payment
        foreach ($request->grade as $key => $grade) {
            // Check if grade and other required fields are present
            $feeAmount = $request->fee_amount[$key] ?? null;
            $term = $request->term[$key] ?? null;
            $date = $request->date[$key] ?? null;
            $receiptNumber = $request->receipt_number[$key] ?? null;
        
            // If any required field is missing, handle the error or skip the entry
            if (is_null($grade) || is_null($feeAmount) || is_null($term) || is_null($date) || is_null($receiptNumber)) {
                // Log the missing data or handle the error as needed
                \Log::error("Missing data for fee payment: ", [
                    'grade' => $grade,
                    'fee_amount' => $feeAmount,
                    'term' => $term,
                    'date' => $date,
                    'receipt_number' => $receiptNumber,
                ]);
                // Skip this iteration if any value is missing
                continue;
            }
        
            // Proceed with the insertion if all required fields are present
            FeePayment::create([
                'student_id' => $studentUUID, // Use the UUID of the student
                'grade' => $grade,
                'fee_amount' => $feeAmount,
                'term' => $term,
                'date' => $date,
                'receipt_number' => $receiptNumber,
                'created_by' => $userId,
            ]);
        }
        

        // Handle the mark list data
if ($request->has('marklist_class_name')) {
    foreach ($request->marklist_class_name as $index => $className) {
        // Check if class name is not null before proceeding
        if (is_null($className) || empty($className)) {
            \Log::error('Missing class name for mark list entry at index: ' . $index);
            continue; // Skip this entry if class name is null or empty
        }

        // Initialize file name as null
        $marklistFileName = null;

        // Check if a file was uploaded for this mark list entry
        if ($request->hasFile("marklist_file.$index")) {
            $file = $request->file("marklist_file.$index");
            $marklistFileName = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/marklists'), $marklistFileName);
        }else {
            // Retain old file if present
            $marklistFiles[$index] = $request->existing_marklist_file[$index] ?? null;
        }

        // Validate and fetch other fields safely
        $term = $request->marklist_term[$index] ?? null;
        $grade = $request->marklist_grade[$index] ?? null;
        $date = $request->marklist_date[$index] ?? null;
        $comments = $request->marklist_comments[$index] ?? null;

        // Check if any other required fields are null
        if (is_null($term) || is_null($date)) {
            \Log::error('Missing required fields for mark list entry at index: ' . $index, [
                'class_name' => $className,
                'term' => $term,
                'date' => $date,
            ]);
            continue; // Skip if essential fields are missing
        }

        // Save the mark list details
        MarkList::create([
            'student_id' => $studentUUID,
            'class_name' => $className,
            'term' => $term,
            'grade' => $grade,
            'date' => $date,
            'comments' => $comments,
            'marklist_file' => $marklistFileName,
        ]);
    }
}


        // Redirect back with a success message
        return redirect()->route('admin.students.index')->with('success', 'Student registered and fee payments recorded successfully.');
    }

    public function show(Student $student)
    {
    
        $student->load('course', 'stream','feePayment', 'markList'); // Eager load the relationships
        return view('admin.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with('FeePayment', 'markList')->findOrFail($id);
       // $student = Student::with('markList')->findOrFail($id);
        $student_streamId = $student->stream_id;
        $student_joiningDate =$student->created_date;
        // Fetch all courses and streams to populate the dropdowns
        $courses = Course::pluck('name', 'id')->all(); // Assuming the Course model has a 'name' field
        $streams = Stream::pluck('name', 'id')->all(); // Assuming the Stream model has a 'name' field
        $seminars = Seminar::whereHas('streams', function ($query) use ($student_streamId) {
            $query->where('stream_id', $student_streamId);
        })->get();
        $attendanceData = [];
    foreach ($seminars as $seminar) {
        // Check if the student attended the seminar
        $attendance = Attendance::where('student_id', $student->id)
            ->where('seminar_id', $seminar->id)
            ->first();

        // Determine attendance status
        if ($attendance) {
            $status = 'present';
        } elseif ($student_joiningDate > $seminar->date) {
            // If the student joined after the seminar date, they are marked as absent
            $status = 'absent (joined after seminar date)';
        } else {
            $status = 'absent';
        }

        // Add seminar and attendance status to the data array
        $attendanceData[] = [
            'seminar' => $seminar->seminar_name, // Assuming 'title' is the seminar field
            'date' => $seminar->seminar_date,
            'status' => $status,
        ];
    }
        
        //$student = Student::with('FeePayment', 'markList')->findOrFail($id);
        // Pass the student, courses, and streams data to the view
        return view('admin.students.edit', compact('student', 'courses', 'streams','attendanceData'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            // 'student_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'required|string|max:255',
            // 'student_mobile' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_id' => 'required|string|max:255',
            'guardian_mobile' => 'required|string|max:255',
            // 'address_line_1' => 'required|string|max:255',
            // 'address_line_2' => 'required|string|max:255',
            // 'educational_institution' => 'required|string|max:255',
            // 'institution_mobile' => 'required|string|max:255',
            // 'course_id' => 'required|string|max:255',
            // 'current_grade' => 'required|string|max:255',
            // 'total_fees' => 'required|integer',
            // 'allocated_fees' => 'required|integer',
        ]);

        // Update fields
        $student->update([
            'student_name' => $request->student_name,
            'student_id' => $request->student_id,
            'student_mobile' => $request->student_mobile,
            'guardian_name' => $request->guardian_name,
            'guardian_id' => $request->guardian_id,
            'guardian_mobile' => $request->guardian_mobile,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'educational_institution' => $request->educational_institution,
            'institution_mobile' => $request->institution_mobile,
            'course_id' => $request->course_id,
            'stream_id' => $request->stream_id,
            'current_grade' => $request->current_grade,
            'total_fees' => $request->total_fees,
            'allocated_fees' => $request->allocated_fees,
        ]);

        if ($request->hasFile('student_image')) {
            // Delete the old image if it exists
            if ($student->student_image && file_exists(public_path('images/students/' . $student->student_image))) {
                unlink(public_path('images/students/' . $student->student_image));
            }
        
            // Upload the new image
            $image = $request->file('student_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/students'), $imageName);
        
            // Update the student's image field and save the model
            $student->student_image = $imageName;
            
        }

        $student->save();

         // Update existing payments and add new ones
        $paymentIds = $request->input('payment_id', []);
        $grades = $request->input('grade', []);
        $feeAmounts = $request->input('fee_amount', []);
        $terms = $request->input('term', []);
        $dates = $request->input('date', []);
        $receiptNumbers = $request->input('receipt_number', []);

        if ($request->has('marklist_delete_ids')) {
            MarkList::whereIn('id', $request->marklist_delete_ids)->delete();
        }
        
        foreach ($grades as $index => $grade) {
            $paymentData = [
                'grade' => $grade,
                'fee_amount' => $feeAmounts[$index],
                'term' => $terms[$index],
                'date' => $dates[$index],
                'receipt_number' => $receiptNumbers[$index],
                'created_by' => Auth::id(),

            ];

            if (isset($paymentIds[$index])) {
                // Update existing payment
                $payment = FeePayment::find($paymentIds[$index]);
                if ($payment) {
                    $payment->update($paymentData);
                }
            } else {
                // Create new payment
                
                $student->feePayment()->create($paymentData);
            }
        }

        // Update existing mark lists and add new ones
        $marklistIds = $request->input('marklist_id', []);
        $marklistClassNames = $request->input('marklist_class_name', []);
        $marklistTerms = $request->input('marklist_term', []);
        $marklistGrades = $request->input('marklist_grade', []);
        $marklistDates = $request->input('marklist_date', []);
        $marklistComments = $request->input('marklist_comments', []);
        $marklistFiles = $request->file('marklist_file', []);
        //    dd($marklistTerms);
        foreach ($marklistClassNames as $index => $className) {
            $marklistData = [
                'class_name' => $className,
                'term' => $marklistTerms[$index],
                'grade' => $marklistGrades[$index],
                'date' => $marklistDates[$index],
                'comments' => $marklistComments[$index] ?? null,
                'marklist_file' => isset($marklistFiles[$index]) ? $this->uploadMarklistFile($marklistFiles[$index]) : null,
            ];

            if (isset($marklistIds[$index])) {
                // Update existing mark list
                $marklist = MarkList::find($marklistIds[$index]);
                if ($marklist) {
                    $marklist->update($marklistData);
                }
            } else {
                // Create new mark list
                $student->markList()->create($marklistData);
            }
        }
        
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    // Method to handle marklist file upload
    protected function uploadMarklistFile($file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('files/marklists'), $fileName);
        return $fileName;
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();
        return redirect()->route('admin.students.index')->with('success', 'Student restored successfully.');
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->forceDelete();
        return redirect()->route('admin.students.index')->with('success', 'Student permanently deleted.');
    }
}
