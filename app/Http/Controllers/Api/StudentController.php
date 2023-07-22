<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        if($students->count() > 0){
            return response()->json([
                'status' => 200,
                'students' => $students,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'students' => 'No data found!',
            ], 404);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => 'Student created succesfully.'
                ], 200);
            }else{
                return response()->json([
                    'ststus' => '500',
                    'message' => 'Something went wrong.'
                ], 500);
            }
        }
    }

    public function show($id) {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }else{
            return response()->json([
                'ststus' => '404',
                'message' => 'Student not found.'
            ], 404);
        }
    }

    public function edit($id) {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }else{
            return response()->json([
                'ststus' => '404',
                'message' => 'Student not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $student = Student::find($id);

            if($student){
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated succesfully.'
                ], 200);
            }else{
                return response()->json([
                    'ststus' => '404',
                    'message' => 'Student not found!.'
                ], 404);
            }
        }
    }

    public function destroy($id) {
        $student = Student::find($id);

        if($student){
            $student->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Student delete succesfully.'
            ], 200);
        }else{
            return response()->json([
                'ststus' => '404',
                'message' => 'Student not found.'
            ], 404);
        }
    }
}
