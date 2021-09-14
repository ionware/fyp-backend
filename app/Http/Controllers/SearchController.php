<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * Search for students.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->query('q');

        if (empty($query)) {
            return response()->json(['message' => 'No student found matching your query'], Response::HTTP_BAD_REQUEST);
        }

        $students = Student::where('surname', 'LIKE', "%{$query}%")
            ->orWhere('firstName', 'LIKE', "%{$query}%")
            ->orWhere('lastName', 'LIKE', "%{$query}%")
            ->orWhere('matricNo', 'LIKE', "%{$query}%")
            ->get();

        return count($students)
            ? response()->json(['data' => StudentResource::collection($students)], Response::HTTP_OK)
            : response()->json(['message' => 'No student found matching your query'], Response::HTTP_BAD_REQUEST);
    }
}
