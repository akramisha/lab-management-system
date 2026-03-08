@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Uploaded Medical Reports</h2>

    @if($reports->isEmpty())
        <p>No reports uploaded yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Appointment Date</th>
                    <th>Report</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $appointment)
                    <tr>
                        <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>
                            @if($appointment->report_file)
                                <a href="{{ asset('storage/' . $appointment->report_file) }}" target="_blank">View Report</a>
                            @else
                                No report
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
