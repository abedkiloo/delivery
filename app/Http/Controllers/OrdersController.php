<?php

namespace App\Http\Controllers;

use App\Orders;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = Orders::paginate(10);
        } catch (QueryException $exception) {
            return response()->json("server error" . $exception->getMessage(), 500);
        }
        return api_response(true, null, 0, 'success', 'Successfully Retrieved orders', $orders);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $data = request()->validate([
//            'order_number' => 'required',
//        ]);
//        Orders::create($data);
        $validator = Validator::make($request->all(),
            [
                'order_number' => 'required',
            ]);
//
//        if ($validator->fails()) {
//            return api_response(false, $validator->errors(), 1, 'failed',
//                "Some entries are missing", null);
//        } else {
//            $orders = new Orders();
//            $orders->order_number = $request->order_number;
//            $orders->created_at = Carbon::now();
//            $orders->save();
//            return api_response(true, null, 0, 'success',
//                "successfully inserted an new order", $orders);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $order_update = Orders::find($id);
            $order_update->name = $request->name;
            $order_update->description = $request->description;
            $order_update->quantity = $request->quantity;
            $order_update->updated_at = Carbon::now();
        } catch (QueryException $exception) {
            return response()->json("server error", 500);
        }
        return api_response(true, null, 0, 'success',
            "successfully update orders", $order_update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order_delete = Orders::find($id);
            $order_delete->delete();
        } catch (QueryException $exception) {
            return response()->json("server error", 500);
        }
        return api_response(true, null, 0, 'success',
            "successfully update orders", $order_delete);
    }
}
