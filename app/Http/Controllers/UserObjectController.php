<?php

namespace App\Http\Controllers;

use App\Models\ObjectsModel;
use App\Models\UserObject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserObjectController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'object_id' => 'required',
                'show_on_map' => 'boolean',
                'target_on' => 'boolean',
            ]);
        } catch (Throwable $e) {
            if ($e instanceof ValidationException) {
                return response([
                    'data' => [
                        'message' => 'Validation error',
                        'errors' => $e->validator->getMessageBag()
                    ]
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        $objectRows = ObjectsModel::find(['id' => $request->object_id]);
        if ($objectRows->isEmpty()) {
            return response([
                'data' => ['message' => "Object with ID {$request->object_id} not exist"]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $objectId = $objectRows->first()->id;
        UserObject::create([
            'user_id' => $request->user()->id,
            'object_id' => $objectId,
            'show_on_map' => isset($request->show_on_map),
            'target_on' => isset($request->target_on),
        ]);
        $object = ObjectsModel::with(['equipments.lastMessage', 'userObject'])
            ->where(['id' => $objectId])
            ->first();
        return response()->json($object);
    }

    public function changeShowOnMap(Request $request)
    {
        try {
            $request->validate(['show_on_map' => 'required|boolean']);
        } catch (Throwable $e) {
            if ($e instanceof ValidationException) {
                return response([
                    'data' => [
                        'message' => 'Validation error',
                        'errors' => $e->validator->getMessageBag()
                    ]
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        $userObject = UserObject::find(['id' => $request->id])->first();
        if (!$userObject) {
            return response([
                'data' => ['message' => "Object with ID {$request->id} not exist"]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $showOnMap = intval($request->show_on_map);
        if ($userObject->show_on_map === $showOnMap) {
            $text = $showOnMap ? 'enabled' : 'disabled';
            return response([
                'data' => ['message' => "Object option already {$text}"]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $userObject->show_on_map = boolval($request->show_on_map);
        $userObject->save();
        $object = ObjectsModel::with(['equipments.lastMessage', 'userObject'])
            ->where(['id' => $userObject->object_id])
            ->first();
        return response()->json($object);
    }

    public function changeTargetOn(Request $request)
    {
        try {
            $request->validate(['target_on' => 'required|boolean']);
        } catch (Throwable $e) {
            if ($e instanceof ValidationException) {
                return response([
                    'data' => [
                        'message' => 'Validation error',
                        'errors' => $e->validator->getMessageBag()
                    ]
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        $userObject = UserObject::find(['id' => $request->id])->first();
        if (!$userObject) {
            return response([
                'data' => ['message' => "Object with ID {$request->id} not exist"]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $targetOn = intval($request->target_on);
        if ($userObject->target_on === $targetOn) {
            $text = $targetOn ? 'enabled' : 'disabled';
            return response([
                'data' => ['message' => "Object option already {$text}"]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $userObject->target_on = boolval($request->target_on);
        $userObject->save();
        $object = ObjectsModel::with(['equipments.lastMessage', 'userObject'])
            ->where(['id' => $userObject->object_id])
            ->first();
        return response()->json($object);
    }

    public function multipleChangeVisibilityInList(Request $request)
    {
        try {
            $request->validate([
                'show_in_list' => 'required|boolean',
                'object_ids' => 'required|string'
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

        $objectIds = explode(',', $request->object_ids);
        $idsForUpdate = [];
        foreach ($objectIds as $objectId) {
            $userObject = UserObject::where([
                'object_id' => intval($objectId), 'user_id' => $request->user()->id
            ])->first();
            if (!$userObject) {
                UserObject::create([
                    'user_id' => $request->user()->id,
                    'object_id' => $objectId,
                    'show_in_list' => $request->show_in_list,
                ]);
            } else {
                $idsForUpdate[] = $objectId;
            }
        }
        if ($idsForUpdate) {
            UserObject::where(['user_id' => $request->user()->id])
                ->whereIn('object_id', $idsForUpdate)
                ->update(['show_in_list' => $request->show_in_list]);
        }
        $objects = ObjectsModel::with(['equipments.lastMessage', 'userObject'])
            ->whereIn('id', $objectIds)
            ->get();
        return response()->json($objects);
    }

    public function multipleChangeShowOnMap(Request $request)
    {
        try {
            $request->validate([
                'show_on_map' => 'required|boolean',
                'object_ids' => 'required|string'
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

        $objectIds = explode(',', $request->object_ids);
        $idsForUpdate = [];
        foreach ($objectIds as $objectId) {
            $userObject = UserObject::where([
                'object_id' => intval($objectId), 'user_id' => $request->user()->id
            ])->first();
            if (!$userObject) {
                UserObject::create([
                    'user_id' => $request->user()->id,
                    'object_id' => $objectId,
                    'show_on_map' => $request->show_on_map,
                ]);
            } else {
                $idsForUpdate[] = $objectId;
            }
        }
        if ($idsForUpdate) {
            UserObject::where(['user_id' => $request->user()->id])
                ->whereIn('object_id', $idsForUpdate)
                ->update(['show_on_map' => $request->show_on_map]);
        }
        $objects = ObjectsModel::with(['equipments.lastMessage', 'userObject'])
            ->whereIn('id', $objectIds)
            ->get();
        return response()->json($objects);
    }
}
