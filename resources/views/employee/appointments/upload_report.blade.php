@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Upload Reports</h2>

   
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Test</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Upload Report</th>
                </tr>
            </thead>
            @if($appointments->isEmpty())
    <div class="alert alert-info">No appointments ready for report upload.</div>
@else
    
            <tbody>
                @foreach($appointments as $appointment)
<tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                        <td>
        <form action="{{ route('employee.appointments.upload_report.store', $appointment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="report_{{ $appointment->id }}">Upload Report for {{ $appointment->patient->name }}</label>
                <input type="file" name="report" id="report_{{ $appointment->id }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        
    {{-- @endforeach
@endif --}}
                {{-- @foreach($appointments as $appointment)
                    
                          @if($appointment->report_file)
        <div class="alert alert-success">
            Report already uploaded: 
            <a href="{{ asset('storage/reports/' . $appointment->report_file) }}" target="_blank">
                View Report
            </a>
        </div>
    @endif

    <form action="{{ route('employee.appointments.upload_report.store', $appointment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="report" class="form-label">Select Report File</label>
            <input type="file" name="report" id="report" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Report</button>
    </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
