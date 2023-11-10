<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserObjectPermission extends Model
{
    use HasFactory;

    protected $table = 'user_object_permission';

    protected $fillable = [
        'user_id',
        'object_id',
        'permission_id',
    ];

    public function permission(): HasOne
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    public function object(): HasOne
    {
        return $this->hasOne(ObjectsModel::class, 'id', 'object_id');
    }
}
