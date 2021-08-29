<?php

namespace App\Http\Controllers;

use App\Http\Filters\UserFilter;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserSaveRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(UserIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection(
            User::filter(new UserFilter($request))->with(['permissions', 'role.permissions'])->paginate(User::PAGINATION_LIMIT)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserSaveRequest $request
     * @return UserResource
     */
    public function store(UserSaveRequest $request): UserResource
    {
        $user = new User($request->only(['name', 'email', 'is_active', 'role_id']));
        $user->password = bcrypt($request->get('password'));

        $user->save();
        $user->syncPermissions($request->get('permissions', []));
        return new UserResource($user->load(['permissions', 'role.permissions']));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['permissions', 'role.permissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserSaveRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserSaveRequest $request, User $user): UserResource
    {
        $user->fill($request->only(['name', 'email', 'is_active', 'role_id']));

        if($password = $request->get('password')) {
            $user->password = bcrypt($password);
        }

        $user->save();
        $user->syncPermissions($request->get('permissions', []));
        return new UserResource($user->load(['permissions', 'role.permissions']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return bool|null
     */
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }
}
