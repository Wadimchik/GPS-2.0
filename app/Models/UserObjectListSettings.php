<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserObjectListSettings extends Model
{
    use HasFactory;

    protected $table = 'user_object_list_settings';

    protected $fillable = [
        'user_id',
        'show_on_map_action_is_visible',
        'object_name_is_visible',
        'object_state_info_is_visible',
        'last_message_info_is_visible',
        'target_on_action_is_visible',
        'sleep_object_messages_is_visible',
        'radio_bookmarks_is_visible',
        'objects_managing_is_visible',
        'reports_is_visible',
        'objects_settings_is_visible',
    ];
}
