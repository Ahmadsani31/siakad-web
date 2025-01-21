<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->table;
            switch ($table) {
                case 'user':
                    $data = User::select('*');
                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('created_at', function ($row) {
                            return Carbon::create($row->created_at)->format('d F Y');
                        })
                        ->addColumn('status', function ($row) {
                            if ($row->status == 'Y') {
                                $output = ' <span class="badge bg-primary">Aktif</span>';
                            } else {
                                $output = '<span class="badge bg-danger">Non Aktif</span>';
                            }
                            return $output;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-warning" id="user-edit-password" parent="' . $row->id . '" judul="Edit Password"><iconify-icon icon="solar:lock-password-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-cre text-success" id="user-edit" parent="' . $row->id . '" judul="Edit User"><iconify-icon icon="solar:user-plus-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 text-danger" onclick="logOutUser(' . $row->id . ')"><iconify-icon icon="solar:user-cross-rounded-bold-duotone" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['status', 'action'])
                        ->toJson();
                    break;
                case 'program-studi':
                    $data = ProgramStudi::select('*');
                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('created_at', function ($row) {
                            return Carbon::create($row->created_at)->format('d F Y');
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-success" id="program-studi" parent="' . $row->id . '" judul="Edit User"><iconify-icon icon="solar:pen-new-round-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-del text-danger" tabel="program-studi" id="' . $row->id . '"><iconify-icon icon="solar:trash-bin-minimalistic-bold" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
                    break;
                case 'mata-kuliah':
                    $data = MataKuliah::select('*');
                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('created_at', function ($row) {
                            return Carbon::create($row->created_at)->format('d F Y');
                        })
                        ->editColumn('program_studi', function ($row) {
                            return $row->program_studi->name;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-success" id="mata-kuliah" parent="' . $row->id . '" judul="Edit Mata Kuliah"><iconify-icon icon="solar:pen-new-round-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-del text-danger" tabel="mata-kuliah" id="' . $row->id . '"><iconify-icon icon="solar:trash-bin-minimalistic-bold" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
                    break;
                case 'tahun-akademik':
                    $data = TahunAkademik::select('*')->orderBy('code', 'desc');
                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->editColumn('tahun_mulai', function ($row) {
                            return Carbon::create($row->tahun_mulai)->format('d F Y');
                        })
                        ->editColumn('tahun_selesai', function ($row) {
                            return Carbon::create($row->tahun_selesai)->format('d F Y');
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-success" id="tahun-akademik" parent="' . $row->id . '" judul="Edit Tahun Akademik"><iconify-icon icon="solar:pen-new-round-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-del text-danger" tabel="tahun-akademik" id="' . $row->id . '"><iconify-icon icon="solar:trash-bin-minimalistic-bold" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
                    break;
                case 'jadwal':
                    $data = Jadwal::select('*')->orderBy('id', 'desc');
                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('mata_kuliah', function ($row) {
                            return $row->mata_kuliah->code . ' - ' . $row->mata_kuliah->name . '<br>' . $row->dosen->name;
                        })
                        ->addColumn('dosen', function ($row) {
                            return $row->dosen->name;
                        })
                        ->addColumn('tahun_akademik', function ($row) {
                            return $row->tahun_akademik->name . '<br/>' . $row->tahun_akademik->code;
                        })
                        ->addColumn('program_studi', function ($row) {
                            return $row->program_studi->name;
                        })
                        ->addColumn('jam', function ($row) {
                            return  Carbon::create($row->jam_mulai)->format('h:i') . ' - ' . Carbon::create($row->jam_selesai)->format('h:i');
                        })
                        ->addColumn('sks', function ($row) {
                            return  $row->mata_kuliah->sks;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-success" id="jadwal-perkuliahan" parent="' . $row->id . '" judul="Edit Jadwal Perkuliahan"><iconify-icon icon="solar:pen-new-round-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-del text-danger" tabel="jadwal" id="' . $row->id . '"><iconify-icon icon="solar:trash-bin-minimalistic-bold" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['action', 'mata_kuliah', 'tahun_akademik'])
                        ->toJson();
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
