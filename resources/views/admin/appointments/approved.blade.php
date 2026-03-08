@extends('base')

@section('content')
<div class="container mt-5">
    <h2>Approved Appointments</h2>
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Patient Name</th>
                <th class="border px-4 py-2">Test Name</th>
                <th class="border px-4 py-2">Assigned Employee</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td class="border px-4 py-2">{{ $appointment->patient->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $appointment->test->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $appointment->employee->name ?? 'Unassigned' }}</td>
                    <td class="border px-4 py-2">{{ $appointment->appointment_date ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $appointment->appointment_time ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center">No approved appointments yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
