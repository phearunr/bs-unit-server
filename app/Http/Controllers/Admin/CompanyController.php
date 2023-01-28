<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Requests\StoreCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Company::query();
        $companies = $companies->with(['createdBy']);
        $companies = $companies->withCount(['projects']);
        
        $companies = $companies->paginate();

        return view('admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.company.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request)
    {
        $company = New Company();        
        $validated_data = $request->validated();
        $validated_data['user_id'] = Auth::id();
        $validated_data = $this->covertToStandardDateFormat($validated_data, $company->getDates());
        try {
            $company->fill($validated_data);
            $company->save();
            return redirect()->route('admin.companies.edit', ['id' => $company->id])
                             ->with('status', __("Company has been created successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'company' => $e->getMessage()]);
        }
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
        $company = Company::findOrFail($id);
        return view('admin.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompany $request, $id)
    {        
        $company = Company::findOrFail($id);
        $validated_data = $request->validated();
        $validated_data['user_id'] = Auth::id();

        $validated_data = $request->validated();
        $validated_data = $this->covertToStandardDateFormat($validated_data, $company->getDates());

        try {            
            $company->fill($validated_data);
            $company->save();
            return redirect()->route('admin.companies.edit', ['id' => $company->id])
                             ->with('status', __("Company has been updated successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'company' => $e->getMessage()]);
        }
    }

     /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.company.delete', compact('company'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
