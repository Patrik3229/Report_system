{{-- Loop through each report and create a table row --}}
<script>
    console.log("Been here");
</script>

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