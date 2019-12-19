<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Student;

class StudentController extends Controller
{
     /**
     * Instantiate a new EmployeeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:students');
    }

    /**
     * Get the authenticated Student.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Student::with('employees')->find($this->guard()->id())], 200);
    }

    /**
     * Get all Student.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  Student::with('employees')->get()], 200);
    }

    /**
     * Get one Student.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = Student::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function guard() {
        return Auth::guard('students');
    }
}
