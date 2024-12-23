@extends('layouts.app')

@section('content')
    <h1>Add New Achievement</h1>
    <form method="POST" action="{{ route('achievements.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required value="{{ old('title') }}">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required value="{{ old('date') }}">
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
        </div>
        <div>
            <button type="submit" class="btn">Add Achievement</button>
        </div>
    </form>
@endsection

