<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Report against {{ optional($report->perpetrator)->name ?? 'Deleted account' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 whitetext">

        @if(session('error'))
            <div class="whitetext">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="whitetext">
                {{ session('success') }}
            </div>
        @endif
        <table class="table-auto whitetext" id="reportstable">
            <tr>
                <td>ID</td>
                <td>{{ $report->id }}</td>
              </tr>
              <tr>
                <td>Perpetrator Name</td>
                <td>{{ optional($report->perpetrator)->name ?? 'Deleted account' }}</td>
              </tr>
              <tr>
                <td>Reporter Name</td>
                <td>{{ optional($report->reporter)->name ?? 'Deleted account' }}</td>
              </tr>
              <tr>
                <td>Submitted Time</td>
                <td>{{ $report->submitted_time }}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>{{ $report->report_status }}</td>
              </tr>
              <tr>
                <td>Claimed By</td>
                <td>
                    @if ($report->handling_admin_id)
                        {{ optional($report->handlingAdmin)->name ?? 'Admin account deleted' }}
                    @else
                        Unclaimed
                    @endif
                </td>
              </tr>
        </table>

        @if (auth()->user()->IsAdmin && $report->handling_admin_id === auth()->id() && !in_array($report->report_status, ['Accepted', 'Declined']))
            <form action="{{ route('report.unclaim', $report->id) }}" method="POST">
                @csrf
                <button type="submit" class="claimunclaim">Unclaim Report</button>
            </form>
        @elseif (auth()->user()->IsAdmin && is_null($report->handling_admin_id))
            <form action="{{ route('report.claim', $report->id) }}" method="POST">
                @csrf
                <button type="submit" class="claimunclaim">Claim Report</button>
            </form>
        @endif

        <hr>

        <div class="reporterAndAdminComment text-lg">{{ optional($report->reporter)->name ?? 'Deleted account' }} wrote:</div>
        <div class="reporterAndAdminComment" style="border-left: 3px solid white;">{{ $report->reporter_comment }}</div>

        @if ($report->handling_admin_id === auth()->id() && $report->report_status === 'New')
            <div class="whitetext">
                <hr style="margin-top: 30px; margin-bottom: 30px;">
                <form action="{{ route('report.handle', $report->id) }}" method="POST">
                    @csrf
                    <div>
                        <label for="reporter_comment" class="text-lg">Admin Comment:</label>
                        <textarea id="reporter_comment" class="block mt-1 w-full inputfield textarea" type="text" name="admin_comment" required></textarea>
                    </div>

                    <div class="pt-4">
                        <input type="checkbox" id="permanent" name="permanent" value="1">
                        <label for="permanent">Permanent</label>
                        <input type="datetime-local" id="banned_until" name="banned_until" style="color: black">
                    </div>
                    <br>
                    <div class="flex gap-6">
                        <button class="flex-1 acceptButton" type="submit" name="action" value="accept">Accept Report</button>
                        <button class="flex-1 declineButton" type="submit" name="action" value="decline">Decline Report</button>
                    </div>
                </form>
            </div>
        @endif

        
            @if ($report->admin_comment)
            <div class="whitetext">
                <hr style="margin-top: 30px; margin-bottom: 30px;">
                <div>
                    <label for="admin_comment" class="text-lg reporterAndAdminComment">Response by the admin:</label>
                    <div class="reporterAndAdminComment" style="border-left: 3px solid white;">
                        {{ $report->admin_comment }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>