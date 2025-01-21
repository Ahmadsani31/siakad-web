<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y H:i',
            'updated_at' => 'datetime:d-m-Y H:i',
        ];
    }
}
