<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard(Request $request)
    {
        $patientId = $request->session()->get('user_id');
        $totalAppointments = Appointment::where('patient_id', $patientId)->count();
        $upcomingAppointments = Appointment::with(['test','employee'])
            ->where('patient_id', $patientId)
            ->whereIn('status', ['approved','sample_collected'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        $reportsCount = Appointment::where('patient_id', $patientId)
            ->where('status', 'report_uploaded')
            ->count();

        return view('patient.dashboard', compact(
            'totalAppointments',
            'upcomingAppointments',
            'reportsCount'
        ));
    }
}
