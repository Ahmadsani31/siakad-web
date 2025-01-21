<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->hasOne(User::class, 'id', 'dosen_id');
    }

    // public function mata_kuliah()
    // {
    //     return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    // }

    public function mata_kuliah(): HasOne
    {
        return $this->hasOne(MataKuliah::class, 'id', 'mata_kuliah_id');
    }

    public function program_studi()
    {
        return $this->hasOne(ProgramStudi::class, 'id', 'program_studi_id');
    }

    public function tahun_akademik()
    {
        return $this->hasOne(TahunAkademik::class, 'id', 'tahun_akademik_id');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y H:i',
            'updated_at' => 'datetime:d-m-Y H:i',
        ];
    }
}
