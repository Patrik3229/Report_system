<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Handle reports
        </h2>
    </x-slot>

    <div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ url('/handle-reports') }}" method="GET" style="padding-bottom: 1rem">
            <div class="form-group whitetext">
                <label for="status">Report Status:</label>
                <select name="status" id="reportViewStatus" class="dropdown">
                    <option value="">All</option>
                    <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="Declined" {{ request('status') == 'Declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
        </form>

    
        {{-- Reports table --}}

        <script type="text/javascript">
            var reportsUrl = "{{ url('/handle-reports') }}";
        </script>
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
                            @if ($report->handling_admin_id === auth()->id() && !in_array($report->report_status, ['Accepted', 'Declined']))
                            &nbsp;|&nbsp;
                                <form action="{{ route('report.unclaim', $report->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="button-link">Unclaim Report</button>
                                </form>
                            @elseif (is_null($report->handling_admin_id))
                            &nbsp;|&nbsp;
                                <form action="{{ route('report.claim', $report->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="button-link">Claim Report</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        {{-- Pagination links --}}
        {{ $reports->appends(request()->query())->links() }}
    </div>
    
</x-app-layout>