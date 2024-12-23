@extends('layouts.app')

@section('content')
    <h1>Internships</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('internships.create') }}" class="btn">Add New Internship</a>
        <form action="{{ route('internships.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search internships..." value="{{ request('search') }}" style="flex-grow: 1;">
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    @if($internships->isEmpty())
        <p>No internships found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Position</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $internship)
                    <tr>
                        <td>{{ $internship->company }}</td>
                        <td>{{ $internship->position }}</td>
                        <td>{{ $internship->start_date }}</td>
                        <td>{{ $internship->end_date }}</td>
                        <td>
                            <a href="{{ route('internships.edit', $internship) }}" class="btn btn-sm" style="background-color: #4299e1;">Edit</a>
                            @if($internship->document_path)
                                <a href="{{ route('internships.view_document', $internship) }}" class="btn btn-sm" style="background-color: #48bb78;">View</a>
                            @endif
                            <form action="{{ route('internships.destroy', $internship) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #f56565;" onclick="return confirm('Are you sure you want to delete this internship?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $internships->links() }}
        </div>
    @endif
@endsection

    