<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\UserAccountPermission;
use App\Models\UserObjectPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class PermissionController extends Controller
{
    public function get(Request $request): object
    {
        $currentUserId = $request->id;
        $accountsPermissions = UserAccountPermission::with(['permission', 'account'])
            ->where('user_id', $currentUserId)
            ->get()
            ->makeHidden(['user_id', 'permission_id', 'id'])
            ->toArray();
        $objectsPermissions = UserObjectPermission::with(['permission', 'object'])
            ->where('user_id', $currentUserId)
            ->get()
            ->makeHidden(['user_id', 'permission_id', 'id'])
            ->toArray();
        
        $result = [];
        if ($accountsPermissions) {
            array_map(function ($permission) use (&$result) {
                $key = 'account_' . $permission['account_id'];
                if (empty($result[$key])) {
                    $result[$key] = [
                        'id' => $permission['account_id'],
                        'name' => $permission['account']['name'],
                        'permissions' => [],
                        'entity_type' => 'account',
                    ];
                }
                $result[$key]['permissions'][] = str_replace('-', '_', $permission['permission']['type']);
            }, $accountsPermissions);
        }
        if ($objectsPermissions) {
            array_map(function ($permission) use (&$result) {
                $key = 'object_' . $permission['object_id'];
                if (empty($result[$key])) {
                    $result[$key] = [
                        'id' => $permission['object_id'],
                        'name' => $permission['object']['name'],
                        'permissions' => [],
                        'entity_type' => 'object',
                    ];
                }
                $result[$key]['permissions'][] = str_replace('-', '_', $permission['permission']['type']);
            }, $objectsPermissions);
        }
        return response()->json(array_values($result));
    }

    public function add(Request $request): object
    {
        try {
            $request->validate([
                'permissions' => 'array',
                'user_id' => 'required|int'
            ]);
        } catch (Throwable $e) {
            if ($e instanceof ValidationException) {
                return response([
                    'data' => [
                        'message' => 'Validation error',
                        'errors' => $e->validator->getMessageBag()
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $permissions = $request->permissions ? $request->permissions : [];
        $objectsPermissions = [];
        $accountsPermissions = [];
        array_map(function ($permission) use (&$objectsPermissions, &$accountsPermissions) {
            if ($permission['entity_type'] === 'object') {
                $objectsPermissions[] = $permission;
            } else {
                $accountsPermissions[] = $permission;
            }
        }, $permissions);

        $currentUserId = $request->user_id;
        DB::transaction(function() use ($currentUserId, $objectsPermissions, $accountsPermissions): void {
            UserObjectPermission::where('user_id', $currentUserId)->delete();
            UserAccountPermission::where('user_id', $currentUserId)->delete();

            if ($objectsPermissions || $accountsPermissions) {
                $permissions = Permission::select('id', 'type')->get()->toArray();
                $permissions = array_column($permissions, 'id', 'type');
                if ($objectsPermissions) {
                    $itemsForInsert = [];
                    array_map(function ($permission) use ($currentUserId, $permissions, &$itemsForInsert) {
                        array_map(function ($item) use ($permission, $currentUserId, $permissions, &$itemsForInsert) {
                            $key = str_replace('-', '_', $item);
                            if (!empty($permission[$key])) {
                                $itemsForInsert[] = [
                                    'user_id' => $currentUserId,
                                    'object_id' => $permission['id'],
                                    'permission_id' => $permissions[$item],
                                ];
                            }
                        }, array_keys($permissions));
                    }, $objectsPermissions);
                    if ($itemsForInsert) {
                        UserObjectPermission::insert($itemsForInsert);
                    }
                }
                if ($accountsPermissions) {
                    $itemsForInsert = [];
                    array_map(function ($permission) use ($currentUserId, $permissions, &$itemsForInsert) {
                        array_map(function ($item) use ($permission, $currentUserId, $permissions, &$itemsForInsert) {
                            $key = str_replace('-', '_', $item);
                            if (!empty($permission[$key])) {
                                $itemsForInsert[] = [
                                    'user_id' => $currentUserId,
                                    'account_id' => $permission['id'],
                                    'permission_id' => $permissions[$item],
                                ];
                            }
                        }, array_keys($permissions));
                    }, $accountsPermissions);
                    if ($itemsForInsert) {
                        UserAccountPermission::insert($itemsForInsert);
                    }
                }
            }
        });
        return response()->json(['result' => true]);
    }
}
