@extends('layouts.app')

@section('content')
    <h2>Edit Course</h2>
    <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $course->title }}" required>
        </div>
        <div>
            <label for="provider">Provider:</label>
            <input type="text" id="provider" name="provider" value="{{ $course->provider }}" required>
        </div>
        <div>
            <label for="completion_date">Completion Date:</label>
            <input type="date" id="completion_date" name="completion_date" value="{{ $course->completion_date }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ $course->description }}</textarea>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
            @if($course->document_path)
                <p>Current document: {{ basename($course->document_path) }}</p>
            @endif
        </div>
        <div>
            <button type="submit" class="btn">Update Course</button>
        </div>
    </form>
@endsection

