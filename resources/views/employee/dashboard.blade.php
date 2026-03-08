@extends('base')

@section('content')

    <style>
        /* General styling for the dashboard cards */
        .cont {
            display: grid;
            gap: 20px;
            width: 100%;
            /* Default grid for large screens */
            grid-template-columns: repeat(4, 1fr);
        }

        /* Adjust grid for smaller screens */
        @media (max-width: 1200px) {
            .cont {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .cont {
                grid-template-columns: 1fr;
            }
        }
        
        .div1 .card {
            border-radius: 12px;
            border-left: 5px solid; /* Placeholder, we'll override this */
            transition: transform 0.2s;
            min-height: 150px;
        }

        .div1 .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .card-header {
            font-weight: 600;
            background-color: #f7f7f7;
            border-bottom: 1px solid #eee;
            color: #333;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff; /* Primary color for numbers */
            margin-bottom: 10px;
        }

        /* Color differentiation for cards (using your existing btn classes) */
        .btn1 { background-color: #007bff; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; } /* Blue - Users/Cancelled */
        .btn2 { background-color: #ffc107; color: #333; padding: 5px 10px; border-radius: 5px; text-decoration: none; } /* Yellow - New/Sample */
        .btn3 { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; } /* Green - Approved/Report */
        .btn4 { background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; } /* Red - Rejected/Employee */

        /* Border colors for visual cue */
        .cont > div:nth-child(1) .card { border-left-color: #007bff; } /* Users */
        .cont > div:nth-child(2) .card { border-left-color: #ffc107; } /* New Appointment */
        .cont > div:nth-child(3) .card { border-left-color: #28a745; } /* Approved */
        .cont > div:nth-child(4) .card { border-left-color: #dc3545; } /* Rejected */
        .cont > div:nth-child(5) .card { border-left-color: #007bff; } /* Cancelled */
        .cont > div:nth-child(6) .card { border-left-color: #ffc107; } /* Sample Received */
        .cont > div:nth-child(7) .card { border-left-color: #28a745; } /* Report Upload */
        .cont > div:nth-child(8) .card { border-left-color: #dc3545; } /* Employee */
        
    </style>
    <div class="container mt-5">
        <h1>Welcome, {{ session('user_name') }}!</h1>
    <p>
         Here you can manage users, view reports, and configure system settings.
    </p>
    </div>
    
    <div class="container mt-5 cont">
       <div class="div1">
        <div class="card shadow">
            <div class="card-header">New Assigned Appointments</div>
            <div class="card-body">
                <h5 class="card-title">{{ $newAssignedCount ?? 0 }}</h5>
<a href="{{ route('employee.appointments.new') }}" class="btn1">View Details</a>

            </div>
        </div>
    </div>

    {{-- Sample Collected --}}
    <div class="div1">
    <div class="card shadow">
        <div class="card-header">Sample Collected</div>
        <div class="card-body">
            <h5 class="card-title">{{ $sampleCollectedCount ?? 0 }}</h5>
            <a href="{{ route('employee.appointments.sample_collected') }}" class="btn2">View Details</a>
        </div>
    </div>
</div>

    {{-- Sample sent to Lab / Report Uploaded --}}
    <div class="div1">
    <div class="card shadow">
        <div class="card-header">Reports Uploaded</div>
        <div class="card-body">
            <h5 class="card-title">{{ $sampleSentCount ?? 0 }}</h5>
            <a href="{{ route('employee.appointments.reports') }}" class="btn3">View Details</a>

        </div>
    </div>
</div>

    {{-- Total Appointments --}}
    <div class="div1">
        <div class="card shadow">
            <div class="card-header">Total Assigned Appointments</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalAppointments ?? 0 }}</h5>
                <a href="{{ route('employee.appointments.history') }}" class="btn4">View Details</a>
            </div>
        </div>
    </div>
</div>

    
    
@endsection