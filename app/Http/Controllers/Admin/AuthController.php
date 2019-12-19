<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Employee;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
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
            if($request->has('password')) {
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
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['nip', 'password']);

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
        return Auth::guard('employees');
    }
}
