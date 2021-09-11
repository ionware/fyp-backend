<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (! $user) {
            return response()->json([
                'message' => 'Email or password is incorrect.'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->token = $user->createToken('Mobile/Web app')->plainTextToken;

        return response()->json(['data' => new UserResource($user)], Response::HTTP_OK);
    }
}
