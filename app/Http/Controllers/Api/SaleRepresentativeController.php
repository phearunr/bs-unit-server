<?php

namespace App\Http\Controllers\Api;

use App\SaleRepresentative;
use App\Http\Resources\SaleRepresentative as SaleRepresentativeResource;
use App\Http\Resources\SaleRepresentativeCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleRepresentativeController extends Controller
{
	public function index(Request $request)
   	{
   		$search_term = $request->term ?? "";

   		$sale_representatives = SaleRepresentative::where('name', 'LIKE', '%'.$search_term.'%')
   								->orWhere('name_en', 'LIKE', '%'.$search_term.'%')
   								->orWhere('national_id', 'LIKE', '%'.$search_term.'%');

   		if ( $request->input('embed') ){
            $relationships = explode(',', trim($request->input('embed')) );
            $sale_representatives = $sale_representatives->load($relationships);
        }

        return new SaleRepresentativeCollection( $sale_representatives->paginate() );
   	}

   	public function show(Request $request, $id)
   	{
   		$sale_representative = SaleRepresentative::findOrFail($id);
   		if ( $request->input('embed') ){
            $relationships = explode(',', trim($request->input('embed')) );
            $sale_representative = $sale_representative->load($relationships);
        }

        return new SaleRepresentativeResource($sale_representative);
   	}
}
