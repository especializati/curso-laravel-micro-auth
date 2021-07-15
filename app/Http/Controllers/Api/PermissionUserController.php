<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;

class PermissionUserController extends Controller
{
    public function permissionsUser(Request $request)
    {
        $permissions = $request->user()->permissions()->get();

        return PermissionResource::collection($permissions);
    }
}
