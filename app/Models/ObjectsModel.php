<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ObjectsModel extends Model
{
    use HasFactory;

    protected $table = 'objects';

    /**
     * Get the equipments for the object.
     */
    public function equipments()
    {
        return $this->hasMany(EquipmentModel::class, 'object');
    }

    public function userObject()
    {
        return $this
            ->hasOne(UserObject::class, 'object_id')
            ->where(['user_id' => Auth::user()->getAuthIdentifier()]);
    }

    /**
     * @param Builder $query
     * @param int $userId
     */
    public static function addCheckPermissionViewByObjectCondition(Builder $query, int $userId): void
    {
        $query
            ->select('objects.*')
            ->join(
                'user_object_permission',
                'user_object_permission.object_id',
                '=',
                'objects.id'
            )
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'user_object_permission.permission_id'
            )
            ->where('user_object_permission.user_id', $userId)
            ->where('permissions.type', Permission::VIEW);
    }
}
