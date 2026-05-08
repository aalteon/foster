<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foster extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'foster_image',
        'phone',
        'address',
        'status',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wheelMembers()
    {
        return $this->hasMany(WheelMember::class);
    }

    public function assignments()
    {
        return $this->hasMany(WheelAssignment::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
