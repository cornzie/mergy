<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //    
    /**
     * Login - Creates an authentication token for a user
     *
     * @return void
     */
    public function login(LoginRequest $request)
    {
        // 
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return $this->formattedError('Incorrect login details', 400);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return $this->formattedResponse([
            'auth_token' => $token
        ]);
    }
    
    /**
     * Logout - Destroys an authentication token
     *
     * @return void
     */
    public function logout()
    {

        if(Auth::user()->tokens()->delete()){

            return $this->formattedResponse([
                'logged_out' => true
            ]);
        }

        return $this->formattedError('Something went wrong', 500);

    }
}
