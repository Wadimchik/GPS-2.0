<?php

namespace App\Http\Controllers;

use App\Models\UserObjectListSettings;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserObjectListSettingsController extends Controller
{
    public function get(Request $request): object | null
    {
        $settings = UserObjectListSettings::where(['user_id' => $request->user()->id])->first();
        return $settings ? response()->json($settings) : null;
    }

    public function change(Request $request): object
    {
        try {
            $request->validate(['settings' => 'required|json']);
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
        $availableSettingKeys = [
            'show_on_map_action_is_visible', 'object_name_is_visible', 'object_state_info_is_visible',
            'last_message_info_is_visible', 'target_on_action_is_visible', 'sleep_object_messages_is_visible',
            'radio_bookmarks_is_visible', 'objects_managing_is_visible', 'reports_is_visible',
            'objects_settings_is_visible'
        ];
        $settings = json_decode($request->settings, true);
        $settingsKeys = array_keys($settings);
        if (array_diff($settingsKeys, $availableSettingKeys)) {
            return response([
                'data' => [
                    'message' => 'Validation error',
                    'errors' => [
                        'settings' => ['Invalid list of settings']
                    ]
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $userObjectListSettings = UserObjectListSettings::where(['user_id' => $request->user()->id])->first();
        if (!$userObjectListSettings) {
            $userObjectListSettings = UserObjectListSettings::create(
                array_merge(['user_id' => $request->user()->id], $settings)
            );
        } else {
            $userObjectListSettings->update($settings);
        }
        return response()->json($userObjectListSettings->fresh());
    }
}
