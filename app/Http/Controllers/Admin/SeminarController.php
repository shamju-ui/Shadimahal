<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Course;
use App\Models\Stream;
use App\Models\Attendance;
class SeminarController extends Controller
{
     // 1. INDEX: Display a list of all seminars
     public function index()
     {
         // Fetch all seminars with their associated courses, paginated
         $seminars = Seminar::with('courses')->paginate(10);
         return view('admin.seminars.index', compact('seminars'));
     }
 
     // 2. CREATE: Show the form to create a new seminar
     public function create()
     {
         // Fetch all courses to show in the form
         $courses = Course::all();
         return view('admin.seminars.create', compact('courses'));
     }
 
     // 3. STORE: Save a new seminar
     public function store(Request $request)
     {
         // Validate the request data
         $request->validate([
             'seminar_name' => 'required|string|max:255',
             'seminar_date' => 'required|date',
             'runner' => 'required|string|max:255',
             'course_ids' => 'required|array',
             'course_ids.*' => 'exists:courses,id',
         ]);
 
          // Create the seminar
    $seminar = Seminar::create($request->only(['seminar_name', 'seminar_date', 'runner']));

    // Attach selected courses to the seminar
    $seminar->courses()->attach($request->course_ids);

    // Attach selected streams to the seminar
    $seminar->streams()->attach($request->stream_ids);

         // Redirect back to seminar list with a success message
         return redirect()->route('admin.seminars.index')->with('success', 'Seminar created successfully!');
     }
 
     // 4. SHOW: Display details of a single seminar
     public function show($id)
     {
         // Find the seminar and eager load courses
         $seminar = Seminar::with('courses')->findOrFail($id);
        //  return view('admin.seminars.show', compact('seminar'));
     }
 
     // 5. EDIT: Show the form to edit an existing seminar
     public function edit($id)
     {
         // Find the seminar and fetch all courses
         $seminar = Seminar::findOrFail($id);
         $courses = Course::all();
         $streams = Stream::whereIn('course_id', $seminar->courses->pluck('id'))->get();
         return view('admin.seminars.edit', compact('seminar', 'courses','streams'));
     }
 
     // 6. UPDATE: Save the updated seminar details
     public function update(Request $request, $id)
     {
         // Validate the updated data
         $request->validate([
             'seminar_name' => 'required|string|max:255',
             'seminar_date' => 'required|date',
             'runner' => 'required|string|max:255',
             'course_ids' => 'required|array',
             'course_ids.*' => 'exists:courses,id',
         ]);
 
         // Find the seminar and update its data
         $seminar = Seminar::findOrFail($id);
         $seminar->update($request->only(['seminar_name', 'seminar_date', 'runner']));
 
         // Sync the selected courses (removes old ones and adds new ones)
         $seminar->courses()->sync($request->course_ids);
         $seminar->streams()->sync($request->stream_ids);
         // Redirect back with a success message
         return redirect()->route('admin.seminars.index')->with('success', 'Seminar updated successfully!');
     }
 
     // 7. DESTROY: Delete a seminar
     public function destroy($id)
     {
         // Find the seminar and detach related courses
         $seminar = Seminar::findOrFail($id);
         $seminar->courses()->detach();
         
         // Delete the seminar
         $seminar->delete();
 
         // Redirect back to the list with a success message
         return redirect()->route('admin.seminars.index')->with('success', 'Seminar deleted successfully!');
     }
 
     // 8. Get Streams for Selected Courses (AJAX Request)
     public function getStreamsForCourses(Request $request)
     {

         $courseIds = $request->input('course_ids');

         $streams = Stream::whereIn('course_id', $courseIds)->get();
     
         return response()->json($streams);
     }

    //  public function getStreamAndCourseForSeminar($id)
    // {
        
