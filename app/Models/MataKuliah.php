<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataKuliah extends Model
{
    /** @use HasFactory<\Database\Factories\MataKuliahFactory> */
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $fillable = [
        'program_studi_id',
        'code',
        'name',
        'sks',
    ];
    public $timestamps = true;


    public function program_studi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y H:i',
            'updated_at' => 'datetime:d-m-Y H:i',
        ];
    }
}
