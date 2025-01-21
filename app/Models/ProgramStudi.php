<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;
    protected $table = 'program_studi';
    protected $fillable = [
        'code',
        'name',
    ];
    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d-m-Y H:i',
            'updated_at' => 'datetime:d-m-Y H:i',
        ];
    }
}
