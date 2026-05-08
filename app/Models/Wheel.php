<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Wheel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'duration_days',
        'rotation_start_date',
        'generate_days_ahead',
        'is_active',
        'notification',
    ];

    public function members()
    {
        return $this->hasMany(WheelMember::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(WheelAssignment::class)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->latest('start_date');
    }

    public function nextAssignment()
    {
        return $this->hasOne(WheelAssignment::class)
            ->whereDate('start_date', '>', now())
            ->orderBy('start_date');
    }

    public function getPetsLabelAttribute()
    {
        return $this->pets
            ->unique('id')
            ->pluck('full_label')
            ->join(', ');
    }

    public function pets()
    {
        return $this->belongsToMany(Pet::class);
    }

    public function primary_fosters()
    {
        return $this->hasMany(WheelMember::class)
            ->where('type', 'primary');
    }

    public function backup_fosters()
    {
        return $this->hasMany(WheelMember::class)
            ->where('type', 'backup');
    }

    public function assignments()
    {
        return $this->hasMany(WheelAssignment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('position')->orderBy('pivot_position');
    }
}
