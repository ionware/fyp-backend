<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiKeyResource;
use App\Models\ApiKey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $keys = ApiKey::latest()->get();

        return response()->json(['data' => ApiKeyResource::collection($keys)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => 'required',]);
        if (Auth::guard('sanctum')->user()->role < 2) {
            return response()->json(['message' => 'You do not have permission to create account'], Response::HTTP_FORBIDDEN);
        }

        $data['public_key'] = sprintf('PK_%s', Str::random(45));
        $data['private_key'] = sprintf('SK_%s', Str::random(45));

        $key = Auth::guard('sanctum')->user()->apiKeys()->create($data);

        return response()->json(['data' => new ApiKeyResource($key)], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $key = ApiKey::findOrFail($id);

        return response()->json(['data' => new ApiKeyResource($key)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $key = ApiKey::findOrFail($id);

        $data = $request->validate(['name' => '']);
        $key->update(array_filter($data, fn ($field) => !!$field));

        return response()->json(['data' => new ApiKeyResource($key)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $key = ApiKey::findOrFail($id);

        $key->update(['active' => false]);

        return response()->json(['data' => new ApiKeyResource($key)], Response::HTTP_OK);
    }
}
