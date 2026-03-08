@extends('base')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Employee Management</h1>
    <p class="mb-4 text-muted">List of all users registered with the role of 'Employee'.</p>

    <div class="table-responsive">
        @if($users->isEmpty())
            <p class="text-center text-muted"><em>No employees found.</em></p>
        @else
            <table class="table table-bordered table-hover" style="table-layout: fixed; width: 100%;">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 15%;">Contact</th>
                        <th style="width: 10%;">Role</th>
                        <th style="width: 15%;">Joined</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-truncate" title="{{ $user->name }}">{{ $user->name }}</td>
                        <td class="text-truncate" title="{{ $user->email }}">{{ $user->email }}</td>
                        <td class="text-truncate" title="{{ $user->contact }}">{{ $user->contact }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.employees.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.employees.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this employee ({{ $user->name }})?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<style>
    /* Truncate long text for columns */
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endsection
