<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return Auth::attempt([...$validated, 'is_active' => 1])
            ? response()->json([
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('admin:auth')->plainTextToken
            ])
            : throw ValidationException::withMessages([
                'email' => ['Invalid email or password']
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        Auth::guard('sanctum')->forgetUser();

        return response()->json(null, 204);
    }
}
