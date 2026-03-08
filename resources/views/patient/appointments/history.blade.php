@extends('base')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">My Appointment History</h1>

    @if($appointments->isEmpty())
        <p class="text-gray-600">You have not requested any appointments yet.</p>
    @else
        <table class="w-full table-auto border border-gray-300 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Test Name</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Scheduled Date & Time</th>
                    <th class="px-4 py-2">Assigned Employee</th>
                    <th class="px-4 py-2">Admin Notes</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2">{{ $appt->test->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($appt->status) }}</td>
                        <td class="px-4 py-2">
                            @if($appt->status === 'approved')
                                {{ $appt->appointment_date }} at {{ $appt->appointment_time }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $appt->employee->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $appt->admin_notes ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if($appt->status === 'new' || $appt->status === 'approved')
                                <form action="{{ route('appointment.cancel', $appt->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-500 hover:underline">Cancel</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
