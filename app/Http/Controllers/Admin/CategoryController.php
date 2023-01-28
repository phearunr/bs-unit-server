<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{   
    public function __construct()
    {
        $this->middleware('permission:view-category')->only('index');
        $this->middleware('permission:create-category')->only(['create','store']);
        $this->middleware('permission:update-category')->only(['edit','update']);
        $this->middleware('permission:delete-category')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $categories = Category::query();
        $categories = $categories->withCount(['posts']);
        if ( $request->query('term') ) {
            $term = $request->query('term');
            $categories = $categories->where('name' , 'LIKE', '%'.$term.'%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $category = Category::create($request->validated());

        return redirect()->route('admin.categories.edit', ['id' => $category->id])
                             ->with('status', __('Category has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->fill($request->validated());
        try {
            $category->save();
            return redirect()->route('admin.categories.edit', ['id' => $category->id])
                             ->with('status', __('Category has been updated successfully.'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([ 'project' => $e->getMessage()]);
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
        $category = Category::findOrFail($id);
        if ( $category->default ) {
            return response()->json([
                "message" => __("You can not delete category which was created by System.")
            ], 422); 
        }

        try {
            if ( $category->delete() ) {
                return response()->json([
                    "message" => "Category has been deleted successfully"
                ], 200);
            }
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                "message" =>  __("You can not delete category which has associated with post.")
            ], 500);  
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);     
        }
    }
}
