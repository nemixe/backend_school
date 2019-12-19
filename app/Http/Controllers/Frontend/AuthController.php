<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Student;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function create(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'employee_id' => 'required|exists:employees,id',
            'full_name' => 'required|string',
            'nis' => 'required|max:15|unique:elearning_students',
            // 'password' => 'required|confirmed',
        ]);

        try {
            $user = new Student;
            $user->employee_id = $request->input('employee_id');
            $user->full_name = $request->input('full_name');
            $user->nis = $request->input('nis');
            if($request->has('password')){
                $plainPassword = $request->input('password');
                $user->password = app('hash')->make($plainPassword);
            }

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function login(Request $request)
    {
          //validate incoming request
        $this->validate($request, [
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['nis', 'password']);

        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return  response()->json(['status' => 'success'], 200)
            ->header('Authorization', $token);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function guard() {
        return Auth::guard('students');
    }
}
