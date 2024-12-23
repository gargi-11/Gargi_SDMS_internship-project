<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $publications = $request->user()->publications()
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%')
                             ->orWhere('journal', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('publications.index', compact('publications'));
    }

    public function create()
    {
        return view('publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'journal' => 'required|max:255',
            'publication_date' => 'required|date',
            'abstract' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $publication = new Publication($validated);
        $publication->user_id = $request->user()->id;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('publications', 'private');
            $publication->document_path = $path;
        }

        $publication->save();

        return redirect()->route('publications.index')->with('success', 'Publication added successfully.');
    }

    public function edit(Publication $publication)
    {
        if ($publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('publications.edit', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        if ($publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'journal' => 'required|max:255',
            'publication_date' => 'required|date',
            'abstract' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $publication->update($validated);

        if ($request->hasFile('document')) {
            if ($publication->document_path) {
                Storage::disk('private')->delete($publication->document_path);
            }
            $path = $request->file('document')->store('publications', 'private');
            $publication->document_path = $path;
            $publication->save();
        }

        return redirect()->route('publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication)
    {
        if ($publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($publication->document_path) {
            Storage::disk('private')->delete($publication->document_path);
        }

        $publication->delete();
        return redirect()->route('publications.index')->with('success', 'Publication deleted successfully.');
    }

    public function view_document(Publication $publication)
    {
        if ($publication->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$publication->document_path) {
            return back()->with('error', 'No document available for this publication.');
        }

        $filePath = Storage::disk('private')->path($publication->document_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'The document file is missing. Please contact the administrator.');
        }

        return response()->file($filePath);
    }
}

