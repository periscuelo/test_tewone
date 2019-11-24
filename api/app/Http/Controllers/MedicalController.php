<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicals;

class MedicalController extends Controller
{
    /**
     * The medicals model instance.
     */
    protected $medicals;

    /**
     * Create a new controller instance.
     *
     * @param  Medicals  $medicals
     * @return void
     */
    public function __construct(Medicals $medicals)
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
        $return = $this->medicals->getMedicals();
        $status = (!array_key_exists('status', $return)) ? 200 : 422;
        return response()->json($return, $status);
    }

    /**
     * search
     *
     * Get the medical data of one specific filter
     *
     * @param  Request $request->search
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $return = $this->medicals->getMedical($request->search);
        $status = (!array_key_exists('status', $return)) ? 200 : 422;
        return response()->json($return, $status);
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
        $return = $this->medicals->getMedicalById($id);
        $status = (!array_key_exists('status', $return)) ? 200 : 422;
        return response()->json($return, $status);
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
        // Validate fields
        $this->validate($request, [
            'name' => 'string|max:150',
            'crm' => 'integer',
            'phone' => 'string|between:10,11',
            'medicals_specialties' => 'array|min:2'
        ]);

        $data = $request->all();
        $return = $this->medicals->setMedical($data, $id);
        $status = (!array_key_exists('status', $return)) ? 201 : 422;
        return response()->json($return, $status);
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
        // Validate fields
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'crm' => 'required|integer|unique:medicals',
            'phone' => 'required|string|between:10,11',
            'medicals_specialties' => 'required|array|min:2'
        ]);

        $data = $request->all();
        $return = $this->medicals->setMedical($data);
        $status = (!array_key_exists('status', $return)) ? 201 : 422;
        return response()->json($return, $status);
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
        $return = $this->medicals->removeMedical($id);
        $status = ($return === true) ? 204 : 422;
        return response()->json($return, $status);
    }
}
