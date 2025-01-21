<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahunAkademikRequest;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $pageTitle = 'Tahun Akademik';
        return view('pages.tahun-akademik.tahun-akademik-index', compact('pageTitle'));
    }

    public function store(TahunAkademikRequest $request)
    {
        try {
            if ($request->ID == 0) {
                TahunAkademik::create($request->validated());
            } else {
                TahunAkademik::where('id', $request->ID)->update($request->validated());
            }
            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }
}
