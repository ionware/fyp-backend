<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $students =  Student::latest();
        if ($request->query('session')) {
            $students = $students->where('session_id', $request->query('session'));
        } else {
            $latest_session_id = Session::latest()->first()->id;
            $students = $students->where('session_id', $latest_session_id);
        }

        $students = $students->get();

        return response()->json(['data' => StudentResource::collection($students)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'surname' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:students',
            'matricNo' => 'required|unique:students',
            'gender' => '',
            'session_id' => 'required|exists:sessions,id',
            'address' => '',
            'phone' => '',
        ]);

        $student = Student::create($data);

        return response()->json(['data' => new StudentResource($student)], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return response()->json(['data' => new StudentResource($student)], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'surname' => '',
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'matricNo' => '',
            'gender' => '',
            'session_id' => '',
            'address' => '',
            'phone' => '',
        ]);

        $student = Student::findOrFail($id);
        $data = array_filter($data, fn ($field) => !!$field);
        $student->update($data);

        return response()->json(['data' => new StudentResource($student)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['data' => new StudentResource($student)], Response::HTTP_OK);

    }
}
