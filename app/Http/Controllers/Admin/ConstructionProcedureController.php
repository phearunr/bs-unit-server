<?php

namespace App\Http\Controllers\Admin;

use App\ConstructionProcedure;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateConstructionProcedureRequest;
use App\Http\Controllers\Controller;

class ConstructionProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $construction_procedures = ConstructionProcedure::query()
        ->when( $term = $request->term, function ($query, $term) {
            return $query->where('name', 'LIKE', "%$term%")
                         ->orWhere('name_km', 'LIKE', "%$term%");
        })
        ->paginate();

        return view('admin.construction_procedure.index', compact('construction_procedures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $construction_procedure = ConstructionProcedure::where('id', $id)->firstOrFail();
        return view('admin.construction_procedure.edit', compact('construction_procedure') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConstructionProcedureRequest $request, $id)
    {
        $construction_procedure = ConstructionProcedure::where('id', $id)->firstOrFail();
        $validated_data = $request->validated();
        $validated_data = $this->covertToStandardDateFormat($validated_data, $construction_procedure->getDates());

        try {            
            $construction_procedure->fill($validated_data);
            $construction_procedure->save();
            return redirect()->route('admin.construction_procedures.edit', ['id' => $construction_procedure->id])
                             ->with('status', __("Construction Procedure has been updated successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'construction_procedure' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
