<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws ValidationException
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        $status = Password::sendResetLink($validated);

        return $status == Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : throw ValidationException::withMessages([
                'email' => [__($status)]
            ]);
    }
}
