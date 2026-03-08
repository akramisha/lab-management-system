@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Total Reports Uploaded</h2>

    @if($appointments->isEmpty())
        <div class="alert alert-info">No reports uploaded yet.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Appointment Date</th>
                    <th>Report</th>
                </tr>
            </thead>
            <tbody>

                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->test->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        <a href="{{ asset('storage/reports/' . $appointment->report_file) }}" target="_blank">
                            View Report
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    @endif
</div>
@endsection
