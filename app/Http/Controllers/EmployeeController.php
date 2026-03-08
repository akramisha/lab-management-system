<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class EmployeeController extends Controller
{

    public function dashboard(Request $request)
{
    $employeeId = $request->session()->get('user_id');

// New Assigned appointments (approved but not yet collected)
$newAssignedCount = Appointment::where('employee_id', $employeeId)
    ->where('status', 'approved')
    ->count();

// Sample Collected
$sampleCollectedCount = Appointment::where('employee_id', $employeeId)
    ->where('status', 'sample_collected')
    ->count();

// Reports Uploaded
$sampleSentCount = Appointment::where('employee_id', $employeeId)
    ->where('status', 'report_uploaded')
    ->count();

// Total assigned appointments (all statuses except rejected?)
$totalAppointments = Appointment::where('employee_id', $employeeId)
    ->count();

return view('employee.dashboard', compact(
    'newAssignedCount',
    'sampleCollectedCount',
    'sampleSentCount',
    'totalAppointments'
));

}

    // Show new assigned appointments
    // Show assigned appointments (new)
public function newAppointments(Request $request)
{
    $employeeId = $request->session()->get('user_id');
    $assignedAppointments = Appointment::with(['patient', 'test'])
    ->where('employee_id', $employeeId)
    ->where('status', 'approved') // only approved, not collected yet
    ->get();

    return view('employee.appointments.new', compact('assignedAppointments'));
}

// Mark sample as collected
public function collectSample(Appointment $appointment, Request $request)
{
    $employeeId = $request->session()->get('user_id');
    if ($appointment->employee_id != $employeeId) {
        return redirect()->back()->with('error','Not authorized.');
    }
    $appointment->update([
        'status' => 'sample_collected',
        'collected_at' => now(),
    ]);
    return redirect()->back()->with('success','Sample collected.');
}

// Show collected samples
public function sampleCollected(Request $request)
{
    $employeeId = $request->session()->get('user_id');

    $appointments = Appointment::with(['patient','test'])
        ->where('employee_id', $employeeId)
        ->where('status','sample_collected') // <-- only collected
        ->get();

    return view('employee.appointments.sample_collected', compact('appointments'));
}




    // Show report upload page
    public function reportUpload()
{
    // List all appointments assigned to this employee that are ready for report upload
    $appointments = Appointment::with(['patient', 'test'])
        ->where('employee_id', session('user_id'))
        ->where('status', 'sample_collected')
        ->orderBy('appointment_date', 'desc')
        ->get();

    return view('employee.appointments.reports', compact('appointments'));
}


    // Appointment history (all assigned appointments)
    public function appointmentHistory(Request $request)
    {
        $employeeId = $request->session()->get('user_id');

    // Fetch all assigned appointments
    $appointments = Appointment::with(['patient', 'test'])
        ->where('employee_id', $employeeId)
        ->orderBy('appointment_date', 'asc')
        ->get();

    return view('employee.appointments.history', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
{
    $employeeId = $request->session()->get('user_id');

    if ($appointment->employee_id != $employeeId) {
        return redirect()->back()->with('error', 'You are not authorized.');
    }

    // If collected button clicked, mark as collected
    if ($request->has('collected')) {
        $appointment->update([
            'status' => 'sample_collected',
            'collected_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Sample marked as collected.');
    }

    // Otherwise update status normally
    $validated = $request->validate([
        'status' => 'required|string|in:approved,delayed,rescheduled,cancelled',
    ]);

    $appointment->update([
        'status' => $validated['status'],
    ]);

    return redirect()->back()->with('success', 'Status updated successfully.');
}

// Show appointments ready for report upload
public function showUploadReport()
{
    // Fetch only appointments that are collected but report not uploaded yet
    $appointments = Appointment::with(['patient', 'test'])
        ->where('status', 'sample_collected')
        ->whereNull('report_file') // only show if report is not uploaded
        ->get();

    return view('employee.appointments.upload_report', compact('appointments'));
}


public function reports()
{
    $appointments = Appointment::with(['patient','test'])
        ->where('employee_id', session('user_id')) // only the logged-in employee
        ->where('status', 'report_uploaded')
        ->get();

    return view('employee.appointments.report', compact('appointments'));
}

public function showUploadReportForm(Appointment $appointment)
{
    $appointments = collect([$appointment]); // wrap in a collection
    return view('employee.appointments.upload_report', compact('appointments'));
}


public function uploadReport(Request $request, Appointment $appointment)
{
    $request->validate([
        'report' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
    ]);

    $file = $request->file('report');

    // Generate unique filename
    $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

    // Store in storage/app/public/reports
    $file->storeAs('public/reports', $fileName);

    // **Update appointment with the filename**
    $appointment->update([
        'report_file' => $fileName,
        'status' => 'report_uploaded',
    ]);

    return redirect()->route('employee.appointments.history')
                     ->with('success', 'Report uploaded successfully!');
}

}
