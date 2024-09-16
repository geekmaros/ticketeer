<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request)
    {

       $request->validated($request->all());


//        $request->validate([
//            'email' => ['required', 'string', 'email'],
//            'password' => ['required', 'string', 'min:8'],
//        ]);



       if(! Auth::attempt($request->only('email', 'password'))){
           return $this->error('Invalid credentials', 401);
       }

       $user = User::firstWhere('email', $request->email);

       return $this->ok(
           'Authenticated',
           ['token' => $user->createToken(
               'API token for'. $user->email,
               ['*'],
               now()->addMonth()
           )->plainTextToken
           ]
            );


    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return $this->ok('Logged out successfully');
    }

    public function register(ApiLoginRequest $request)
    {

        return $this->ok('',$request->all());
    }
}
