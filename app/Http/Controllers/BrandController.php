<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
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
        $brands=Brand::All();
       // return BrandResource::collection($brands);
        return response()->json([
            'status'=>'OK',
            'totalResult'=>count($brands),
            'brands'=>BrandResource::collection($brands)
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
                            "photo"=>"required"
                            ]);
        if($request->file())
        {
            $fileName=time().'_'.$request->photo->getClientOriginalName();
            $filePath=$request->file('photo')->storeAs('brandImg',$fileName,'public');
            $fullpath='/storage/'.$filePath;
        }

        $brand=new Brand;

        $brand->name=$request->name;
        $brand->photo=$fullpath;

        $brand->save();

        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate(
                            ["name"=>"required",
                            ]);

        $image = $request->file('photo');
        if($image==null)
        {
            $fullpath=$brand->photo;
        }
        else
        {
           $basepath ="images/brandimages/";
            $imgName =$image->getClientOriginalName();
            $fullpath=$basepath.$imgName;
            $image->move($basepath, $imgName);

        }
        $brand->name=$request->name;
        $brand->photo=$fullpath;

        $brand->save();
        return new BrandResource($brand); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return new BrandResource($brand);
    }
}
