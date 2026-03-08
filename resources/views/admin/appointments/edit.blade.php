@extends('base')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Schedule Appointment #{{ $appointment->id }}</h2>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- PATIENT & TEST DETAILS --}}
<h4 class="mb-3 text-primary border-bottom pb-2">Appointment Details</h4>
<div class="row mb-4">
    <div class="col-md-6">
        <p><strong>Patient Name:</strong> {{ $appointment->patient->name ?? 'N/A' }}</p>
        <p><strong>Patient Contact:</strong> {{ $appointment->patient->contact ?? 'N/A' }}</p>
    </div>
    <div class="col-md-6">
    {{-- Use the fetched $testDetail for name and cost --}}
    <p><strong>Requested Test:</strong> <span class="badge bg-info text-dark">{{ $testDetail->name ?? $appointment->test_type ?? 'N/A' }}</span></p>
    <p>
        <strong>Test Price:</strong> PKR 
        {{-- Use $testDetail->cost --}}
        {{ number_format($testDetail->cost ?? 0, 2) }}
    </p>
</div>
<div class="col-12 mt-2">
    {{-- Use the fetched $testDetail for description --}}
    <p class="text-muted small"><strong>Test Description:</strong> {{ $testDetail->description ?? 'No description available.' }}</p>
</div>

                {{-- SCHEDULING FORM --}}
                <h4 class="mb-3 text-success border-bottom pb-2">Scheduling and Assignment</h4>
                
                <div class="row">
                    {{-- 1. Employee Assignment --}}
                    <div class="col-md-4 mb-3">
                        <label for="employee_id" class="form-label">Assign Employee</label>
                        <select id="employee_id" name="employee_id" class="form-select @error('employee_id') is-invalid @enderror">
                            <option value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. Date --}}
                    <div class="col-md-4 mb-3">
                        <label for="appointment_date" class="form-label">Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" 
                               value="{{ old('appointment_date') }}">
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Time --}}
                    <div class="col-md-4 mb-3">
                        <label for="appointment_time" class="form-label">Appointment Time</label>
                        <input type="time" id="appointment_time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" 
                               value="{{ old('appointment_time') }}">
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 4. Admin Notes (Optional) --}}
                <div class="mb-4">
                    <label for="admin_notes" class="form-label">Admin Notes (Internal)</label>
                    <textarea id="admin_notes" name="admin_notes" class="form-control" rows="3">{{ old('admin_notes') }}</textarea>
                </div>
                
                {{-- ACTION BUTTONS --}}
                <div class="d-flex  pt-3 border-top">
                    
                    {{-- Approve/Schedule --}}
                    <button type="submit" name="action" value="approve" class="btn btn-success btn-md me-2" onclick="return confirm('Are you sure you want to Approve and Schedule this appointment?');">
                        Approve & Schedule
                    </button>

                    {{-- Reject --}}
                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-md me-2" onclick="return confirm('Are you sure you want to Reject this request?');">
                        Reject
                    </button>

                    {{-- Cancel --}}
                    <button type="submit" name="action" value="cancel" class="btn btn-secondary btn-md" onclick="return confirm('Are you sure you want to Cancel this request? (Only use if necessary)');">
                        Cancel
                    </button>
                </div>
                
                <a href="{{ route('admin.appointments.new') }}" class="btn btn-link mt-3" style="color:darkblue">Back to New Appointments</a>

            </form>
        </div>
    </div>
</div>
@endsection