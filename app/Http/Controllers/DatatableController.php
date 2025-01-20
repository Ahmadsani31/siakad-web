<?php

namespace App\Http\Controllers;

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
                        ->addColumn('action', function ($row) {
                            $btn = '<button type="button" class="btn p-1 modal-cre text-warning" id="user-edit-password" parent="' . $row->id . '" judul="Edit Password"><iconify-icon icon="solar:lock-password-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 modal-cre text-success" id="user-edit" parent="' . $row->id . '" judul="Edit User"><iconify-icon icon="solar:user-plus-bold" width="28" height="28"></iconify-icon></button>';
                            $btn .= '<button type="button" class="btn p-1 text-danger" onclick="logOutUser(' . $row->id . ')"><iconify-icon icon="solar:user-cross-rounded-bold-duotone" width="28" height="28"></iconify-icon></button>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
                    break;
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}
