<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'User';
        return view('pages.users.user-index', compact('pageTitle'));
    }


    public function store(UserStoreRequest $request)
    {
        try {
            User::create($request->validated());
            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            $user =  User::findOrFail($request->ID);

            $user->update($request->validated());

            return response()->json(['param' => true, 'message' => 'Successfully']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }

    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        try {
            $user =   User::findOrFail($request->ID);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['param' => true, 'message' => 'Berhasil Update']);
        } catch (\Exception $err) {
            return response()->json(['param' => false, 'message' => $err->getMessage()]);
        }
    }

    public function logoutAllUsers()
    {
        DB::table('sessions')->truncate(); // Menghapus semua sesi
        return response()->json(['param' => true, 'message' => 'Semua user telah logout']);
    }

    public function logoutUser($id)
    {
        DB::table('sessions')
            ->where('user_id', $id) // `user_id` adalah kolom sesi yang terhubung ke pengguna
            ->delete(); // Menghapus sesi pengguna tertentu

        return response()->json(['param' => true, 'message' => 'User telah logout']);
    }
}
