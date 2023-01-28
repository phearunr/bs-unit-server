<?php

namespace App\Http\Controllers\Admin;

use App\SaleRepresentative;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SaleRepresentativeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view-project')->only('index');
        // $this->middleware('permission:create-project')->only(['create','store']);
        // $this->middleware('permission:update-project')->only(['edit','update']);
        // $this->middleware('permission:delete-project')->only(['showDeleteForm','showRetoreForm','destroy','restore']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $sale_representatives = SaleRepresentative::query();
        // $sale_representatives = $sale_representatives->withCount(['unitTypes']);


        if ( $request->query('term') ) {
            $term = $request->query('term');
            $sale_representatives = $sale_representatives->where('name' , 'LIKE', '%'.$term.'%');
        }

        $sale_representatives = $sale_representatives->paginate(10);

        return view('admin.sale_representative.index', compact('sale_representatives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.sale_representative.new");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:200",
            "name_en" => "nullable|string|max:200",
            "gender" => ['required', Rule::in(['Male', "Female"])],
            "birth_date" => "required|date",
            "national_id" => "required|string|max:200",
            "national_id_issued_date" => "required|date",
            "contact_number" => "required|string|max:200",
            "national_id_front_attachment_url" => "required|image",
            "national_id_back_attachment_url" => "required|image",
            "authorize_letter_url" => "required|image"
        ]);

        if ( is_null($request->name_en) ) {
            $validatedData['name_en'] = "";
        }

        try {          
            if ( $request->hasFile('national_id_front_attachment_url') ) {
                $path = $request->file('national_id_front_attachment_url')->store("sale_representative","public");  
                $validatedData['national_id_front_attachment_url'] = $path;
            }

            if ( $request->hasFile('national_id_back_attachment_url') ) {
                $path = $request->file('national_id_back_attachment_url')->store("sale_representative","public");  
                $validatedData['national_id_back_attachment_url'] = $path;
            }

            $sale_representative =  New SaleRepresentative();
            $validatedData = $this->covertToStandardDateFormat($validatedData, $sale_representative->getDates());
            $sale_representative = $sale_representative->fill($validatedData);
            $sale_representative->save();
           
            return redirect()->route('admin.sale_representatives.edit', ['id' => $sale_representative->id])
                             ->with('status', "Sale Representative has been created successfully.");

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'sale_representative' => $e->getMessage()]);
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
        $sale_representative = SaleRepresentative::findOrFail($id);

        return view('admin.sale_representative.edit', compact("sale_representative"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:200",
            "name_en" => "nullable|string|max:200",
            "gender" => ['required', Rule::in(['Male', "Female"])],
            "birth_date" => "required|date",
            "national_id" => "required|string|max:200",
            "national_id_issued_date" => "required|date",
            "contact_number" => "required|string|max:200",
            "national_id_front_attachment_url" => "nullable|image",
            "national_id_back_attachment_url" => "nullable|image",
            "authorize_letter_url" => "nullable|image"
        ]);

        if ( is_null($request->name_en) ) {
            $validatedData['name_en'] = "";
        }

        $sale_representative = SaleRepresentative::findOrFail($id);

        try {
            if ( $request->hasFile('national_id_front_attachment_url') ) {
                $sale_representative->deleteNationalIdFrontAttachmentUrlImage();
                $path = $request->file('national_id_front_attachment_url')->store("sale_representative","public");  
                $validatedData['national_id_front_attachment_url'] = $path;
            }
            if ( $request->hasFile('national_id_back_attachment_url') ) {
                $sale_representative->deleteNationalIdBackAttachmentUrlImage();
                $path = $request->file('national_id_back_attachment_url')->store("sale_representative","public");  
                $validatedData['national_id_back_attachment_url'] = $path;
            }
            if ( $request->hasFile('authorize_letter_url') ) {
                $sale_representative->deleteAuthorizeLetterUrlImage();
                $path = $request->file('authorize_letter_url')->store("sale_representative","public");  
                $validatedData['authorize_letter_url'] = $path;
            }
            $validatedData = $this->covertToStandardDateFormat($validatedData, $sale_representative->getDates());
            $sale_representative = $sale_representative->fill($validatedData);
            $sale_representative->save();
            return redirect()->route('admin.sale_representatives.edit', ['id' => $sale_representative->id])
                             ->with('status', "Sale Representative has been updated successfully.");
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'sale_representative' => $e->getMessage()]);
        }
        


    }

    public function showDeleteForm($id) 
    {
        $sale_representative = SaleRepresentative::findOrFail($id);
        return view('admin.sale_representative.delete',compact("sale_representative"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale_representative = SaleRepresentative::findOrFail($id);
        try {           
            $sale_representative->delete();
            return redirect()->route('admin.sale_representatives.index')->with('status', "Sale Representative : $sale_representative->name has been successfully deleted.");
        } catch (\Exception $e) {
            return back()->withErrors([ 'sale_representative' => $e->getMessage()]);
        }
    }
}
