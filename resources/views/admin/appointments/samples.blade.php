@extends('base')

@section('content')
<div class="container mt-5">

    <h2>Total Samples Received</h2>

    @if($appointments->isEmpty())

        <p>No samples received yet.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Collected By</th>
                    <th>Collected At</th>
                    <th>Report File</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($samples as $sample)
                    <tr>
                        <td>{{ $sample->patient->name }}</td>
                        <td>{{ $sample->test->name }}</td>
                        <td>{{ $sample->employee->name ?? 'N/A' }}</td>
                        <td>{{ $sample->collected_at ?? '-' }}</td>

                        <td>
                            @if ($sample->report_file)
                                <a href="{{ asset('storage/' . $sample->report_file) }}"
                                   target="_blank" class="btn btn-primary btn-sm">
                                    View Report
                                </a>
                            @else
                                No File
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-success">{{ $sample->status }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
