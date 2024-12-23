<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = $request->user()->achievements()
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $achievement = new Achievement($validated);
        $achievement->user_id = $request->user()->id;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('achievements', 'private');
            $achievement->document_path = $path;
        }

        $achievement->save();

        return redirect()->route('achievements.index')->with('success', 'Achievement added successfully.');
    }

    public function edit(Achievement $achievement)
    {
        if ($achievement->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        if ($achievement->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $achievement->update($validated);

        if ($request->hasFile('document')) {
            if ($achievement->document_path) {
                Storage::disk('private')->delete($achievement->document_path);
            }
            $path = $request->file('document')->store('achievements', 'private');
            $achievement->document_path = $path;
            $achievement->save();
        }

        return redirect()->route('achievements.index')->with('success', 'Achievement updated successfully.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($achievement->document_path) {
            Storage::disk('private')->delete($achievement->document_path);
        }

        $achievement->delete();
        return redirect()->route('achievements.index')->with('success', 'Achievement deleted successfully.');
    }

    public function view_document(Achievement $achievement)
    {
        if ($achievement->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$achievement->document_path) {
            return back()->with('error', 'No document available for this achievement.');
        }

        $filePath = Storage::disk('private')->path($achievement->document_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'The document file is missing. Please contact the administrator.');
        }

        return response()->file($filePath);
    }
}

