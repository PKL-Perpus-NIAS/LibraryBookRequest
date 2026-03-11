<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = BookRequest::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('book_title', 'like', '%' . $keyword . '%')
                  ->orWhere('author', 'like', '%' . $keyword . '%')
                  ->orWhere('requester_name', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->has('faculty') && $request->faculty != '') {
            $query->where('faculty', $request->faculty);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('year') && $request->year != '') {
            $query->whereYear('created_at', $request->year);
        }

        $requests = $query->latest()->get();

        $faculties = ['FK', 'FKG', 'FH', 'FEB', 'FF', 'FKH', 'FST', 'FPsi', 'FISIP', 'FIB', 'FKM', 'FPK', 'FKp', 'FTMM', 'FV', 'FIKKIA'];
        $statuses = [
            'processing' => 'Dalam Proses',
            'pending_purchase' => 'Menunggu',
            'available' => 'Selesai'
        ];

        $years = BookRequest::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

        $materialTypes = ['Monograf', 'Sumber Elektronik', 'Film', 'Terbitan Berkala', 'Bahan Kartografis', 'Bahan Grafis', 'Rekaman Video', 'Musik', 'Bahan Campuran', 'Rekaman Suara', 'Bentuk Mikro', 'Manuskrip', 'Bahan Ephemeral', 'Skripsi', 'Tesis', 'Disertasi', 'Praktek Kerja Lapangan (PKL)', 'Tugas Akhir (Diploma)', 'PKM', 'Karya Tugas Akhir (Spesialis)', 'Karya Ilmiah Akhir (NERS)', 'Laporan Magang Profesi (Akuntansi)', 'Ebook'];

        return view('permintaan-buku', compact('requests', 'faculties', 'statuses', 'years', 'materialTypes'));
    }
}