@extends('base')

@section('content')
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4">Edit Test: {{ $test->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- The form action must point to the update route and use the PUT method --}}
    <form action="{{ route('tests.update', $test->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- This tells Laravel to treat the request as a PUT for resource updating --}}
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            {{-- Use old() helper to repopulate on error, otherwise use $test->name --}}
            <input type="text" name="name" id="name" class="form-control" 
                   value="{{ old('name', $test->name) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $test->description) }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="cost" class="form-label">Cost (PKR)</label>
            <input type="number" name="cost" id="cost" class="form-control" 
                   value="{{ old('cost', $test->cost) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="preparation_instructions" class="form-label">Preparation Instructions</label>
            <textarea name="preparation_instructions" id="preparation_instructions" class="form-control">{{ old('preparation_instructions', $test->preparation_instructions) }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active" class="form-control" required>
                {{-- Check current value for 'Active' (1) --}}
                <option value="1" {{ old('is_active', $test->is_active) == 1 ? 'selected' : '' }}>Active</option>
                {{-- Check current value for 'Inactive' (0) --}}
                <option value="0" {{ old('is_active', $test->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Test</button>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection