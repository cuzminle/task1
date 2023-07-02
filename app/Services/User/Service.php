<?php

namespace App\Services\User;

use App\Http\Requests\User\StoreRequest;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Service
{
    public function register(StoreRequest $request)
    {
        $data = $request->validated();
        
        $user = User::firstOrCreate($data);
 
        Salary::create([
            'user_id' => $user->id,
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return $token;
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) 
        {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
            
        $user = User::where('email', $request['email'])->firstOrFail();
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return $token;
    }

    public function report(Request $request)
    {
        $data = $request->validate([
            'hours' => 'required|integer'
        ]);

        Salary::where('user_id', Auth::id())->incrementEach([
            'hours' => $data['hours'],
            'debt' => $data['hours']*500
        ]);
    }

    public function payment()
    {
        $salary = Salary::where('user_id', Auth::id())->first();
        $salary->hours = 0;
        $salary->debt = 0;
        $salary->save();
    }

    
}