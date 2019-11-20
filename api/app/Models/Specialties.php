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

    public function medicals_specialties()
    {
        return $this->belongsToMany(Medical::class, 'medicals_x_specialties', 'id_specialty', 'id_medical')
                    ->withTimestamps();
    }
}
