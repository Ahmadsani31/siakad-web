<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalStoreRequest;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {

        // $jadwal = Jadwal::all();
        // foreach ($jadwal as $key => $value) {
        //     dd($value->program_studi->name);
        // }

        $pageTitle = 'Jadwal Perkuliahan';
        return view('pages.jadwal.jadwal-index', compact('pageTitle'));
    }

    public function store(JadwalStoreRequest $request)
    {
        try {
            if ($request->ID == 0) {
                Jadwal::create($request->validated());
            } else {
                Jadwal::find($request->ID)->update($request->validated());
            }
            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }

    public function getMataKuliah(Request $request)
    {
        $mata_kuliah = MataKuliah::select("name", "id")
            ->where('program_studi_id', $request->get('prodi'))
            ->when($request->get('q'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->take(10)
            ->get();
        return response()->json($mata_kuliah);
    }

    public function getTanggalAjar(Request $request)
    {
        if (!empty($request->get('tahun_akademik_id'))) {
            $mata_kuliah = TahunAkademik::where("id", $request->get('tahun_akademik_id'))->first();
            return response()->json([
                'tahun_mulai' => $mata_kuliah->tahun_mulai,
                'tahun_selesai' => $mata_kuliah->tahun_selesai
            ]);
        }
    }

    public function getJadwal()
    {
        $jadwal = DB::table('jadwal')
            ->join('mata_kuliah', 'jadwal.mata_kuliah_id', '=', 'mata_kuliah.id')
            ->join('dosens', 'jadwal.dosen_id', '=', 'dosens.id')
            ->join('program_studi', 'jadwal.program_studi_id', '=', 'program_studi.id')
            ->join('tahun_akademik', 'jadwal.tahun_akademik_id', '=', 'tahun_akademik.id')
            ->select('jadwal.*', 'mata_kuliah.nama as nama_mata_kuliah', 'dosens.nama as nama_dosen', 'program_studi.nama as nama_program_studi', 'tahun_akademik.tahun_akademik')
            ->get();
        return response()->json($jadwal);
    }
}
