<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissionsUser;
use App\Http\Resources\PermissionResource;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionUserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function permissionsUser($identify)
    {
        $user = $this->user
                        ->where('uuid', $identify)
                        ->with('permissions')
                        ->firstOrFail();

        return PermissionResource::collection($user->permissions);
    }

    public function addPermissionsUser(AddPermissionsUser $request)
    {
        $user = $this->user->where('uuid', $request->user)->firstOrFail();

        $user->permissions()->attach($request->permissions);

        return response()->json(['message' => 'successs']);
    }

    public function userHasPermission(Request $request, $permission)
    {
        $user = $request->user();
        
        if (!$user->hasPermission($permission)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'successs']);
    }
}
