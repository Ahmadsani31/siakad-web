<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');
        try {
            $user = User::where('email', $input['email'])->first();

            if (!$user) {
                return $this->sendError('Validation Error.', ['Email not valid']);
            }

            if (!Hash::check($input['password'], $user->password)) {
                return $this->sendError('Validation Error.', ['Password incorrect']);
            }

            $success['token'] =  $user->createToken('api-token', ['*'], now()->addMinutes(5))->plainTextToken;
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } catch (\Throwable $err) {
            return $this->sendError('Unauthorised.', ['error' => 'Could not create token']);
        }
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->all();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $success['token'] =  $user->createToken('api-token', ['*'], now()->addMinutes(5))->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }


    public function logout(Request $request)
    {

        // Revoke all tokens...
        $request->user()->tokens()->delete();

        // // Revoke the current token
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'You have been successfully logged out.');
    }
}
