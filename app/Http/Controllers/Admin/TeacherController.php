<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Employee;
use App\Role;

class TeacherController extends Controller
{
     /**
     * Instantiate a new EmployeeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employees');
    }

    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'full_name' => 'required|string',
            'nip' => 'required|max:15|unique:employees',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new Employee;
            $user->full_name = $request->input('full_name');
            $user->nip = $request->input('nip');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();
            $role = Role::where('name', 'Teacher')->firstOrFail();
            $user->roles()->attach($role);

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * Get all Employee.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  Employee::with('roles')->get()], 200);
    }

    /**
     * Get one Employee.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = Employee::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function guard() {
        return Auth::guard('employees');
    }
}
