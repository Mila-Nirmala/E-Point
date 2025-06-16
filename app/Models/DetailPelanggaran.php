<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class detailPelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pelanggar',
        'id_pelanggaran',
        'id_user',
        'status',
    ];
}
