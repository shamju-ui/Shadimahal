<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
