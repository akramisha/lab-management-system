@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Uploaded Reports</h2>
    <p>Below are all appointments for which reports have been uploaded.</p>

    
        <table class="table table-bordered table-striped">
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
            @if($appointments->isEmpty())
        <div class="alert alert-info">No reports uploaded yet.</div>
    @else
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
                        <td>
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
