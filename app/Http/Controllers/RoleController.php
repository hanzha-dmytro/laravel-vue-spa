<?php

namespace App\Http\Controllers;

use App\Http\Filters\RoleFilter;
use App\Http\Requests\RoleIndexRequest;
use App\Http\Requests\RoleSaveRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RoleIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(RoleIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RoleResource::collection(Role::filter(new RoleFilter($request))->with('permissions')->paginate(Role::PAGINATION_LIMIT));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleSaveRequest $request
     * @return RoleResource
     */
    public function store(RoleSaveRequest $request): RoleResource
    {
        $role = Role::create($request->only(['name', 'slug']));
        $role->syncPermissions($request->get('permissions', []));
        return new RoleResource($role->load('permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role->load('permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleSaveRequest $request
     * @param Role $role
     * @return RoleResource
     */
    public function update(RoleSaveRequest $request, Role $role): RoleResource
    {
        $role->update($request->only(['name', 'slug']));
        $role->syncPermissions($request->get('permissions', []));
        return new RoleResource($role->load('permissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return bool|null
     */
    public function destroy(Role $role): ?bool
    {
        return $role->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RoleResource::collection(Role::all());
    }
}
