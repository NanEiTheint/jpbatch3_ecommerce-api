<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            "ls"=>'required',
            "note"=>'required',
            "user_id"=>'required'
        ]);

        $order=new Order;
        $order->voucherno=uniqid();
        $order->orderdate=date('Y-m-d');
        $order->total=$request->total;
        $order->notes=$request->note;
        $order->user_id=$request->user_id;
        $order->save();

      //  dd($request->shopArr);
        foreach ($request->ls as $row) {
           // dd($row['qty']);
            $order->items()->attach($row['id'],['qty'=>$row['qty']]);
        }
       // Alert::success('Completed Order', 'Your Order Successfully!');
       return response()->json([
            'status'=>'Your Order Successful!'
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
