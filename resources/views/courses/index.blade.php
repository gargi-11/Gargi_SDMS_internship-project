@extends('layouts.app')

@section('content')
    <h1>Courses & Workshops</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('courses.create') }}" class="btn">Add New Course</a>
        <form action="{{ route('courses.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}" style="flex-grow: 1;">
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    @if($courses->isEmpty())
        <p>No courses found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Provider</th>
                    <th>Completion Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->provider }}</td>
                        <td>{{ $course->completion_date }}</td>
                        <td>
                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm" style="background-color: #4299e1;">Edit</a>
                            @if($course->document_path)
                                <a href="{{ route('courses.view_document', $course) }}" class="btn btn-sm" style="background-color: #48bb78;">View</a>
                            @endif
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #f56565;" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $courses->links() }}
        </div>
    @endif
@endsection

