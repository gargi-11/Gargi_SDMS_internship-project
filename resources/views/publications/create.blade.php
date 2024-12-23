@extends('layouts.app')

@section('content')
    <h2>Add New Publication</h2>
    <form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="journal">Journal:</label>
            <input type="text" id="journal" name="journal" required>
        </div>
        <div>
            <label for="publication_date">Publication Date:</label>
            <input type="date" id="publication_date" name="publication_date" required>
        </div>
        <div>
            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract" required></textarea>
        </div>
        <div>
            <label for="document">Document:</label>
            <input type="file" id="document" name="document">
        </div>
        <div>
            <button type="submit" class="btn">Add Publication</button>
        </div>
    </form>
@endsection

