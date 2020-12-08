<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\Itemresource;

class ItemController extends Controller
{
    public function __construct($value='')
    {
        $this->middleware('auth:api')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Item::All();
        // $items=Item::take(4)->get();
        //return Itemresource::collection($items);
        return response()->json([
            'status'=>'OK',
            'totalResult'=>count($items),
            'items'=>Itemresource::collection($items)
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
       // dd($request);
        $request->validate(
            ["name"=>"required",
            "photo"=>"required",
            "price"=>"required",
            "brand"=>"required",
            "subcategory"=>"required"]);
        if($request->file())
        {
            $fileName=time().'_'.$request->photo->getClientOriginalName();
            $filePath=$request->file('photo')->storeAs('ItemImg',$fileName,'public');
            $fullpath='/storage/'.$filePath;
        }
        $item=new Item;

        $codeno=$codeno="CODE_".mt_rand(100000,999999);
        $item->codeno=$codeno;
        $item->name=$request->name;
        $item->photo=$fullpath;
        $item->price=$request->price;
        $item->discount=$request->discount;
        $item->description=$request->description;
        $item->brand_id=$request->brand;
        $item->subcategory_id=$request->subcategory;

        $item->save();

        return new Itemresource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return new Itemresource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate(
            ["name"=>"required",
            "price"=>"required",
            "brand"=>"required",
            "photo"=>"sometimes|required",
            "subcategory"=>"required"]);
        if($request->file())
        {
            $fileName=time().'_'.$request->photo->getClientOriginalName();
            $filePath=$request->file('photo')->storeAs('ItemImg',$fileName,'public');
            $fullpath='/storage/'.$filePath;
        }
        else
        {
            $fullpath=$item->photo;
        }
       
        $codeno=$codeno="CODE_".mt_rand(100000,999999);
        $item->codeno=$codeno;
        $item->name=$request->name;
        $item->photo=$fullpath;
        $item->price=$request->price;
        $item->discount=$request->discount;
        $item->description=$request->description;
        $item->brand_id=$request->brand;
        $item->subcategory_id=$request->subcategory;

        $item->save();

        return new Itemresource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return new Itemresource($item);
    }
}

