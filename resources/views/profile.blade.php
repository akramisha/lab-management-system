@extends('base')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Your Profile</h2>
    <div class="card p-4">
        <h4 class="mb-3">Name: {{ $user->name }}</h4>
        <h4 class="mb-3">Email: {{ $user->email }}</h4>
        <h4 class="mb-3">Contact: {{ $user->contact }}</h4>
        <h4 class="mb-3">Address: {{ $user->address }}</h4>
        <br>
        <ul>
            <li>
                <a href="{{route('profile.edit')}}" class="tasks-manage">Edit Profile</a>
            </li>
        </ul>
    </div>
</div>
@endsection
