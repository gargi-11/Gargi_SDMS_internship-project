@extends('layouts.app')

@section('content')
    <h2>Add New Course</h2>
    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="provider">Provider:</label>
            <input type="text" id="provider" name="provider" required>
        </div>
        <div>
            <label for="completion_date">Completion Date:</label>
            <input type="date" id="completion_date" name="completion_date" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
        </div>
        <div>
            <button type="submit" class="btn">Add Course</button>
        </div>
    </form>
@endsection

