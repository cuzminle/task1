<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $token = $this->userService->login($request);
      
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
        ]);
    }

    public function register(StoreRequest $request)
    {
        $token = $this->userService->register($request);
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function index(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json('logout success');
    }

    public function report(Request $request)
    {
        $this->userService->report($request);

        return response()->json('success');

    }

    public function getDebt()
    {
        $user = User::find(Auth::id());

        return response()->json([
            'employee_id' => $user->salary['user_id'],
            'debt' => $user->salary['debt'],
        ]);
    }

    public function payment()
    {
        $this->userService->payment();
        return response()->json('все долги выплачены');
    }
}
