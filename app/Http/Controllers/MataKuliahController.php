<?php

namespace App\Http\Controllers;

use App\Http\Requests\MataKuliahRequest;
use App\Models\MataKuliah;
use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pageTitle = 'Mata Kuliah';
        return view('pages.mata-kuliah.mata-kuliah-index', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MataKuliahRequest $request)
    {
        try {
            if ($request->ID == 0) {
                MataKuliah::create($request->validated());
            } else {
                MataKuliah::find($request->ID)->update($request->validated());
            }
            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }
}
