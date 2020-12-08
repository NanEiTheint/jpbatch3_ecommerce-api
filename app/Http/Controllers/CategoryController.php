<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
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
        $categories=Category::All();
        //return CategoryResource::collection($categories);
        return response()->json([
            'status'=>'OK',
            'totalResult'=>count($categories),
            'categories'=>Categoryresource::collection($categories)
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
        $request->validate([
            "name"=>"required",
            "photo"=>"required"]);

        if($request->file())
        {
            $fileName=time().'_'.$request->photo->getClientOriginalName();
            $filePath=$request->file('photo')->storeAs('CategoryImg',$fileName,'public');
            $fullpath='/storage/'.$filePath;
        }

        $category=new Category;
        $category->name=$request->name;
        $category->photo=$fullpath;
        $category->save();

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name"=>"required"]);

        $imagefile=$request->file("photo");
        if($imagefile==null)
        {
            $fullpath=$category->photo;
        }
        else
        {
            $basepath="images/categoryimages/";
            $imgName=$imagefile->getClientOriginalName();
            $fullpath=$basepath.$imgName;
            $imagefile->move($basepath,$imgName);
        }

        $category->name=$request->name;
        $category->photo=$fullpath;
        $category->save();
        

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
