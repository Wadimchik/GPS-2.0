<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserObject extends Model
{
    use HasFactory;

    protected $table = 'user_object';

    protected $fillable = [
        'user_id',
        'object_id',
        'show_on_map',
        'target_on',
        'show_in_list'
    ];
}
