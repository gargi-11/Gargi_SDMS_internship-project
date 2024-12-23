@extends('layouts.app')

@section('content')
    <h1>Edit Achievement</h1>
    <form method="POST" action="{{ route('achievements.update', $achievement) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $achievement->title) }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description', $achievement->description) }}</textarea>
        </div>
        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="{{ old('date', $achievement->date) }}" required>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
            @if($achievement->document_path)
                <p>Current document: {{ basename($achievement->document_path) }}</p>
            @endif
        </div>
        <div>
            <button type="submit" class="btn">Update Achievement</button>
        </div>
    </form>
@endsection

