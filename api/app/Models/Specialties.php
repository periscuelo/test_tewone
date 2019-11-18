<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialties extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'specialty'
    ];

    public function medical_specialties()
    {
        return $this->belongsToMany(Medical::class, 'medical_x_specialties', 'id_specialty', 'id_medical')
                    ->withTimestamps();
    }
}
