<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $internships = $request->user()->internships()
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('company', 'like', '%' . $request->search . '%')
                             ->orWhere('position', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        return view('internships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|max:255',
            'position' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $internship = new Internship($validated);
        $internship->user_id = $request->user()->id;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('internships', 'private');
            $internship->document_path = $path;
        }

        $internship->save();

        return redirect()->route('internships.index')->with('success', 'Internship added successfully.');
    }

    public function edit(Internship $internship)
    {
        if ($internship->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('internships.edit', compact('internship'));
    }

    public function update(Request $request, Internship $internship)
    {
        if ($internship->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'company' => 'required|max:255',
            'position' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $internship->update($validated);

        if ($request->hasFile('document')) {
            if ($internship->document_path) {
                Storage::disk('private')->delete($internship->document_path);
            }
            $path = $request->file('document')->store('internships', 'private');
            $internship->document_path = $path;
            $internship->save();
        }

        return redirect()->route('internships.index')->with('success', 'Internship updated successfully.');
    }

    public function destroy(Internship $internship)
    {
        if ($internship->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($internship->document_path) {
            Storage::disk('private')->delete($internship->document_path);
        }

        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Internship deleted successfully.');
    }

    public function view_document(Internship $internship)
    {
        if ($internship->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$internship->document_path) {
            return back()->with('error', 'No document available for this internship.');
        }

        $filePath = Storage::disk('private')->path($internship->document_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'The document file is missing. Please contact the administrator.');
        }

        return response()->file($filePath);
    }
}

