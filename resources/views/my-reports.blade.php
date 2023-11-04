<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Reports
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="table-auto whitetext" id="reportstable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Perpetrator Name</th>
                    <th>Reporter Name</th>
                    <th>Submitted Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ optional($report->perpetrator)->name ?? 'Deleted account' }}</td>
                        <td>{{ optional($report->reporter)->name ?? 'Deleted account' }}</td>
                        <td>{{ $report->submitted_time }}</td>
                        <td>{{ $report->report_status }}</td>
                        <td>
                            <form action="{{ route('report.view', $report->id) }}" method="GET" style="display: inline;">
                                <button type="submit" class="button-link">View Report</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>