<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        try {
            return $this->sendResponse($request->user(), 'User login successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Unauthorised.', ['error' => 'Could not create token']);
        }
    }
}
