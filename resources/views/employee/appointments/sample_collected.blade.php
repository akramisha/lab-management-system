@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Samples Collected</h2>

    
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
            @if($appointments->isEmpty())
        <p>No samples collected yet.</p>
    @else
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                        <td>
    @if($appointment->status === 'approved')
        <form action="{{ route('employee.appointments.collect', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success">Mark as Collected</button>
        </form>
    @elseif($appointment->status === 'sample_collected')
        <span class="badge bg-success">Collected</span>
    @endif
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
