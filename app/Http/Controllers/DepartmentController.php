<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if ($user->role >= 1) {
            return response()
                ->json(['data' => DepartmentResource::collection(Department::withCount('students')->get())], Response::HTTP_OK);
        }

        $id = $user->allowed_departments
            ? array_map(fn ($field) => trim($field),array_filter(explode(',', $user->allowed_departments), fn ($field) => !!$field))
            : [];

        $departments = count($id) > 1 ? Department::whereIn('id', $id)->get() : Department::all();
        return response()->json(['data' => DepartmentResource::collection($departments)], Response::HTTP_OK);
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
        $this->authorize('create', Department::class);

        $data = $request->validate([
            'name' => 'required|unique:departments',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $department = Department::create($data);

        return response()->json(['data' => new DepartmentResource($department)], Response::HTTP_OK);
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
        $department = Department::findOrFail($id);
        $this->authorize('view', $department);

        return response()->json(['data' => new DepartmentResource($department)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $department = Department::findOrFail($id);
        $this->authorize('update', $department);

        $data = $request->validate([
            'name' => '',
            'faculty_id' => 'exists:faculties,id',
        ]);

        $department->update(array_filter($data, fn ($field) => !!$field));

        return response()->json(['data' => new DepartmentResource($department)], Response::HTTP_OK);
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
        $department = Department::findOrFail($id);
        $this->authorize('delete', $department);

        $department->delete();

        return response()->json(['data' => new DepartmentResource($department)], Response::HTTP_OK);
    }
}
