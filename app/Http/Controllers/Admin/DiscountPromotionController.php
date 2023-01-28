<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\DiscountPromotion;
use App\UnitType;
use App\Http\Requests\StoreDiscountPromotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_promotions = DiscountPromotion::query();
        $discount_promotions = $discount_promotions->with(['createdBy']);

        $discount_promotions = $discount_promotions->get();       

        return view('admin.discount_promotion.index', compact('discount_promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount_promotion.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscountPromotion $request)
    {  
        $validated_data = $request->validated();
        $validated_data['user_id'] = Auth::id();    
        $discount_promotion = New DiscountPromotion();
        $validated_data = $this->covertToStandardDateFormat($validated_data, $discount_promotion->getDates());

        try {
            $discount_promotion->fill($validated_data);
            $discount_promotion->save();
            return redirect()->route('admin.discount_promotions.edit', ['id' => $discount_promotion->id])
                             ->with('status', __("Discount promotion has been created successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'discount_promotion' => $e->getMessage()]);
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
        $discount_promotion = DiscountPromotion::findOrFail($id);
        $discount_promotion->load(['items','items.project']);
        return view('admin.discount_promotion.edit', compact('discount_promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDiscountPromotion $request, $id)
    {
        $discount_promotion = DiscountPromotion::findOrFail($id);

        $validated_data = $request->validated();
        $validated_data['user_id'] = Auth::id();
        $validated_data = $this->covertToStandardDateFormat($validated_data, $discount_promotion->getDates());

        try {
            $discount_promotion->fill($validated_data);
            $discount_promotion->save();

            return redirect()->route('admin.discount_promotions.edit', ['id' => $discount_promotion->id])
                             ->with('status', __("Discount promotion has been updated successfully."));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'discount_promotion' => $e->getMessage()]);
        }
    }

    /**
     * Add Item to the promotion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addItem(Request $request, $id)
    {   
        if ( !$request->wantsJson() ) {
            abort(404);
        }

        $discount_promotion = DiscountPromotion::findOrFail($id);

        $validated_data = $request->validate([
            'unit_type_id' => 'required|exists:unit_types,id'
        ]);

        if ( $discount_promotion->discountPromotionItems()
                                ->where('unit_type_id', $request->unit_type_id)
                                ->first()
        ) {
            return response()->json(["message" => __("This unit type was already added to this promotion.")], 422);
        }

       $discount_promotion->discountPromotionItems()->create(['unit_type_id' => $request->unit_type_id]);

        return response()->json(
            UnitType::find($request->unit_type_id)->load(['project'])
        );
    }

    public function removeItem(Request $request, $id)
    {
        if ( !$request->wantsJson() ) {
            abort(404);
        }

        $discount_promotion = DiscountPromotion::findOrFail($id);

        $validated_data = $request->validate([
            'unit_type_id' => 'required|exists:unit_types,id'
        ]);

        if ( $discount_promotion->discountPromotionItems()
                                ->where('unit_type_id', $request->unit_type_id)
                                ->first() == NULL
        ) {
            return response()->json(["message" => __("This unit type is not exist in this promotion.")], 422);
        }

        try {
            $item = $discount_promotion->discountPromotionItems()->where('unit_type_id', $request->unit_type_id)->delete();
            return response()->json(['message' => __('The unit type has been deleted successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('Internal Server Error!') ], 500);
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
