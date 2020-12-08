<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryResource;


class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct($value='')
    {
        $this->middleware('auth:api')->only('store');
    }
    public function index()
    {
        $subcategories=Subcategory::All();
        //return SubcategoryResource::collection($subcategories);
        return response()->json([
            'status'=>'OK',
            'totalResult'=>count($subcategories),
            'subcategories'=>SubcategoryResource::collection($subcategories)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ["name"=>"required",
            "category"=>"required"],
            
            ["category.required"=>"Category name is required."]
        );
       // dd($request->category);

        $subcategory=new Subcategory;
        $subcategory->name=$request->name;
        $subcategory->category_id=$request->category;
        $subcategory->save();

        return new SubcategoryResource($subcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return new SubcategoryResource($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate(
            ["name"=>"required",
            "category"=>"required"],
            
            ["category.required"=>"Category name is required."]
        );
       // dd($request->category);
        
        $subcategory->name=$request->name;
        $subcategory->category_id=$request->category;
        $subcategory->save();

        return new SubcategoryResource($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return new SubcategoryResource($subcategory);
    }
}
