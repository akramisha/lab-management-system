@extends('base')

@section('content')
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4">Add New Test</h2>
    <form action="{{ route('tests.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Cost (PKR)</label>
            <input type="number" name="cost" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Preparation Instructions</label>
            <textarea name="preparation_instructions" class="form-control"></textarea>
        </div>
        <div class="mb-3">
    <label>Status</label>
    <select name="is_active" class="form-control" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>

        <button type="submit" class="btn btn-success">Save Test</button>
    </form>
</div>
@endsection
