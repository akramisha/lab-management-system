@extends('base')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Available Tests</h2>

    @if(session('user_role') === 'admin')
        <a href="{{ route('tests.create') }}" class="btn btn-success mb-3">Add New Test</a>
    @endif

    @if($tests->count())
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th class="truncate-col">Description</th>
                    <th>Cost (PKR)</th>
                    <th class="truncate-col">Preparation</th>
                    <th>Details</th>
                    @if(session('user_role') === 'admin')
                        <th>Admin Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $test->name }}</td>
                        <td class="truncate-col" title="{{ $test->description }}">{{ $test->description }}</td>
                        <td>{{ number_format($test->cost, 2) }}</td>
                        <td class="truncate-col" title="{{ $test->preparation_instructions }}">{{ $test->preparation_instructions }}</td>
                        <td>
                            <a href="{{ route('tests.show', $test->id) }}" class="btn btn-info btn-sm">View Details</a>
                        </td>
                        @if(session('user_role') === 'admin')
                            <td>
                                <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tests.destroy', $test->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tests available.</p>
    @endif
</div>

{{-- Custom CSS --}}
<style>
    /* Truncate long text and show ellipsis */
    .truncate-col {
        max-width: 200px; /* adjust width as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    

    /* Button spacing */
    .btn-sm {
        margin-right: 5px;
    }
</style>
@endsection
