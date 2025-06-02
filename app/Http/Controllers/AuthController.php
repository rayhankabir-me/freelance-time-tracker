<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public string $token;

    /**
     * @throws \Exception
     */
    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $this->token = $user->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'message' => "Login Success..!",
            'token' => $this->token,
            'user' => new UserResource($user),
        ], 201);
    }


    public function register(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'email_verified_at' => now(),
            'password' => Hash::make($request->post('password'))
        ]);
        if ($user) {
            return response(['status' => true, 'message' => 'Registration successful..!']);
        } else {
            return response(['status' => false, 'message' => 'Registration not completed, something wrong..!'], 422);
        }

    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return new JsonResponse([
            'message' => 'Logged Out Successfully'
        ], 200);
    }
}
