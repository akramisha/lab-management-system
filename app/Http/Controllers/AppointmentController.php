<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Register;
class AppointmentController extends Controller
{
    //----------------------------------------------------------------------------------------
    // Helper function to check patient access
    protected function checkPatientAccess(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $role = $request->session()->get('user_role');

        if (!$userId || $role !== 'patient') {
            return redirect()->route('login.form')->with('error', 'Please log in as a patient to book an appointment.');
        }
        return null;
    }
//----------------------------------------------------------------------------------------
// crud for patient to book appointment
    public function create(Request $request)
{
    if ($response = $this->checkPatientAccess($request)) {
        return $response;
    }

    $availableTests = Test::all();
    $patient = Register::find($request->session()->get('user_id'));

    return view('patient.appointments.create', compact('availableTests', 'patient'));
}


    public function store(Request $request)
    {
        if ($response = $this->checkPatientAccess($request)) {
            return $response;
        }

        $request->validate([
            'test_id' => 'required|exists:tests,id', 
        ]);

        $patientId = $request->session()->get('user_id');

        Appointment::create([
            'patient_id' => $patientId,
            'test_id' => $request->test_id, 
            'appointment_date' => null, 
            'appointment_time' => null, 
            'status' => 'new', 
            'test_type' => $request->test_type,

        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment requested successfully! Awaiting admin approval and scheduling.');
    }

    public function edit($id)
{
    $appointment = Appointment::with('patient')->findOrFail($id);
    $employees = Register::where('role', 'employee')->get();
    $testDetail = Test::where('id', $appointment->test_id)->first();
    return view('admin.appointments.edit', compact('appointment', 'employees', 'testDetail'));
}

public function history(Request $request)
{
    if ($response = $this->checkPatientAccess($request)) {
        return $response;
    }
    $patientId = $request->session()->get('user_id');
    $appointments = Appointment::with(['test', 'employee'])
                               ->where('patient_id', $patientId)
                               ->orderBy('created_at', 'desc')
                               ->get();
    return view('patient.appointments.history', compact('appointments'));
}

public function cancel(Request $request, $id)
{
    if ($response = $this->checkPatientAccess($request)) {
        return $response;
    }
    $appointment = Appointment::where('patient_id', $request->session()->get('user_id'))
                              ->where('id', $id)
                              ->firstOrFail();
    if(!in_array($appointment->status, ['new', 'approved'])) {
        return redirect()->back()->with('error', 'You cannot cancel this appointment.');
    }
    $appointment->update(['status' => 'cancelled']);
    return redirect()->back()->with('success', 'Appointment cancelled successfully.');
}


public function uploadedReports(Request $request)
{
    $patientId = $request->session()->get('user_id');

    $reports = Appointment::where('patient_id', $patientId)
        ->whereNotNull('report_file') 
        ->with(['test'])
        ->get();
    return view('patient.reports', compact('reports'));
}


}
