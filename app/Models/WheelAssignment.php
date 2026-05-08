<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WheelAssignment extends Model
{
    protected $fillable = [
        'wheel_id',
        'foster_id',
        'start_date',
        'end_date',
        'sequence',
        'is_manual_override',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
