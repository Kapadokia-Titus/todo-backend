<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthApiController extends Controller
{

    protected function register(StoreUserRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);

        $user = User::create($request->all());

        $token = $user->createToken('WebToken')->plainTextToken;

        return response()->json(['user' => new UserResource($user), 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('WebToken')->plainTextToken;
            return response()
                ->json([
                    'token' => $token,
                    'user' => new UserResource(auth()->user())
                ]);
        }
        return response()
            ->json(['error' => 'Unauthorised'], Response::HTTP_UNAUTHORIZED);
    }
}
