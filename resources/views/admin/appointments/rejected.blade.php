@extends('base')

@section('content')
<div class="container mt-5">
    <h2 class="text-3xl font-bold mb-4">Rejected Appointments</h2>
    <p class="text-gray-600 mb-6">
        Below is the list of all appointments that have been rejected by the admin.
    </p>

    @if($appointments->isEmpty())
        <p class="text-gray-500">No rejected appointments found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-red-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Patient Name</th>
                        <th class="px-4 py-2 text-left">Test Name</th>
                        <th class="px-4 py-2 text-left">Requested On</th>
                        <th class="px-4 py-2 text-left">Admin Notes</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                        <tr class="border-t border-gray-200 hover:bg-red-50 transition duration-150">
                            <td class="px-4 py-2">{{ $appt->patient->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $appt->test->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $appt->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-2">{{ $appt->admin_notes ?? '-' }}</td>
                            <td class="px-4 py-2">
                                {{-- Optional: Add action buttons if needed, e.g., view details --}}
                                <a href="{{ route('admin.appointments.edit', $appt->id) }}" 
                                   class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">View/Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
