@extends('layouts.app')

@section('content')
    <h2>Add New Internship</h2>
    <form method="POST" action="{{ route('internships.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="company">Company:</label>
            <input type="text" id="company" name="company" required>
        </div>
        <div>
            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required>
        </div>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
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
            <button type="submit" class="btn">Add Internship</button>
        </div>
    </form>
@endsection

