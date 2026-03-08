@extends('base')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">{{ $test->name }} Details</h2>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h4 class="text-primary">Test Name</h4>
                <p class="lead">{{ $test->name }}</p>
            </div>

            <hr>

            <div class="mb-4">
                <h4 class="text-primary">Detailed Description</h4>
                {{-- nl2br converts newlines in the database field to line breaks for display --}}
                <p>{!! nl2br(e($test->description)) !!}</p>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <h4 class="text-primary">Cost</h4>
                    <p class="lead font-weight-bold text-success">PKR {{ number_format($test->cost, 2) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h4 class="text-primary">Status</h4>
                    {{-- Assuming 'is_active' is available from your Test model, as it is in create.blade.php --}}
                    <p class="lead">{{ $test->is_active == 1 ? 'Active' : 'Inactive' }}</p> 
                </div>
            </div>
            
            <hr>

            <div class="mb-4">
                <h4 class="text-primary">Preparation Instructions</h4>
                <p>{!! nl2br(e($test->preparation_instructions)) !!}</p>
            </div>

            <a href="{{ route('tests.index') }}" class="btn btn-secondary">Back to Test List</a>
        </div>
    </div>
</div>
@endsection