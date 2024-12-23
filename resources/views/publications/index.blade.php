@extends('layouts.app')

@section('content')
    <h1>Publications</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('publications.create') }}" class="btn">Add New Publication</a>
        <form action="{{ route('publications.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search publications..." value="{{ request('search') }}" style="flex-grow: 1;">
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    @if($publications->isEmpty())
        <p>No publications found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Journal</th>
                    <th>Publication Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publications as $publication)
                    <tr>
                        <td>{{ $publication->title }}</td>
                        <td>{{ $publication->journal }}</td>
                        <td>{{ $publication->publication_date }}</td>
                        <td>
                            <a href="{{ route('publications.edit', $publication) }}" class="btn btn-sm" style="background-color: #4299e1;">Edit</a>
                            @if($publication->document_path)
                                <a href="{{ route('publications.view_document', $publication) }}" class="btn btn-sm" style="background-color: #48bb78;">View</a>
                            @endif
                            <form action="{{ route('publications.destroy', $publication) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #f56565;" onclick="return confirm('Are you sure you want to delete this publication?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $publications->links() }}
        </div>
    @endif
@endsection

