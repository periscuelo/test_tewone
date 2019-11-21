<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Exception;

class Medicals extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'crm',
        'phone'
    ];

    public function medicals_specialties()
    {
        return $this->belongsToMany(Specialties::class, 'medicals_x_specialties', 'id_medical', 'id_specialty')
                    ->withTimestamps();
    }

    public function getMedicals($debug=false) {
        $query = $this->with('medicals_specialties');

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

    public function getMedical($search, $debug=false) {
        $query = $this->with('medicals_specialties');

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
            $query = $query->get()->toArray();
            if (empty($query)) {
                $query = ['status'=> 'Houston, we\'ve had a problem', 'info' => 'Registries not found'];
            }
        }

        return $query;
    }

    public function getMedicalById($id, $debug=false) {
        $query = $this->with('medicals_specialties')
                      ->where('id', $id);

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            $query = $query->first();
            if (is_null($query)) {
                $query = ['status'=> 'Houston, we\'ve had a problem', 'info' => 'Registry not found'];
            }
        }

        return $query;
    }

    public function setMedical($request, $id=0, $debug=false) {
        $query = $this->firstOrNew(['id' => $id]);
        $medicals_specialties = $request['medicals_specialties'];
        unset($request['medicals_specialties']);

        foreach($request AS $key => $value) {
            $query->{$key} = $value;
        }

        if ($debug) {
            $bindings = $query->getBindings();
            $query = str_replace('?', "'?'", $query->toSql());
            $query = vsprintf(str_replace('?', '%s', $query), $bindings);
        } else {
            DB::beginTransaction();
            try {
                // Save medicals data
                $query->save();
                if (isset($query->id)) {
                    // Save data in Pivot Medicals x Specialties
                    $query->medicals_specialties()->sync($medicals_specialties);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                $this->refreshDB();
                $query = ['status'=> 'Houston, we\'ve had a problem', 'info' => $e->errorInfo];
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
            if (!is_null($query)) {
                $query = $query->delete();
            } else {
                $query = ['status'=> 'Houston, we\'ve had a problem', 'info' => 'Registry to delete not found'];
            }
        }

        return $query;
    }

    public function refreshDB()
    {
        $maxM = DB::table('medicals')->max('id') + 1;
        $maxMXS = DB::table('medicals_x_specialties')->max('id') + 1;
        DB::statement("ALTER TABLE medicals AUTO_INCREMENT =  $maxM");
        DB::statement("ALTER TABLE medicals_x_specialties AUTO_INCREMENT =  $maxMXS");
    }
}
