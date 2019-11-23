<?php

namespace App\Http\Controllers;

use App\Models\Specialties;

class SpecialtiesController extends Controller
{
    /**
     * The medicals model instance.
     */
    protected $specialties;

    /**
     * Create a new controller instance.
     *
     * @param  Specialties  $specialties
     * @return void
     */
    public function __construct(Specialties $specialties)
    {
        $this->specialties = $specialties;
    }

    /**
     * index
     *
     * Get the list of specialties
     *
     * @return Response
     */
    public function index()
    {
        $return = $this->specialties->getSpecialties();
        $status = (!array_key_exists('status', $return)) ? 200 : 422;
        return response()->json($return, $status);
    }
}
