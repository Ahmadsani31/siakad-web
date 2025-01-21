<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    /** @use HasFactory<\Database\Factories\MataKuliahFactory> */
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $fillable = [
        'code',
        'name',
        'sks',
    ];
    public $timestamps = true;
}
