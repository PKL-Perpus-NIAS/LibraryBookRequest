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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('email');
            $table->string('fakultas')->nullable()->after('nip');
            $table->string('tempat_lahir')->nullable()->after('fakultas');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_hp')->nullable()->after('alamat');
            $table->string('jenis_kelamin')->nullable()->after('no_hp');
            $table->string('strata')->default('S1')->after('jenis_kelamin');
            $table->string('status_anggota')->default('Aktif')->after('strata');
            $table->boolean('is_sso_user')->default(false)->after('password'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_hp','jenis kelamin', 'strata', 'status_anggota']);
        });
    }
};
