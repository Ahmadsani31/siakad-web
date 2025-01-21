<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';
    protected $fillable = [
        'code',
        'name',
        'tahun_mulai',
        'tahun_selesai',
    ];
    public $timestamps = true;
}
