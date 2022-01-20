<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileSaveRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function info(Request $request): UserResource
    {
        $user = $request->user();
        return new UserResource($user->load(['permissions', 'role.permissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function update(ProfileSaveRequest $request): UserResource
    {
        $user = $request->user();
        $user->fill($request->only(['name', 'email', 'description']));

        if($password = $request->get('password')) {
            $user->password = bcrypt($password);
        }

        // Save user avatar
        if($request->hasFile('avatar')) {
            $user->avatar = $request->avatar->store('images/profile', 'public');
        }

        $user->save();
        return new UserResource($user->load(['permissions', 'role.permissions']));
    }
}
