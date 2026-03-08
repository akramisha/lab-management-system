@extends('base')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Edit Employee: {{ $employee->name }}</h2>
        </div>

        <div class="card-body">
            {{-- Error Display --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $employee->name) }}" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $employee->email) }}" required>
                </div>

                {{-- Contact --}}
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact Number</label>
                    <input type="text" name="contact" id="contact" class="form-control" 
                           value="{{ old('contact', $employee->contact) }}">
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="employee" {{ old('role', $employee->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="patient" {{ old('role', $employee->role) == 'patient' ? 'selected' : '' }}>Patient</option>
                        {{-- Add more roles if needed --}}
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.employees') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Optional: Add subtle hover effect on inputs */
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
        border-color: #0d6efd;
    }

    /* Rounded card and shadow */
    .card {
        border-radius: 0.75rem;
    }

    /* Make card header stand out */
    .card-header {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        font-size: 1.25rem;
    }

    /* Button spacing on small screens */
    @media (max-width: 576px) {
        .d-flex.justify-content-end.gap-2 {
            flex-direction: column;
        }
        .d-flex.justify-content-end.gap-2 .btn {
            width: 100%;
        }
    }
</style>
@endsection
