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

    public function getSpecialties($debug=false) {
        $query = $this;

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->get()->toArray();
            if (empty($query)) {
                $query = ['status'=> 'Houston, we\'ve had a problem', 'info' => 'Registries not found'];
            }
        }

        return $query;
    }
}
