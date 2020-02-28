<?php

namespace App\Http\Controllers;

use App\OrdersDetails;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $order_details = OrdersDetails::with(['product', 'order'])->paginate(10);
        } catch (QueryException $exception) {
            return response()->json("server error" . $exception->getMessage(), 500);
        }
        return api_response(true, null, 0, 'success',
            'Successfully Retrieved order details', $order_details);
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
        $validator = Validator::make($request->all(),
            [
                'order_id' => 'required|exists:orders,id',
                'product_id' => 'required|exists:products,id'
            ]);
        if ($validator->fails()) {
            return api_response(false, $validator->errors(), 1, 'failed',
                "Some entries are missing", null);
        } else {
            try {
                $suppliers = new OrdersDetails();
                $suppliers->order_id = $request->order_id;
                $suppliers->product_id = $request->product_id;
                $suppliers->created_at = Carbon::now();
                $suppliers->save();
            } catch (QueryException $queryException) {
                return response()->json("server error", 500);
            }
            return api_response(true, null, 0, 'success',
                "successfully inserted an new supplier suppliers of products", $suppliers);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order_details = OrdersDetails::with(['product', 'order'])->find($id);
        } catch (QueryException $exception) {
            return response()->json("server error" . $exception->getMessage(), 500);
        }
        return api_response(true, null, 0, 'success',
            'Successfully Retrieved order details', $order_details);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
