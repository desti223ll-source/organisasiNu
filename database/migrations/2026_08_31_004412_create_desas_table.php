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
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->string('judulberita'); 
            $table->date('tanggal');
            $table->text('isiberita'); // Diubah ke TEXT agar muat teks panjang
            $table->string('kategori')->default('ipnu', 'banser', 'muslimat', 'fatayat'); // Tipe string huruf kecil
            $table->string('gambar')->nullable();
            $table->timestamps(); // Menghasilkan created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};