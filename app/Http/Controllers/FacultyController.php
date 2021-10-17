<?php

namespace App\Http\Controllers;

use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Faculty::class);

        $faculties = Faculty::all();

        return response()->json(['data' => FacultyResource::collection($faculties)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Faculty::class);

        $data = $request->validate([
            'name' => 'required|unique:faculties',
        ]);

        $faculty = Faculty::create($data);

        return response()->json(['data' => new FacultyResource($faculty)], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $faculty = Faculty::with('departments')->findOrFail($id);
        $this->authorize('view', $faculty);

        return response()->json(['data' => new FacultyResource($faculty)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $faculty = Faculty::with('departments')->findOrFail($id);
        $this->authorize('update', $faculty);

        $data = $request->validate(['name' => '']);
        $faculty->update(array_filter($data, fn ($field) => !!$field));

        return response()->json(['data' => new FacultyResource($faculty)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $faculty = Faculty::with('departments')->findOrFail($id);
        $this->authorize('delete', $faculty);

        $faculty->delete();

        return response()->json(['data' => new FacultyResource($faculty)], Response::HTTP_OK);
    }
}
