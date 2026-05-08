<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WheelMember extends Model
{
    protected $fillable = [
        'wheel_id',
        'foster_id',
        'position',
        'type',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'left_at' => 'date',
    ];

    public function wheel()
    {
        return $this->belongsTo(Wheel::class);
    }

    public function foster()
    {
        return $this->belongsTo(Foster::class);
    }
}
