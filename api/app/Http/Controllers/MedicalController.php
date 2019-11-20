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
        return response()->json($this->medicals->getMedicals(), 200);
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
        return response()->json($this->medicals->getMedical($search), 200);
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
        return response()->json($this->medicals->getMedicalById($id), 200);
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
            'crm' => 'integer|unique:medicals',
            'phone' => 'string|max:11',
            'medicals_specialties' => 'array|min:2'
        ]);

        $data = $request->all();
        $return = $this->medicals->setMedical($data, $id);
        return response()->json($return, 201);
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
            'phone' => 'required|string|max:11',
            'medicals_specialties' => 'required|array|min:2'
        ]);

        $data = $request->all();
        $return = $this->medicals->setMedical($data);
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
        $return = $this->medicals->removeMedical($id);
        if (empty($return)) {
            return response()->json(null, 204);
        } else {
            return response()->json($return, 422);
        }
    }
}
