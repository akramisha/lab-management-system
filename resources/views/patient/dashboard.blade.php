@extends('base')

@section('content')
<style>
    .dashboard-cards {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(4, 1fr);
        margin-top: 20px;
    }
    @media (max-width: 1200px) { .dashboard-cards { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .dashboard-cards { grid-template-columns: 1fr; } }

    .card {
        border-radius: 12px;
        border-left: 5px solid;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        min-height: 140px;
        padding: 15px;
    }
    .card:hover { transform: translateY(-5px); }
    .card-title { font-size: 2rem; font-weight: bold; margin-bottom: 10px; }
    .btn-link { text-decoration: none; padding: 5px 10px; border-radius: 5px; color: white; }
    .btn-blue { background-color: #007bff; }
    .btn-green { background-color: #28a745; }
    .btn-yellow { background-color: #ffc107; color: #333; }
    .btn-red { background-color: #dc3545; }
</style>

<div class="container mt-5">
    <h1>Welcome, {{ session('user_name') }}!</h1>
    <p>Here is a summary of your appointments and available actions.</p>

    <div class="dashboard-cards">
        {{-- Total Appointments Requested --}}
        <div class="card" style="border-left-color: #007bff;">
            <div class="card-title">{{ $totalAppointments ?? 0 }}</div>
            <div>Total Appointments</div>
            <a href="{{ route('appointment.history') }}" class="btn-link btn-blue mt-2 d-block">View History</a>
        </div>

        {{-- Upcoming Appointments --}}
        <div class="card" style="border-left-color: #ffc107;">
            <div class="card-title">{{ $upcomingAppointments->count() ?? 0 }}</div>
            <div>Upcoming Appointments</div>
            <a href="{{ route('appointment.history') }}" class="btn-link btn-yellow mt-2 d-block">View Details</a>
        </div>

        {{-- Completed / Reports --}}
        <div class="card" style="border-left-color: #28a745;">
            <div class="card-title">{{ $reportsCount ?? 0 }}</div>
            <div>Reports Available</div>
            <a href="{{ route('appointment.history') }}" class="btn-link btn-green mt-2 d-block">View Reports</a>
        </div>

        {{-- Book a New Appointment --}}
        <div class="card" style="border-left-color: #dc3545;">
            <div class="card-title">+</div>
            <div>Book New Appointment</div>
            <a href="{{ route('appointment.create') }}" class="btn-link btn-red mt-2 d-block">Book Now</a>
        </div>
    </div>

    {{-- Optional: Upcoming Appointments Table --}}
    <div class="mt-5">
        <h2>Upcoming Appointments</h2>
        @if($upcomingAppointments->isEmpty())
            <p>No upcoming appointments.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Assigned Employee</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upcomingAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->test->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->employee->name ?? 'Not Assigned' }}</td>
                            <td>{{ $appointment->appointment_date ?? '-' }}</td>
                            <td>{{ $appointment->appointment_time ?? '-' }}</td>
                            <td>{{ ucfirst($appointment->status) }}</td>
                            <td>
                                @if($appointment->status === 'report_uploaded' && $appointment->report_file)
                                    <a href="{{ asset('storage/'.$appointment->report_file) }}" target="_blank">View Report</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
