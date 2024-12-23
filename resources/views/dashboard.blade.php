@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        <a href="{{ route('achievements.index') }}" class="btn" style="text-align: center;">Manage Achievements</a>
        <a href="{{ route('internships.index') }}" class="btn" style="text-align: center;">Manage Internships</a>
        <a href="{{ route('courses.index') }}" class="btn" style="text-align: center;">Manage Courses & Workshops</a>
        <a href="{{ route('publications.index') }}" class="btn" style="text-align: center;">Manage Publications</a>
    </div>
@endsection

