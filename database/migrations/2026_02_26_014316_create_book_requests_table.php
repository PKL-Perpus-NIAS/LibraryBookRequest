<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->string('book_title');
            $table->enum('type_of_material', [
                'Monograf', 'Sumber Elektronik', 'Film', 'Terbitan Berkala', 
                'Bahan Kartografis', 'Bahan Grafis', 'Rekaman Video', 'Musik', 
                'Bahan Campuran', 'Rekaman Suara', 'Bentuk Mikro', 'Manuskrip', 
                'Bahan Ephemeral', 'Skripsi', 'Tesis', 'Disertasi', 
                'Praktek Kerja Lapangan (PKL)', 'Tugas Akhir (Diploma)', 'PKM', 
                'Karya Tugas Akhir (Spesialis)', 'Karya Ilmiah Akhir (NERS)', 
                'Laporan Magang Profesi (Akuntansi)', 'Ebook'
            ]);
            $table->string('author');
            $table->string('publisher');
            $table->string('publication_city');
            $table->integer('publication_year');
            $table->string('requester_name');
            $table->enum('faculty', ['FK', 'FKG', 'FH', 'FEB', 'FF', 'FKH', 'FST', 'FPsi', 'FISIP', 'FIB', 'FKM', 'FPK', 'FKp', 'FTMM', 'FV', 'FIKKIA']);
            $table->string('email');
            $table->enum('status', ['processing', 'pending_purchase', 'available'])->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
