<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Appointment; 

class AdminController extends Controller
{
    
    //----------------------------------------------------------------------------------------
    // Helper function to check admin access.
    protected function checkAdminAccess(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $role = $request->session()->get('user_role');

        if (!$userId || $role !== 'admin') {
            return redirect()->route('login.form')->with('error', 'Unauthorized access.');
        }
        return null;
    }

    //----------------------------------------------------------------------------------------
    // ADMIN DASHBOARD AND USER/EMPLOYEE MANAGEMENT

    public function dashboard(Request $request)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $totalUsers = Register::where('role', 'patient')->count();
        $totalEmployees = Register::where('role', 'employee')->count();

        $totalNewAppointments = Appointment::where('status', 'new')->count();
        $totalApprovedAppointments = Appointment::where('status', 'approved')->count();
        $totalRejectedAppointments = Appointment::where('status', 'rejected')->count();
        $totalCancelledAppointments = Appointment::where('status', 'cancelled')->count();
        $totalSampleReceived = Appointment::where('status', 'sample_received')->count();
        $totalReportUpload = Appointment::where('status', 'report_uploaded')->count(); 
        $totalSamplesReceived = Appointment::where('status', 'report_uploaded')->count();

        $data = [
            'totalUsers' => $totalUsers,
            'totalEmployees' => $totalEmployees,
            'totalNewAppointments' => $totalNewAppointments,
            'totalApprovedAppointments' => $totalApprovedAppointments,
            'totalRejectedAppointments' => $totalRejectedAppointments,
            'totalCancelledAppointments' => $totalCancelledAppointments,
            'totalSampleReceived' => $totalSampleReceived,
            'totalReportUpload' => $totalReportUpload, 
        ];

