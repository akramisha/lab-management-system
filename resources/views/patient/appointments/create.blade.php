@extends('base')

@section('content')
<div class="container mx-auto p-6">
    {{-- Update Alpine.js data block to use the PHP variable and only store details for viewing --}}
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-2xl p-8" x-data="{ 
        selectedTestId: null, 
        tests: @json($availableTests ?? []) 
    }">
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-6 border-b pb-2">Request a New Appointment</h1>
        <p class="text-gray-600 mb-8">Please confirm your details and select the test you require. The admin will schedule the date, time, and assign an employee after reviewing your request.</p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointment.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- 1. Patient Name (Read-Only) --}}
            <div>
                <label for="patient_name" class="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" value="{{ $patient->name ?? session('user_name') }}" readonly
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-100 cursor-not-allowed">
                <p class="mt-1 text-xs text-gray-500">Your name is pre-filled from your registration details.</p>
            </div>

            {{-- 2. Patient Contact Number (Read-Only) --}}
            <div>
                <label for="patient_contact" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                {{-- Assuming $patient is available or fetching from session if $patient->contact exists --}}
                <input type="text" id="patient_contact" name="patient_contact" value="{{ $patient->contact ?? 'N/A' }}" readonly
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-100 cursor-not-allowed">
                <p class="mt-1 text-xs text-gray-500">Your contact number is pre-filled from your registration details.</p>
            </div>
            
            <hr class="border-gray-200">

            {{-- 3. Requested Test Type (Dynamic) --}}
            <div>
                <label for="test_id" class="block text-sm font-medium text-gray-700 mb-2">Requested Test Type</label>
                <select id="test_id" name="test_id" required
        x-model.number="selectedTestId"
        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
    <option value="" disabled selected>-- Select Available Test --</option>

    @foreach ($availableTests as $test)
        <option value="{{ $test->id }}" 
                data-description="{{ $test->description }}" 
                data-price="{{ $test->price }}"
                {{ old('test_id') == $test->id ? 'selected' : '' }}>
            {{ $test->name }}
        </option>
    @endforeach
</select>

{{-- ⭐ Hidden field to send test name / type --}}
<input 
    type="hidden" 
    name="test_type"
    x-model="tests.find(t => t.id == selectedTestId)?.name"
>

                @error('test_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{--- Test Details Section (Visible only when a test is selected) ---}}
            <div x-show="selectedTestId" x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-lg shadow-inner">
                <h3 class="text-xl font-bold text-indigo-800 mb-2">Test Details</h3>
                
                {{-- Find the selected test's details based on the selected ID --}}
                <template x-for="test in tests" x-if="test.id == selectedTestId" :key="'detail-' + test.id">
                    <div>
                        <p class="text-sm text-gray-700 mb-2" x-text="test.description"></p>
                        <p class="text-md font-semibold text-indigo-900">
                            Price: <span x-text="'PKR ' + test.price.toLocaleString()"></span>
                        </p>
                    </div>
                </template>
            </div>
            {{--- End Test Details Section ---}}
            
            <hr class="border-gray-200">

            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out transform hover:scale-[1.01]">
                Submit Appointment Request
            </button>
        </form>
    </div>
</div>
@endsection