<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentModel extends Model
{
    use HasFactory;

    protected $table = 'equipment';


    /**
     * Get the last message from tracker for the equipment.
     */
    public function lastMessage()
    {
        return $this->hasOne(Tracker::class, 'imei', 'imei')->latest('time');
    }

    /**
     * Get the messages from tracker for the equipment.
     */
    public function messages()
    {
        return $this
            ->hasMany(Tracker::class, 'imei', 'imei')
            ->orderBy('time', 'desc');
    }
}