        return view('admin.dashboard', $data); 
    }

    //----------------------------------------------------------------------------------------
    // USER AND EMPLOYEE MANAGEMENT VIEWS

    public function showUsers(Request $request)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $patients = Register::where('role', 'patient')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', ['users' => $patients]);
    }

    public function showEmployees(Request $request)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $employees = Register::where('role', 'employee')->get();
        // Assuming your index file uses a variable named $users or $employees
        return view('admin.employees.index', ['users' => $employees]); 
    }

    // Shows the edit form
    public function editEmployee(Request $request, Register $employee) // Assumes Route Model Binding for Register
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }
        
        // Ensure the fetched user is an employee before editing
        if ($employee->role !== 'employee') {
            return redirect()->route('admin.employees')->with('error', 'User is not an employee.');
        }

        return view('admin.employees.edit', compact('employee'));
    }

    // Handles the form submission for update
    public function updateEmployee(Request $request, Register $employee)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:registers,email,' . $employee->id,
            'contact' => 'nullable|string|max:20',
            // Allow changing the role, but you might want to restrict this later
            'role' => 'required|in:employee,patient', 
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.employees')->with('success', 'Employee details updated successfully.');
    }

    // Handles the deletion of an employee
    public function destroyEmployee(Request $request, Register $employee)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        if ($employee->role !== 'employee') {
            return redirect()->route('admin.employees')->with('error', 'Cannot delete a user who is not an employee.');
        }

        $employee->delete();

        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully.');
    }

    //----------------------------------------------------------------------------------------
    // --- GENERIC APPOINTMENT DETAIL VIEWS ---

    protected function fetchAppointmentsByStatus(Request $request, string $status, string $viewName)
{
    if ($response = $this->checkAdminAccess($request)) {
        return $response;
    }

    $appointments = Appointment::with(['patient', 'test', 'employee'])
        ->where('status', $status)
        ->orderBy('created_at')
        ->get();

    return view($viewName, compact('appointments'));
}


    //----------------------------------------------------------------------------------------
     // Show all appointments (new, approved, rejected, cancelled, sample received, report uploaded)
     
    public function showNewAppointments(Request $request)
    {
        // Fetch employees needed for the "Review & Schedule" button
        $employees = Register::where('role', 'employee')->get();
        
        $appointments = Appointment::with(['patient', 'test'])
                                   ->where('status', 'new')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('admin.appointments.new', compact('appointments', 'employees'));
    }

    public function showAppointmentsApproved(Request $request)
    {
        return $this->fetchAppointmentsByStatus($request, 'approved', 'admin.appointments.approved');
    }

    public function showRejectedAppointments(Request $request)
    {
        return $this->fetchAppointmentsByStatus($request, 'rejected', 'admin.appointments.rejected');
    }

    public function showCancelledAppointments(Request $request)
    {
        return $this->fetchAppointmentsByStatus($request, 'cancelled', 'admin.appointments.cancelled');
    }

    public function showAppointmentsSampleReceived(Request $request)
    {
        return $this->fetchAppointmentsByStatus($request, 'sample_received', 'admin.appointments.samples');
    }

    public function showAppointmentsReportUpload(Request $request)
    {
        return $this->fetchAppointmentsByStatus($request, 'report_uploaded', 'admin.appointments.reports');
    }

    //----------------------------------------------------------------------------------------
    // --- APPOINTMENT ACTION LOGIC ---

    public function editAppointment(Request $request, Appointment $appointment)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $appointment->load(['patient', 'test']);
        $employees = Register::where('role', 'employee')->orderBy('name')->get();
        return view('admin.appointments.edit', compact('appointment', 'employees'));
    }

    
    public function updateAppointment(Request $request, Appointment $appointment)
    {
        if ($response = $this->checkAdminAccess($request)) {
            return $response;
        }

        $validated = $request->validate([
            'action' => 'required|in:approve,reject,cancel',
            'employee_id' => 'nullable|exists:registers,id',
            'appointment_date' => 'nullable|date',
            'appointment_time' => 'nullable|date_format:H:i',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $status = $validated['action'];
        $message = '';

        if ($status === 'approve') {
            $request->validate([
                'employee_id' => 'required|exists:registers,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required|date_format:H:i',
            ]);

            $appointment->update([
                'employee_id' => $validated['employee_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'status' => 'approved',
            ]);
            $message = 'Appointment scheduled and approved successfully.';

        } elseif ($status === 'reject') {
            $appointment->update(['status' => 'rejected']);
            $message = 'Appointment rejected successfully.';

        } elseif ($status === 'cancel') {
            $appointment->update(['status' => 'cancelled']);
            $message = 'Appointment cancelled successfully.';
        }

        return redirect()->route('admin.appointments.new')->with('success', $message);
    }

    //----------------------------------------------------------------------------------------
    // Samples Received View
    public function samplesReceived()
{
    $samples = Appointment::with(['patient', 'test', 'employee'])
        ->where('status', 'report_uploaded')
        ->orderBy('collected_at', 'desc')
        ->get();

    return view('admin.samples_received', compact('samples'));
}

//----------------------------------------------------------------------------------------
    // Show the report upload form
public function showUploadReportForm(Appointment $appointment)
    {
        return view('employee.upload_report', compact('appointment'));
    }
    //----------------------------------------------------------------------------------------
    // Handle the report upload
    public function uploadReport(Request $request, Appointment $appointment)
    {
        $request->validate([
            'report' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('report');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('reports', $fileName, 'public');

        $appointment->update([
            'report_file' => $fileName,
            'status' => 'report_uploaded',
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Report uploaded successfully.');
    }

    public function totalReports()
{
    $reports = Appointment::with(['patient', 'test', 'employee'])
                ->whereNotNull('report_file')
                ->orderBy('created_at', 'desc')
                ->get();

    return view('admin.appointments.reports', compact('reports'));
}


//----------------------------------------------------------------------------------
// file uploaded save in folder
public function storeReport(Request $request)
{
    $destination = public_path('storage/reports');

    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $filename = time() . '.' . $request->file('report')->getClientOriginalExtension();

    $request->file('report')->move($destination, $filename);

    return back()->with('success', 'Report uploaded successfully!');
}

}