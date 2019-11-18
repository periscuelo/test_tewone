<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medical extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'crm',
        'phone'
    ];

    public function medical_specialties()
    {
        return $this->belongsToMany(Specialties::class, 'medical_x_specialties', 'id_medical', 'id_specialty')
                    ->withTimestamps();
    }

    public function getMedicals($debug=false) {
        $query = $this->with('medical_specialties');

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public function getMedical($search, $debug=false) {
        $query = $this->with('medical_specialties');

        $query = $query->where(function($query) use($search) {
            if (!empty($search)) {
                $query = $query->orWhere('name', 'like', "%{$search}%")
                               ->orWhere('crm', 'like', "%{$search}%");

            }
        });

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public function getMedicalById($id, $debug=false) {
        $query = $this->with('medical_specialties')
                      ->where('id', $id);

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->first();
        }

        return $query;
    }

    public function setMedical($request, $id=0, $debug=false) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'crm' => 'required|integer',
            'phone' => 'required|string|max:11',
            'medical_specialties' => 'required|array|min:2'
        ]);

        // Validate fields
        if ($validatedData->fails()) {
            $query = ['errors' => $validatedData];
        } else {
            $query = $this->firstOrNew(['id' => $id]);
            $medical_specialties = (!empty($request['medical_specialties'])) ? json_decode($request['medical_specialties']) : '';
            unset($request['medical_specialties']);

            foreach($request AS $key => $value) {
                $query->{$key} = $value;
            }

            if ($debug) {
                $bindings = $query->getBindings();
                $query = str_replace('?', "'?'", $query->toSql());
                $query = vsprintf(str_replace('?', '%s', $query), $bindings);
            } else {
                $query->save();
                if (isset($query->id)) {
                    // Save data in Pivot Medical x Specialties
                    $query = $this->updatePivots($medical_specialties, $query, 'medical_specialties', 'id_medical', 'id_specialty');

                    $query = $query->id;
                } else {
                    $query = 0;
                }
            }
        }

        return $query;
    }

    public function removeMedical($id, $debug=false) {
        $query = $this->find($id);

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->delete();
        }

        return $query;
    }
}
