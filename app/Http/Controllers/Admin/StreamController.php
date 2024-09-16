<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stream;
use App\Models\Course;

class StreamController extends Controller
{
    public function index()
    {
        $streams = Stream::with('course')->get();
        return view('admin.streams.index', compact('streams'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.streams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        Stream::create($request->all());

        return redirect()->route('admin.streams.index')->with('success', 'Stream created successfully.');
    }

    public function edit(Stream $stream)
    {
        $courses = Course::all();
        return view('admin.streams.edit', compact('stream', 'courses'));
    }

    public function update(Request $request, Stream $stream)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $stream->update($request->all());

        return redirect()->route('admin.streams.index')->with('success', 'Stream updated successfully.');
    }

    public function destroy(Stream $stream)
    {
        $stream->delete();

        return redirect()->route('admin.streams.index')->with('success', 'Stream deleted successfully.');
    }

    // public function getStreamsByCourse($course_id)
    // {
    //     $streams = Stream::where('course_id', $course_id)->pluck('name', 'id');
    //     return response()->json($streams);
    // }
}
