@extends('layouts.app')

@section('content')
    <h1>Achievements</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('achievements.create') }}" class="btn">Add New Achievement</a>
        <form action="{{ route('achievements.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search achievements..." value="{{ request('search') }}" style="flex-grow: 1;">
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    @if($achievements->isEmpty())
        <p>No achievements found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achievements as $achievement)
                    <tr>
                        <td>{{ $achievement->title }}</td>
                        <td>{{ $achievement->date }}</td>
                        <td>
                            <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-sm" style="background-color: #4299e1;">Edit</a>
                            @if($achievement->document_path)
                                <a href="{{ route('achievements.view_document', $achievement) }}" class="btn btn-sm" style="background-color: #48bb78;">View</a>
                            @endif
                            <form action="{{ route('achievements.destroy', $achievement) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #f56565;" onclick="return confirm('Are you sure you want to delete this achievement?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $achievements->links() }}
        </div>
    @endif
@endsection

