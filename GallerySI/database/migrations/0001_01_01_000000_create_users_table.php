<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel users
     * Semua akun (admin dan user biasa) disimpan di sini
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary key auto increment
            $table->id();

            // Informasi dasar pengguna
            $table->string('username', 255)->unique();  // nama unik untuk login
            $table->string('email', 255)->unique();     // email unik
            $table->string('password', 255);            // password ter-hash

            // Role menentukan jenis akun (admin/user)
            $table->enum('role', ['admin', 'user'])
                  ->default('user')
                  ->comment('admin = pengelola sistem, user = pengguna biasa');

            // Informasi profil tambahan
            $table->string('avatar', 255)->nullable();  // path gambar profil
            $table->boolean('is_active')->default(true); // status akun aktif/tidak

            // Waktu pembuatan dan pembaruan
            $table->timestamps();

            // Index untuk performa query
            $table->index(['email', 'role']);
        });
    }

    /**
     * Rollback migration
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
