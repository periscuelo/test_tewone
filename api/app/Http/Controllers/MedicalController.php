<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medical;

class MedicalController extends Controller
{
    /**
     * The medicals model instance.
     */
    protected $medicals;

    /**
     * Create a new controller instance.
     *
     * @param  Medical  $medicals
     * @return void
     */
    public function __construct(Medical $medicals)
    {
        $this->medicals = $medicals;
    }

    /**
     * index
     *
     * Get the list of medicals
     *
     * @return Response
     */
    public function index()
    {
        return $this->medicals->getMedicals();
    }

    /**
     * search
     *
     * Get the medical data of one specific filter
     *
     * @param  mixed $search
     *
     * @return Response
     */
    public function search($search)
    {
        return $this->medicals->getMedical($search);
    }

    /**
     * edit
     *
     * Get the data of one specific medical
     *
     * @param  string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return $this->medicals->getMedicalById($id);
    }

    /**
     * update
     *
     * Update data of one specific medical
     *
     * @param  Request $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $return = $this->medicals->setMedical($request, $id);
        return  response()->json($return, 201);
    }

    /**
     * store
     *
     * Create a medical data
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $return = $this->medicals->setMedical($request);
        return response()->json($return, 201);
    }

    /**
     * destroy
     *
     * Apply Softdelete to a specific medical
     *
     * @param  string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->medicals->removeMedical($id);
        return response()->json(null, 204);
    }
}
