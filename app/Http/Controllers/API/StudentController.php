<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Stream;
use App\Models\FeePayment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course', 'stream', 'feePayment')->get();
        return response()->json($students);
    }

    public function create()
    {
        // API doesn't need a create method to return a view, so you can remove this or leave it empty
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'required|string|max:255|unique:students,student_id',
            'student_mobile' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_id' => 'required|string|max:255',
            'guardian_mobile' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'educational_institution' => 'required|string|max:255',
            'institution_mobile' => 'required|string|max:255',
            'current_grade' => 'required|string|max:255',
            'total_fees' => 'required|integer',
            'allocated_fees' => 'required|integer',
            'grade' => 'required|array',
            'fee_amount' => 'required|array',
            'term' => 'required|array',
            'date' => 'required|array',
            'receipt_number' => 'required|array',
        ]);

        $studentUUID = Str::uuid()->toString();

        $student = new Student([
            'id' => $studentUUID,
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
            $imageName = time().'.'.$request->student_image->extension();
            $request->student_image->move(public_path('images/students'), $imageName);
            $student->student_image = $imageName;
        }

        $student->save();

        $userId = Auth::id();

        foreach ($request->grade as $key => $grade) {
            FeePayment::create([
                'student_id' => $studentUUID,
                'grade' => $grade,
                'fee_amount' => $request->fee_amount[$key],
                'term' => $request->term[$key],
                'date' => $request->date[$key],
                'receipt_number' => $request->receipt_number[$key],
                'created_by' => $userId,
            ]);
        }

        return response()->json(['success' => 'Student registered and fee payments recorded successfully.', 'student' => $student], 201);
    }

    public function show(Student $student)
    {
        $student->load('course', 'stream', 'feePayment');
        return response()->json($student);
    }

    public function edit($id)
    {
        // API doesn't need an edit method to return a view, so you can remove this or leave it empty
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'required|string|max:255',
            'student_mobile' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_id' => 'required|string|max:255',
            'guardian_mobile' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'educational_institution' => 'required|string|max:255',
            'institution_mobile' => 'required|string|max:255',
            'course_id' => 'required|string|max:255',
            'current_grade' => 'required|string|max:255',
            'total_fees' => 'required|integer',
            'allocated_fees' => 'required|integer',
        ]);

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
            if ($student->student_image && file_exists(public_path('images/students/' . $student->student_image))) {
                unlink(public_path('images/students/' . $student->student_image));
            }
            $image = $request->file('student_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/students'), $imageName);
            $student->student_image = $imageName;
        }

        $student->save();

        $paymentIds = $request->input('payment_id', []);
        $grades = $request->input('grade', []);
        $feeAmounts = $request->input('fee_amount', []);
        $terms = $request->input('term', []);
        $dates = $request->input('date', []);
        $receiptNumbers = $request->input('receipt_number', []);

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
                $payment = FeePayment::find($paymentIds[$index]);
                if ($payment) {
                    $payment->update($paymentData);
                }
            } else {
                $student->feePayment()->create($paymentData);
            }
        }

        return response()->json(['success' => 'Student updated successfully.', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['success' => 'Student deleted successfully.']);
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();
        return response()->json(['success' => 'Student restored successfully.']);
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->forceDelete();
        return response()->json(['success' => 'Student permanently deleted.']);
    }
}
