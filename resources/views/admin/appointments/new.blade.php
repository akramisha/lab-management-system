@extends('base')

@section('content')
<div class="container mt-5">
    <h2>New Appointment Requests (Awaiting Scheduling)</h2>

    @if ($appointments->isEmpty())
        <div class="alert alert-info" role="alert">
            No new appointment requests currently available.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Requested Test</th>
                    <th>Requested On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        {{-- Access patient name via the 'patient' relationship (ensure you have the 'patient' relationship in Appointment model) --}}
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        {{-- Access test name via the 'test' relationship (ensure you have the 'test' relationship in Appointment model) --}}
                        <td>{{ $appointment->test->name ?? $appointment->test_type ?? 'N/A' }}</td> 
                        <td>{{ $appointment->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            {{-- You will create this route/view later to handle scheduling --}}
                            {{-- {{ route('admin.appointments.edit', $appointment->id) }} --}}
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm">Schedule / Assign</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection