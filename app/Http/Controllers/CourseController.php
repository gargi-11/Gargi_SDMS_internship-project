<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = $request->user()->courses()
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%')
                             ->orWhere('provider', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'provider' => 'required|max:255',
            'completion_date' => 'required|date',
            'description' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $course = new Course($validated);
        $course->user_id = $request->user()->id;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('courses', 'private');
            $course->document_path = $path;
        }

        $course->save();

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    public function edit(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'provider' => 'required|max:255',
            'completion_date' => 'required|date',
            'description' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $course->update($validated);

        if ($request->hasFile('document')) {
            if ($course->document_path) {
                Storage::disk('private')->delete($course->document_path);
            }
            $path = $request->file('document')->store('courses', 'private');
            $course->document_path = $path;
            $course->save();
        }

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($course->document_path) {
            Storage::disk('private')->delete($course->document_path);
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function view_document(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$course->document_path) {
            return back()->with('error', 'No document available for this course.');
        }

        $filePath = Storage::disk('private')->path($course->document_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'The document file is missing. Please contact the administrator.');
        }

        return response()->file($filePath);
    }
}

