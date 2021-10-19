<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::latest()->get();

        return response()->json(['data' => UserResource::collection($users)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::guard('sanctum')->user()->role < 2) {
            return response()->json(['message' => 'You do not have permission to create account'], Response::HTTP_FORBIDDEN);
        }

        $data = $request->validate([
            'title' => '',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
            'allowed_departments' => ''
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json(['data' => new UserResource($user)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json(['data' => new UserResource($user)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'title' => '',
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'phone' => '',
            'password' => '',
            'role' => '',
        ]);
        if (Auth::guard('sanctum')->user()->role < 2) {
            unset($data['role']);
        }

        if (isset($data['password']) && ! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::findOrFail($id);
        $user->update(array_filter($data, fn ($field) => !!$field));

        return response()->json(['data' => new UserResource($user)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['data' => new UserResource($user)], Response::HTTP_OK);
    }

    /**
     * Get profile of the logged-in user.
     *
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        return response()->json(['data' => new UserResource($user)], Response::HTTP_OK);
    }
}
