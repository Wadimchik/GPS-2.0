<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DateTime;

class TrackerModel extends Model
{
    use HasFactory;

    protected $table = 'tracker';

    protected $appends = ['time_diff', 'is_moving', 'time_utc_timestamp'];

    public function getTimeDiffAttribute()
    {
        $messageTime = new DateTime($this->time);
        $nowTime = new DateTime();
        return ($nowTime->getTimestamp() - $messageTime->getTimestamp());
    }

    public function getTimeUtcTimestampAttribute()
    {
        $messageTime = new DateTime($this->time);
        return $messageTime->getTimestamp();
    }

    public function getIsMovingAttribute()
    {
        return $this->speed > 0 && $this->time_diff < 300; // 300 seconds = 5 minutes
    }
}
