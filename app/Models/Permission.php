<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /* Permission types */
    public const VIEW = 'view';
    public const VIEW_SLEEPING = 'view-sleeping';
    public const BLOCKING = 'blocking';
    public const COORDINATE = 'coordinate';
    public const REBOOT = 'reboot';
    public const PROPERTY_VIEW = 'property-view';
    public const PROPERTY_CHANGE = 'property-change';
    public const FUEL = 'fuel';
    public const SENSOR = 'sensor';

    protected $table = 'permissions';
}
