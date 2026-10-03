<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class desa extends Model
{
    use HasFactory;

    // Tambahkan 'kategori' dan 'gambar' di sini
    protected $fillable = [
        'judulberita', 
        'kategori', 
        'tanggal', 
        'isiberita', 
        'gambar'
    ];
}