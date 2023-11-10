<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethodModel extends Model
{
    use HasFactory;

    protected $table = "pay_methods";
}
