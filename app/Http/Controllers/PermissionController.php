<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PermissionResource::collection(Permission::all());
    }
}
