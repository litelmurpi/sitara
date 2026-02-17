<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Attendance;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportPdfController extends Controller
{
    public function exportFinance(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $finances = Finance::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $totalIncome = $finances->where('type', 'income')->sum('amount');
        $totalExpense = $finances->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $data = [
            'title' => 'Laporan Keuangan TPA Ramadan',
            'startDate' => Carbon::parse($startDate)->translatedFormat('d F Y'),
            'endDate' => Carbon::parse($endDate)->translatedFormat('d F Y'),
            'finances' => $finances,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'generatedAt' => Carbon::now()->translatedFormat('d F Y, H:i'),
        ];

        $pdf = Pdf::loadView('pdf.finance-report', $data);

        return $pdf->download('laporan-keuangan-' . $startDate . '-' . $endDate . '.pdf');
    }

    public function exportAttendance(Request $request)
    {
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        $attendances = Attendance::with('santri')
            ->whereDate('date', $date)
            ->orderBy('check_in_time')
            ->get();

        $data = [
            'title' => 'Laporan Kehadiran TPA Ramadan',
            'date' => Carbon::parse($date)->translatedFormat('l, d F Y'),
            'attendances' => $attendances,
            'totalHadir' => $attendances->where('status', 'hadir')->count(),
            'totalIzin' => $attendances->where('status', 'izin')->count(),
            'totalSakit' => $attendances->where('status', 'sakit')->count(),
            'totalAlpha' => $attendances->where('status', 'alpha')->count(),
            'generatedAt' => Carbon::now()->translatedFormat('d F Y, H:i'),
        ];

        $pdf = Pdf::loadView('pdf.attendance-report', $data);

        return $pdf->download('laporan-kehadiran-' . $date . '.pdf');
    }

    public function exportLeaderboard(Request $request)
    {
        $santris = \App\Models\Santri::orderByDesc('total_points')
            ->take(50)
            ->get();

        $data = [
            'title' => 'Leaderboard TPA Ramadan',
            'santris' => $santris,
            'generatedAt' => Carbon::now()->translatedFormat('d F Y, H:i'),
        ];

        $pdf = Pdf::loadView('pdf.leaderboard-report', $data);

        return $pdf->download('leaderboard-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
