<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Employee;

class EmployeeController extends Controller
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

    /**
     * Get the authenticated Employee.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Employee::with('roles')->find($this->guard()->id())], 200);
    }

    /**
     * Get all Employee.
     *
     * @return Response
     */
    public function allUsers()
    {
        $roles = Employee::with('roles')->find($this->guard()->id())->roles;
        $isFound = false;
        foreach ($roles as $role) {
            if($role->code == 3) {
                $isFound = true;
            }
        }
        if($isFound) {
            return response()->json(['users' =>  Employee::with('roles')->get(), 'user' => $roles], 200);
        } else {
            return response('Unauthorized.', 401);
        }
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
