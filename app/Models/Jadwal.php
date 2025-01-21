<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{

    protected $table = 'jadwal';
    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'program_studi_id',
        'tahun_akademik_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'type',
    ];
    public $timestamps = true;

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y H:i',
            'updated_at' => 'datetime:d-m-Y H:i',
        ];
    }
}
