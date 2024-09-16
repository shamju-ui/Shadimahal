<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarkList;

class MarkListController extends Controller
{
    // Display a list of all mark list entries
    public function index()
    {
        $markLists = MarkList::all();
        return view('admin.marklists.index', compact('markLists'));
    }

    // Show the form for creating a new mark list entry
    public function create()
    {
        return view('admin.marklists.create');
    }

    // Store a newly created mark list entry in the database
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'term' => 'required|integer',
            'grade' => 'required|string|max:2',
            'date' => 'required|date',
            'comments' => 'nullable|string|max:255',
            'marklist_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image file upload
        ]);

        // Handle image upload if provided
        $fileName = null;
        if ($request->hasFile('marklist_file')) {
            $fileName = time() . '.' . $request->marklist_file->getClientOriginalExtension();
            $request->marklist_file->move(public_path('uploads/marklists'), $fileName);
        }

        // Create a new MarkList entry
        MarkList::create([
            'class_name' => $request->class_name,
            'term' => $request->term,
            'grade' => $request->grade,
            'date' => $request->date,
            'comments' => $request->comments,
            'marklist_file' => $fileName,
        ]);

        return redirect()->route('admin.marklists.index')->with('success', 'Mark list created successfully.');
    }

    // Show a single mark list entry
    public function show(MarkList $markList)
    {
        return view('admin.marklists.show', compact('markList'));
    }

    // Show the form for editing an existing mark list entry
    public function edit(MarkList $markList)
    {
        return view('admin.marklists.edit', compact('markList'));
    }

    // Update an existing mark list entry in the database
    public function update(Request $request, MarkList $markList)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'term' => 'required|integer',
            'grade' => 'required|string|max:2',
            'date' => 'required|date',
            'comments' => 'nullable|string|max:255',
            'marklist_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image file upload
        ]);

        // Handle image upload if provided
        if ($request->hasFile('marklist_file')) {
            // Delete the old image if it exists
            if ($markList->marklist_file && file_exists(public_path('uploads/marklists/' . $markList->marklist_file))) {
                unlink(public_path('uploads/marklists/' . $markList->marklist_file));
            }

            // Upload the new image
            $fileName = time() . '.' . $request->marklist_file->getClientOriginalExtension();
            $request->marklist_file->move(public_path('uploads/marklists'), $fileName);
            $markList->marklist_file = $fileName;
        }

        // Update the existing MarkList entry
        $markList->update([
            'class_name' => $request->class_name,
            'term' => $request->term,
            'grade' => $request->grade,
            'date' => $request->date,
            'comments' => $request->comments,
            'marklist_file' => $markList->marklist_file ?? $markList->marklist_file,
        ]);

        return redirect()->route('admin.marklists.index')->with('success', 'Mark list updated successfully.');
    }

    // Delete an existing mark list entry from the database
    public function destroy(MarkList $markList)
    {
        // Delete the image if it exists
        if ($markList->marklist_file && file_exists(public_path('uploads/marklists/' . $markList->marklist_file))) {
            unlink(public_path('uploads/marklists/' . $markList->marklist_file));
        }

        $markList->delete();

        return redirect()->route('admin.marklists.index')->with('success', 'Mark list deleted successfully.');
    }
}

