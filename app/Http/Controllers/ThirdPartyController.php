<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use App\Models\Session;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThirdPartyController extends Controller
{
    /**
     * Get students resources.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function students(Request $request): JsonResponse
    {
        $students = Student::latest();

        if ($request->has('session') && $request->input('session')) {
            $session = Session::where('year', $request->input('session'))->first();
            if ($session) {
                $students = $students->where('session_id', $session->id);
            }
        }

        return response()->json(['data' => StudentResource::collection($students->get())], Response::HTTP_OK);
    }

    /**
     * Get all academic year resources.
     *
     * @return JsonResponse
     */
    public function session(): JsonResponse
    {
        $sessions = Session::latest()->get();

        return response()->json(['data' => SessionResource::collection($sessions)], Response::HTTP_OK);
    }

    /**
     * Get all lecturer (or user) resources.
     *
     * @return JsonResponse
     */
    public function lecturers(): JsonResponse
    {
        $lecturers = User::latest()->get();

        return response()->json(['data' => UserResource::collection($lecturers)], Response::HTTP_OK);
    }
}
