<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramStudiRequest;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $pageTitle = 'Program Studi';
        return view('pages.program-studi.program-studi-index', compact('pageTitle'));
    }

    public function store(ProgramStudiRequest $request)
    {
        try {
            if ($request->ID == 0) {
                ProgramStudi::create($request->validated());
            } else {
                ProgramStudi::where('id', $request->ID)->update($request->validated());
            }
            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }
}
