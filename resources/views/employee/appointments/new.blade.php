@extends('base')

@section('content')

<div class="container mt-5">
    <h2>Assigned Appointments</h2>
    <p>Below are the appointments assigned to you by the admin.</p>

    @if($assignedAppointments->isEmpty())
    <div class="alert alert-info mt-4">
        No appointments have been assigned yet.
    </div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Test Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                    <td>
    <form action="{{ route('employee.appointments.updateStatus', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="status" class="form-select">
            <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="delayed" {{ $appointment->status == 'delayed' ? 'selected' : '' }}>Delayed</option>
            <option value="rescheduled" {{ $appointment->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-primary mt-1">Update Status</button>
        <button type="submit" name="collected" value="1" class="btn btn-success mt-1">Mark as Collected</button>
    </form>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</div>

@endsection
