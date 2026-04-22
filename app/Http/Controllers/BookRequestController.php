<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Http\Request;
use App\Mail\BookAvailableMail;
use Illuminate\Support\Facades\Mail;

class BookRequestController extends Controller
{
    public function store(Request $request)
    {
        BookRequest::create([
            'book_title' => $request->book_title,
            'type_of_material' => $request->type_of_material,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_city' => $request->publication_city,
            'publication_year' => $request->publication_year,
            'requester_name' => $request->requester_name,
            'faculty' => $request->faculty,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Permintaan buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $bookRequest = BookRequest::findOrFail($id);
        $statusLama = $bookRequest->status;
        $validatedData = $request->validate([
            'book_title'       => 'required|string|max:255',
            'type_of_material' => 'required|string',
            'author'           => 'required|string|max:255',
            'publisher'        => 'nullable|string|max:255',
            'publication_city' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer',
            'requester_name'   => 'required|string|max:255',
            'faculty'          => 'required|string',
            'email'            => 'required|email|max:255',
            'status'           => 'required|string',
            'notes'            => 'nullable|string'
        ]);
        $bookRequest->update($validatedData);
        if ($statusLama !== 'available' && $request->status === 'available') {
            Mail::to($bookRequest->email)->send(new BookAvailableMail($bookRequest));
        }
        return redirect()->back()->with('success', 'Data telah tersimpan, notifikasi telah dikirim kepada pemohon.');
    }

    public function destroy($id)
    {
        // Cari data buku berdasarkan ID
        $bookRequest = BookRequest::findOrFail($id);
        
        // Hapus datanya dari database
        $bookRequest->delete();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data usulan buku berhasil dihapus secara permanen.');
    }

    public function index(Request $request)
    {
        $query = BookRequest::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('book_title', 'like', '%' . $keyword . '%')
                  ->orWhere('author', 'like', '%' . $keyword . '%')
                  ->orWhere('requester_name', 'like', '%' . $keyword . '%')
                  ->orWhere('id', 'like', '%' . $keyword . '%');
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

        $sortColumn = $request->input('sort', 'id'); 
        $sortDirection = $request->input('dir', 'desc');

        $allowedSortColumns = [
            'id', 'book_title', 'type_of_material', 'author', 
            'publisher', 'publication_city', 'publication_year', 
            'faculty', 'requester_name', 'email', 'status'
        ];

        if (in_array($sortColumn, $allowedSortColumns)) {
            $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';
            $query->orderBy($sortColumn, $direction);
        } else {
            $query->latest(); 
        }

        $requests = $query->get();

        $faculties = ['FK', 'FKG', 'FH', 'FEB', 'FF', 'FKH', 'FST', 'FPsi', 'FISIP', 'FIB', 'FKM', 'FPK', 'FKp', 'FTMM', 'FV', 'FIKKIA'];
        $statuses = [
            'processing' => 'Dalam Proses',
            'pending_purchase' => 'Menunggu',
            'available' => 'Selesai'
        ];

        $years = BookRequest::selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $materialTypes = ['Monograf', 'Sumber Elektronik', 'Film', 'Terbitan Berkala', 'Bahan Kartografis', 'Bahan Grafis', 'Rekaman Video', 'Musik', 'Bahan Campuran', 'Rekaman Suara', 'Bentuk Mikro', 'Manuskrip', 'Bahan Ephemeral', 'Skripsi', 'Tesis', 'Disertasi', 'Praktek Kerja Lapangan (PKL)', 'Tugas Akhir (Diploma)', 'PKM', 'Karya Tugas Akhir (Spesialis)', 'Karya Ilmiah Akhir (NERS)', 'Laporan Magang Profesi (Akuntansi)', 'Ebook'];

        return view('permintaan-buku', compact('requests', 'faculties', 'statuses', 'years', 'materialTypes'));
    }

    // --- FUNGSI KHUSUS API ---
    public function apiStatistik(Request $request)
    {
        $yearlyData = BookRequest::selectRaw('EXTRACT(YEAR FROM created_at) as year, count(*) as count')
            ->groupByRaw('EXTRACT(YEAR FROM created_at)')
            ->orderBy('year')
            ->get();

        $typeData = BookRequest::selectRaw('type_of_material as name, count(*) as y')
            ->groupBy('type_of_material')
            ->get();

        $facultyData = BookRequest::selectRaw('faculty, count(*) as total')
            ->groupBy('faculty')
            ->orderByDesc('total')
            ->get();

        $latestRequests = BookRequest::orderBy('id', 'desc')->take(5)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'tahunan' => $yearlyData,
                'jenis_buku' => $typeData,
                'fakultas' => $facultyData,
                'latest_requests' => $latestRequests
            ]
        ], 200);
    }
}