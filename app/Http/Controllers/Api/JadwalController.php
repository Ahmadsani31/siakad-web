<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResource;
use App\Http\Resources\MataKuliahResource;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class JadwalController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $jadwal = Jadwal::where('dosen_id', $request->user()->id)->get();
            $return = JadwalResource::collection($jadwal->load('mata_kuliah', 'program_studi', 'tahun_akademik', 'dosen'));
            return $this->sendResponse($return, 'successfully.');
        } catch (\Throwable $err) {
            return $this->sendError('Unauthorised.', ['error' => $err->getMessage()]);
        }
    }
}
