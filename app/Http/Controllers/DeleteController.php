<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function index($tabel, $id)
    {
        if (!empty($tabel)) {

            switch ($tabel) {
                case 'program-studi':
                    try {
                        $data = ProgramStudi::findOrFail($id);
                        $data->delete();
                        return response()->json(['param' => true, 'message' => 'Data Berhasil Dihapus']);
                    } catch (\Exception $err) {
                        return response()->json(['param' => false, 'message' => $err->getMessage()]);
                    }
                    break;
                case 'mata-kuliah':
                    try {
                        $data = MataKuliah::findOrFail($id);
                        $data->delete();
                        return response()->json(['param' => true, 'message' => 'Data Berhasil Dihapus']);
                    } catch (\Exception $err) {
                        return response()->json(['param' => false, 'message' => $err->getMessage()]);
                    }
                    break;
                case 'tahun-akademik':
                    try {
                        $data = TahunAkademik::findOrFail($id);
                        $data->delete();
                        return response()->json(['param' => true, 'message' => 'Data Berhasil Dihapus']);
                    } catch (\Exception $err) {
                        return response()->json(['param' => false, 'message' => $err->getMessage()]);
                    }
                    break;
                case 'jadwal':
                    try {
                        $data = Jadwal::findOrFail($id);
                        $data->delete();
                        return response()->json(['param' => true, 'message' => 'Data Berhasil Dihapus']);
                    } catch (\Exception $err) {
                        return response()->json(['param' => false, 'message' => $err->getMessage()]);
                    }
                    break;
                default:
                    return response()->json(['param' => false, 'message' => 'Settingan untuk delete blum ada']);
                    break;
            }
        }
    }
}
