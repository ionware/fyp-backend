<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Session;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StatController extends Controller
{
    /**
     * Overall system statistics.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $statistic = [
            'users' => User::count(),
            'sessions' => Session::count(),
            'students' => Student::count(),
            'keys' => ApiKey::count(),
        ];

        return response()->json(['data' => $statistic], Response::HTTP_OK);
    }
}
