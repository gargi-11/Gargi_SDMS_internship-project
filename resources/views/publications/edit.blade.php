@extends('layouts.app')

@section('content')
    <h2>Edit Publication</h2>
    <form method="POST" action="{{ route('publications.update', $publication) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $publication->title }}" required>
        </div>
        <div>
            <label for="journal">Journal:</label>
            <input type="text" id="journal" name="journal" value="{{ $publication->journal }}" required>
        </div>
        <div>
            <label for="publication_date">Publication Date:</label>
            <input type="date" id="publication_date" name="publication_date" value="{{ $publication->publication_date }}" required>
        </div>
        <div>
            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract" required>{{ $publication->abstract }}</textarea>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
            @if($publication->document_path)
                <p>Current document: {{ basename($publication->document_path) }}</p>
            @endif
        </div>
        <div>
            <button type="submit" class="btn">Update Publication</button>
        </div>
    </form>
@endsection

