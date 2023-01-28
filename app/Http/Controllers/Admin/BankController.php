<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Http\Requests\BankRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
	public function index(Request $request)
	{
		$banks = Bank::query();
		$banks = $banks->paginate();
		return view('admin.bank.index', compact('banks'));
	}

	public function create()
	{
		return view('admin.bank.new');
	}

	public function store(BankRequest $request)
	{
		$validated_data = $request->validated();
		try {
			$bank = New Bank();
			$bank->fill($validated_data);
			$bank->save();
			return redirect()->route('admin.banks.edit', [ 'id' => $bank->id ] )
                             ->with('status', __("Bank has been successfully created."));

		} catch (\Exception $e) {
			return back()->withInput()->withErrors([ 'bank' => $e->getMessage()]);
		}
	}

	public function edit($id)
	{
		$bank = Bank::findOrFail($id);
		return view('admin.bank.edit', compact('bank'));
	}

	public function update(BankRequest $request, $id)
	{
		$bank = Bank::findOrFail($id);
		$validated_data = $request->validated();
		try {
			$bank->fill($validated_data);
			$bank->save();
			return redirect()->route('admin.banks.edit', [ 'id' => $bank->id ] )
                             ->with('status', __("Bank has been successfully updated."));
		} catch (\Exception $e) {
			 return back()->withInput()->withErrors([ 'bank' => $e->getMessage()]);
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
        $result = Bank::destroy($id);

        if ( $result == 0 ) {
            return response()->json([
                "message" => __("Invalid object!"),
            ], 404); 
        } else {
            return response()->json([
                "message" => __("Resource has been successfully removed.")
            ], 200);
        }
    }
}
