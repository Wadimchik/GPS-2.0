<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccountBalanceHistory extends Model
{
    use HasFactory;

    protected $table = 'account_balance_history';

    public function operation_type(): HasOne
    {
        return $this->hasOne(OperationTypeModel::class, 'id', 'operation_types_id');
    }
}
