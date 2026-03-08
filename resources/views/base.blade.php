<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">

    <title>LAB MANAGEMENT SYSTEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
   
    <style>
        /* Custom styles for the navigation, replacing the external styles.css */
        header {
            background-color: #1a202c; /* Dark background */
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        nav li a, .btn-link {
            color: #e2e8f0; /* Light text color */
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }
        nav li a:hover, .btn-link:hover {
            color: #63b3ed; /* Light blue on hover */
        }
        main {
            padding: 2rem 1rem;
        }
        /* Overriding Bootstrap link color for consistency */
        .btn-link.nav-link {
            color: #e2e8f0 !important;
        }
    </style>
</head>
<body>
    
    <header>
        <nav>
            <ul>
                <li><a href="/" style="font-size: 20px; font-weight:bold">LAB</a></li>
            </ul>
            <ul class="nav-list ms-auto">

{{-- Check if ANY user is logged in --}}
@if(session('user_id'))

    {{-- --------------------------------------------------------------------- --}}
    {{-- A. ADMIN NAVIGATION: Full access to system management --}}
    {{-- --------------------------------------------------------------------- --}}
    @if(session('user_role') === 'admin')
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('tests.index') }}">Manage Tests</a></li>
        <li class="nav-item"><a href="{{ route('admin.employees') }}">Manage Employees</a></li>
        <li class="nav-item"><a href="{{ route('admin.appointments.new') }}">All Appointments</a></li> 
        {{-- <li class="nav-item"><a href="{{ route('admin.dashboard') }}">Sales Reports</a></li> Placeholder for reports --}}
        <li class="nav-item"><a href="{{ route('admin.users') }}">Registered Patients</a></li>
        
    {{-- --------------------------------------------------------------------- --}}
    {{-- B. EMPLOYEE NAVIGATION: Access to sample collection and reports --}}
    {{-- --------------------------------------------------------------------- --}}
    @elseif(session('user_role') === 'employee')
        <li class="nav-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('employee.appointments.new') }}">New Assigned Appointments</a></li>
    <li class="nav-item"><a href="{{ route('employee.appointments.sample_collected') }}">Sample Collected</a></li>
    <li class="nav-item"><a href="{{ route('employee.appointments.reports') }}">Reports Uploaded</a></li>
    <li class="nav-item"><a href="{{ route('employee.appointments.history') }}">Appointment History</a></li>

    {{-- --------------------------------------------------------------------- --}}
    {{-- C. PATIENT NAVIGATION: Access to booking and results --}}
    {{-- --------------------------------------------------------------------- --}}
    @elseif(session('user_role') === 'patient')
       <li class="nav-item"><a href="{{ route('patient.dashboard') }}">Dashboard</a></li> <!-- Main page with cards -->
<li class="nav-item"><a href="{{ route('tests.index') }}">Available Tests</a></li> <!-- List of tests -->
<li class="nav-item"><a href="{{ route('appointment.create') }}">Book Appointment</a></li> <!-- Request new appointment -->
<li class="nav-item"><a href="{{ route('appointment.history') }}">Appointment History</a></li> <!-- Past and upcoming appointments -->
<li class="nav-item"><a href="{{ route('patient.reports') }}">Medical Reports</a></li> <!-- Only uploaded reports -->


    @endif
    
    {{-- LOGGED-IN USERS: Common Links --}}
    <li class="nav-item"><a href="{{ route('profile.show') }}">Profile</a></li>

    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            {{-- CRITICAL: Always include @csrf for POST requests --}}
            @csrf 
            <button type="submit" class="btn btn-link nav-link" style="text-decoration:none;">Logout ({{ session('user_name') }})</button>
        </form>
    </li>

{{-- --------------------------------------------------------------------- --}}
{{-- D. GUEST NAVIGATION: No user logged in --}}
{{-- --------------------------------------------------------------------- --}}
@else
    {{-- Guest links should point to login/register forms --}}
    <li class="nav-item"><a href="{{ route('login.form') }}">Admin</a></li> 
    <li class="nav-item"><a href="{{ route('login.form') }}"> Employee</a></li> 
    <li class="nav-item"><a href="{{ route('login.form') }}">Patient</a></li> 
    <li class="nav-item"><a href="{{ route('register.form') }}">Register</a></li>
    <li class="nav-item"><a href="{{ route('tests.index') }}">View Tests</a></li> {{-- Guests can see tests (assumes test index is root or public) --}}
@endif
</ul>

        </nav>
    </header>

    <main>
        @yield('content') 
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>