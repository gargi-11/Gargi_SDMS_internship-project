@extends('layouts.app')

@section('content')
    <h2>Edit Internship</h2>
    <form method="POST" action="{{ route('internships.update', $internship) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="company">Company:</label>
            <input type="text" id="company" name="company" value="{{ $internship->company }}" required>
        </div>
        <div>
            <label for="position">Position:</label>
            <input type="text" id="position" name="position" value="{{ $internship->position }}" required>
        </div>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $internship->start_date }}" required>
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $internship->end_date }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ $internship->description }}</textarea>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
            @if($internship->document_path)
                <p>Current document: {{ basename($internship->document_path) }}</p>
            @endif
        </div>
        <div>
            <button type="submit" class="btn">Update Internship</button>
        </div>
    </form>
@endsection

