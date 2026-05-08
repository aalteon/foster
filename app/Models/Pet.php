<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'species',
        'breed',
        'color',
        'gender',
        'dob',
        'weight',
        'description',
    ];

    public function wheels()
    {
        return $this->belongsToMany(Wheel::class);
    }

    public function getFullLabelAttribute()
    {
        return ucwords($this->name . ' - ' . $this->species);
    }

    public function scopeAvailable($query, $currentWheelId = null)
    {
        return $query->whereDoesntHave('wheels', function ($q) use ($currentWheelId) {

            $q->where('is_active', true);

            if ($currentWheelId) {
                $q->where('wheels.id', '!=', $currentWheelId);
            }
        });
    }
}
