<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use App\Models\Code;

class StatisticController extends Controller
{

    /**
     * Display statistics of the application.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // Number of clients, clients last month, clients last 2 months excluding last month, percentage of clients last month compared to last 2 months
        $clients = User::where('role', 'C')->count();
        $clients_last_30days = User::where('role', 'C')->where('created_at', '>=', now()->subDays(30))->count();
        $clients_last_60days = User::where('role', 'C')->where('created_at', '>=', now()->subDays(60))->where('created_at', '<', now()->subDays(30))->count();
        $percentageClients = $clients_last_60days > 0 ? round((($clients_last_30days - $clients_last_60days) / $clients_last_60days) * 100) : 0;

        // Number of complaints, complaints last month, complaints last 2 months excluding last month, percentage of complaints last month compared to last 2 months
        $complaints = Complaint::count();
        $complaints_last_30days = Complaint::where('created_at', '>=', now()->subDays(30))->count();
        $complaints_last_60days = Complaint::where('created_at', '>=', now()->subDays(60))->where('created_at', '<', now()->subDays(30))->count();
        $percentageComplaints = $complaints_last_60days > 0 ? round((($complaints_last_30days - $complaints_last_60days) / $complaints_last_60days) * 100) : 0;

        // Number of codes, number of codes used, percentage of codes used
        $codes = Code::count();
        $codesUsed = Code::where('used', true)->count();
        $percentageCodesUsed = Code::count() > 0 ? round(($codesUsed / Code::count()) * 100) : 0;

        return response()->json([
            'clients' => $clients,
            'percentageClients' => $percentageClients,
            'complaints' => $complaints,
            'percentageComplaints' => $percentageComplaints,
            'codes' => $codes,
            'percentageCodesUsed' => $percentageCodesUsed,
        ]);
    }

    /**
     * Display statistics for the graph.
     *
     * @return JsonResponse
     */
    public function graph()
    {
        // Number of clients by month
        $clientsByMonth = User::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->where('role', 'C')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->withTrashed()
            ->get();

        // Number of codes by month
        $codesByMonth = Code::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->withTrashed()
            ->get();

        // Number of complaints by month
        $complaintsByMonth = Complaint::selectRaw('count(*) as total, MONTH(created_at) as month')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->withTrashed()
            ->get();

        return response()->json([
            'clientsByMonth' => $clientsByMonth,
            'codesByMonth' => $codesByMonth,
            'complaintsByMonth' => $complaintsByMonth,
        ]);
    }
}