    //     $seminarId  = $id;
    //     $seminar = Seminar::with('courses', 'streams','streams.students')->find($seminarId);
    //     $courses = $seminar->courses??[];
    //     $streams = $seminar->streams??[];
    //     return view('admin.seminars.attendence', compact('seminar', 'courses','streams','seminarId'));
        
           
       
    // }
    public function getStreamAndCourseForSeminar($id, Request $request)
{
    $seminarId = $id;
    $seminar = Seminar::with('courses', 'streams.students')->find($seminarId);

    // Filter logic
    $studentName = $request->input('student_name');
    $courseId = $request->input('course');
    $streamId = $request->input('stream');

    $streams = $seminar->streams()
                        ->when($streamId, fn($q) => $q->where('id', $streamId))
                        ->with(['students' => function ($query) use ($studentName, $courseId) {
                            if ($studentName) {
                                $query->where('student_name', 'like', "%{$studentName}%");
                            }
                            if ($courseId) {
                                $query->where('course_id', $courseId);
                            }
                        }])
                        ->get();

    // Get existing attendances
    $existingAttendances = Attendance::where('seminar_id', $seminarId)->pluck('student_id')->toArray();

    $courses = $seminar->courses ?? [];
    return view('admin.seminars.attendence', compact('seminar', 'courses', 'streams', 'seminarId', 'existingAttendances'));
}
//     public function saveAttendance(Request $request)
// {

//    public function saveAttendance(Request $request)
// {
//     // Validate the input
//     $request->validate([
//         'student_ids' => 'required|array',
//         'seminar_id' => 'required|integer',
//     ]);

//     // Loop through each student ID and insert or update the attendance record
//     foreach ($request->student_ids as $studentId) {
//         // Check if the attendance record exists
//         $attendance = Attendance::where('student_id', $studentId)
//                                 ->where('seminar_id', $request->seminar_id)
//                                 ->first();

//         if ($attendance) {
//             // If it exists, update the record (if any additional fields need to be updated)
//             $attendance->update([
//                 // Add fields you want to update if necessary, e.g.:
//                 // 'status' => $request->status[$studentId] ?? 'present', // Example field
//             ]);
//         } else {
//             // If it doesn't exist, create a new attendance record
//             Attendance::create([
//                 'student_id' => $studentId,
//                 'seminar_id' => $request->seminar_id,
//                 // Add other fields if needed, e.g.:
//                 // 'status' => $request->status[$studentId] ?? 'present', // Example field
//             ]);
//         }
//     }

//     return response()->json(['success' => 'Attendance recorded successfully.']);
// }


//     return response()->json(['success' => 'Attendance recorded successfully.']);
// }


public function saveAttendance(Request $request)
{
    // Validate the input
    $request->validate([
        'student_ids' => 'required|array',
        'seminar_id' => 'required|integer',
    ]);

    // Fetch all existing attendance records for the seminar
    $existingAttendances = Attendance::where('seminar_id', $request->seminar_id)->pluck('student_id')->toArray();

    // Loop through each student ID in the form (checked students)
    foreach ($request->student_ids as $studentId) {
        // Check if attendance record already exists
        $attendance = Attendance::where('student_id', $studentId)
                                ->where('seminar_id', $request->seminar_id)
                                ->first();

        if (!$attendance) {
            // If the attendance record doesn't exist, create a new one
            Attendance::create([
                'student_id' => $studentId,
                'seminar_id' => $request->seminar_id,
                'status' => 'present'
                // Add other fields if needed, e.g. 'status' => 'present'
            ]);
        }
    }

    // Remove attendance for students that were unchecked (not in $request->student_ids)
    $studentsToRemove = array_diff($existingAttendances, $request->student_ids);
    if (!empty($studentsToRemove)) {
        Attendance::whereIn('student_id', $studentsToRemove)
                  ->where('seminar_id', $request->seminar_id)
                  ->delete();
    }

    return redirect()->route('admin.seminars.index')->with('success', 'Attendance Recorded successfully!');
}


}
