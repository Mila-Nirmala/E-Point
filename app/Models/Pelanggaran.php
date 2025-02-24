<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Impor HasFactory
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    // Mentukan nama tabel jika tidak mengikuti konvensi Laravel (opsional)
    protected $table = 'pelanggarans';

    // Mentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'jenis',
        'konsekuensi',
        'poin',
    ];

    //  Jika ada hubungan dengan model lain (contoh: User yang melakukan pelanggaran)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
