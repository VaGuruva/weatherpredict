<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Requests\LoginAuthRequest;
use App\Repository\EloquentRepositoryInterface;

class AuthController extends Controller
{
    private $authRepository;
  
    public function __construct(EloquentRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Register new user.
     * @param  \App\Http\Requests\RegisterAuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterAuthRequest $request) {

        $user = $this->authRepository->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * User login.
     * @param  \App\Http\Requests\LoginAuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginAuthRequest $request) {
 
        $user = $this->authRepository->find('email', $request->input('email'));

        if(!$user || !Hash::check($request->input('password'), $user->password)) {
            return response([
                'message' => 'Supplied email or password are incorrect, Please try again.'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * User logout.
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
