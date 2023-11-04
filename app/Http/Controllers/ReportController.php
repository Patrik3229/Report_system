<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{

    ////////////////////////////
    // Show admin report list //
    ////////////////////////////
    public function showReports(Request $request)
    {
        if (!Auth::user()->IsAdmin) {
            abort(403, 'Unauthorized action.');
        }

        $query = Report::with(['reporter', 'perpetrator']);
        if ($request->filled('status')) {
            $query->where('report_status', $request->status);
        }

        // Get 25 reports per page
        $reports = $query->paginate(25);

        if ($request->ajax()) {
            return view('profile.partials.reports_table_rows', ['reports' => $reports])->render();
        }

        return view('handle-reports', ['reports' => $reports]);
    }

    //////////////////////////////
    // View my previous reports //
    //////////////////////////////
    public function showMyReports()
    {
        $user = auth()->user();
        $reports = $user->reports()->orderBy('submitted_time', 'desc')->get();
        
        return view('my-reports', compact('reports'));
    }

    ///////////////////
    // View a report //
    ///////////////////
    public function viewAReport($id)
    {
        $report = Report::findOrFail($id);
        $user = Auth::user();

        if (!$user->IsAdmin && $user->id !== $report->reporter_id) {
            abort(403, 'You don\'t have permission to view this report.');
        }

        return view('report-view', compact('report'));
    }

    ////////////////////
    // Claim a report //
    ////////////////////
    public function claimAReport(Request $request, Report $report)
    {
        if ($report->handling_admin_id) {
            return back()->with('error', 'This report has already been claimed.');
        }

        $report->handling_admin_id = auth()->id();
        $report->save();

        return redirect()->route('report.view', $report->id)->with('success', 'Report claimed successfully.');
    }

    //////////////////////
    // Unclaim a report //
    //////////////////////
    public function unclaimAReport(Request $request, Report $report)
    {
        if (in_array($report->report_status, ['Accepted', 'Declined'])) {
            return back()->with('error', 'This report has already been dealt with and cannot be unclaimed.');
        }

        if ($report->handling_admin_id !== auth()->id()) {
            return back()->with('error', 'You cannot unclaim a report you haven\'t claimed.');
        }
    
        $report->handling_admin_id = null;
        $report->save();
    
        return redirect()->route('handle.reports')->with('success', 'Report unclaimed successfully.');
    }


    /////////////////////
    // Create a report //
    /////////////////////
    public function createAReport(Request $request)
    {
        $data = $request->validate([
            'perpetrator_id' => 'required|integer|different:reporter_id|exists:users,id',
            'reporter_comment' => 'required|string',
        ]);

        if ($request->perpetrator_id == Auth::id()) {
            return back()->withErrors(['perpetrator_id' => 'You cannot report yourself.']);
        }

        $existingReport = Report::where('reporter_id', Auth::id())
                        ->where('perpetrator_id', $request->perpetrator_id)
                        ->where('report_status', 'New')
                        ->first();

        if ($existingReport) {
            return back()->withErrors([
                'perpetrator_id' => 'You have already submitted a report against this user.'
            ]);
        }

        $report = new Report();
        $report->perpetrator_id = $request->perpetrator_id;
        $report->reporter_id = Auth::id();
        $report->report_status = 'New';
        $report->reporter_comment = $request->reporter_comment;
        $report->save();

        return redirect()->route('my.reports')->with('success', 'Report submitted successfully!');
    }

    /////////////////////
    // Handle a report //
    /////////////////////
    public function handleReport(Request $request, Report $report){
    
        if ($report->handling_admin_id !== auth()->id() || $report->report_status !== 'New') {
            return back()->with('error', 'You are not authorized to deal with the report.');
        }

        $action = $request->input('action');

        switch ($action) {
            case 'accept':
                $request->validate([
                    'admin_comment' => 'required|string',
                    'banned_until' => 'nullable|date|after:now',
                    'permanent' => 'nullable|boolean',
                ]);
        
                if (!$request->permanent && !$request->filled('banned_until')) {
                    return back()->with('error', 'Unable to accept the report. Please make sure all required fields are filled.');
                }
        
                $report->report_status = 'Accepted';
                $report->admin_comment = $request->admin_comment;

                $perpetrator = $report->perpetrator;
        
                $isPermanentBan = $request->has('permanent');
        
                if ($isPermanentBan) {
                    $perpetrator->IsBanned = true;
                    $perpetrator->IsPermanentlyBanned = true;
                    $perpetrator->BannedUntil = null;
                } else {
                    $perpetrator->IsBanned = true;
                    $perpetrator->IsPermanentlyBanned = false;
                    $perpetrator->BannedUntil = $request->banned_until;
                }
        
                try {
                    DB::transaction(function () use ($report, $perpetrator) {
                        $report->save();
                        $perpetrator->save();
                    });

                    return redirect()->route('handle.reports')->with('success', 'Report accepted successfully.')->with('adminComment', $report->admin_comment);
                } catch (\Exception $e) {
                    return back()->with('error', 'An error occurred while accepting the report.');
                }
                break;

            case 'decline':
                $request->validate([
                    'admin_comment' => 'required|string'
                ]);
        
                $report->report_status = 'Declined';
                $report->admin_comment = $request->admin_comment;
        
                try {
                    $report->save();
                    return redirect()->route('handle.reports')->with('success', 'Report declined successfully.')->with('adminComment', $report->admin_comment);
                } catch (\Exception $e) {
                    return back()->with('error', 'An error occurred while declining the report.');
                }
                break;

            default:
                return back()->with('error', 'Invalid action.');
                break;
        }
    }
}
