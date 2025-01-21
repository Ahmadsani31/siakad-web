<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResource;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        return JadwalResource::collection(Jadwal::all()->load('mata_kuliah', 'program_studi', 'tahun_akademik'));
    }
}
