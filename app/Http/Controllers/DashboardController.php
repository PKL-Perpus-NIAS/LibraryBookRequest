<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $allTypes = BookRequest::selectRaw("type_of_material as name, count(*) as y")
        ->groupBy("type_of_material")
        ->orderByDesc("y")
        ->get();

        $formattedData = $allTypes->map(function ($item) {
            return [
                'name' => $item->name,
                'y' => (int) $item->y
            ];
        });

        $typeData = $formattedData->take(4);
        $others = $formattedData->slice(4);
        $othersCount = $formattedData->slice(4)->sum('y');

        if ($othersCount > 0) {
            $typeData->push([
                'name' => 'Lainnya',
                'y' => $othersCount,
                'drilldown' => 'lainnya-detail'
            ]);
        }

        $drilldownData = $others->values()->toArray();

        $stats = [
            'total'      => BookRequest::count(),
            'processing' => BookRequest::where('status', 'processing')->count(),
            'pending'    => BookRequest::where('status', 'pending_purchase')->count(),
            'available'  => BookRequest::where('status', 'available')->count(),
        ];

        // 2. Data Chart Tahunan (Dikelompokkan per tahun)
        $yearlyData = BookRequest::selectRaw('EXTRACT(YEAR FROM created_at) as year, count(*) as count')
            ->groupByRaw('EXTRACT(YEAR FROM created_at)')
            ->orderBy('year')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => (int) $item->year,
                    'count' => (int) $item->count
                ];
            });

        // 4. Data Top 5 Fakultas (Sesuai request kamu)
        $facultyData = BookRequest::selectRaw('faculty, count(*) as total')
            ->groupBy('faculty')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'faculty' => $item->faculty, 
                    'total' => (int) $item->total
                ];
            });

        // 5. Tabel Permintaan Terbaru
        $latestRequests = BookRequest::latest()->take(5)->get();
        return view('dashboard', [
            'stats' => $stats,
            'yearlyData' => $yearlyData,
            'typeData' => $typeData->values()->toArray(), 
            'drilldownData' => $drilldownData,
            'facultyData' => $facultyData,
            'latestRequests' => $latestRequests
        ]);
    }
}