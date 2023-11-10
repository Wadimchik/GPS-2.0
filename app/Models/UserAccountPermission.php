<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserAccountPermission extends Model
{
    use HasFactory;

    protected $table = 'user_account_permission';

    protected $fillable = [
        'user_id',
        'account_id',
        'permission_id',
    ];

    public function permission(): HasOne
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    public function account(): HasOne
    {
        return $this->hasOne(AccountsModel::class, 'id', 'account_id');
    }
}
