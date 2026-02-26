<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookRequest>
 */
class BookRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_title' => $this->faker->sentence(3),
            'type_of_material' => $this->faker->randomElement([
                'Monograf', 'Sumber Elektronik', 'Film', 'Terbitan Berkala', 
                'Bahan Kartografis', 'Bahan Grafis', 'Rekaman Video', 'Musik', 
                'Bahan Campuran', 'Rekaman Suara', 'Bentuk Mikro', 'Manuskrip', 
                'Bahan Ephemeral', 'Skripsi', 'Tesis', 'Disertasi', 
                'Praktek Kerja Lapangan (PKL)', 'Tugas Akhir (Diploma)', 'PKM', 
                'Karya Tugas Akhir (Spesialis)', 'Karya Ilmiah Akhir (NERS)', 
                'Laporan Magang Profesi (Akuntansi)', 'Ebook'
            ]),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'publication_city' => $this->faker->city(),
            'publication_year' => $this->faker->year(),
            'requester_name' => $this->faker->name(),
            'faculty' => $this->faker->randomElement([
                'FK', 'FKG', 'FH', 'FEB', 'FF', 'FKH', 'FST', 'FPsi', 'FISIP', 'FIB', 'FKM', 'FPK', 'FKp', 'FTMM', 'FV', 'FIKKIA'
            ]),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->randomElement(['processing', 'pending_purchase', 'available']),
        ];
    }
}
