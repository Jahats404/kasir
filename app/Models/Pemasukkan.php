<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukkan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pemasukkan';
    protected $table = 'pemasukkan';
    protected $guarded = [];
    protected $casts = [
        'id_pemasukkan' => 'string',
    ];
}