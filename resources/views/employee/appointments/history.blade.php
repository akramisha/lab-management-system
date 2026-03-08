@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Total Assigned Appointments</h2>
    <p>Below are all appointments assigned to you.</p>

    @if($appointments->isEmpty())
        <div class="alert alert-info">No appointments assigned yet.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Status</th>
                    <th>Uploaded Report</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                        </td>
                        {{-- <td>
                            @if($appointment->report_file)
                                <a href="{{ asset('storage/reports/' . $appointment->report_file) }}" target="_blank">

                                    View Report
                                </a>
                            @else
                                <span class="text-muted">No report</span>
                            @endif
                        </td>
                        <td>
                            @if($appointment->status === 'sample_collected')
                                <a href="{{ route('employee.appointments.upload_report', $appointment->id) }}" class="btn btn-primary btn-sm">
                                    Upload Report
                                </a>
                            @elseif($appointment->status === 'approved')
                                <form action="{{ route('employee.appointments.collect', $appointment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Mark as Collected</button>
                                </form>
                            @else
                                <span class="text-muted">No actions</span>
                            @endif
                        </td> --}}

                        <td>
    @if($appointment->report_file)
        <span class="text-success">Report Uploaded</span>
    @else
        <span class="text-muted">No report</span>
    @endif
</td>
<td>
    @if($appointment->report_file)
        <a href="{{ asset('storage/reports/' . $appointment->report_file) }}" target="_blank" class="btn btn-info btn-sm">View</a>
    @else
        <span class="text-muted">No actions</span>
    @endif
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
