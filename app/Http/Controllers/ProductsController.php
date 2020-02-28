<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $products = Products::paginate(10);
        } catch (QueryException $exception) {
            return response()->json("server error" . $exception->getMessage(), 500);
        }
        return api_response(true, null, 0, 'success', 'Successfully Retrieved Products', $products);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'quantity' => 'required'
            ]);
        if ($validator->fails()) {
            return api_response(false, $validator->errors(), 1, 'failed',
                "Some entries are missing", null, 500);
        } else {
            $products = new Products();
            $products->name = $request->name;
            $products->description = $request->description;
            $products->quantity = $request->quantity;
            $products->created_at = Carbon::now();
            $products->save();
            return api_response(true, null, 0, 'success',
                "successfully inserted an new product", $products,201);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $product_update = Products::find($id);
            $product_update->name = $request->name;
            $product_update->description = $request->description;
            $product_update->quantity = $request->quantity;
            $product_update->updated_at = Carbon::now();
        } catch (QueryException $exception) {
            return response()->json("server error", 500);
        }
        return api_response(true, null, 0, 'success',
            "successfully update products", $product_update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        try {
            $product_delete = Products::find($id);
            $product_delete->delete();
        } catch (QueryException $exception) {
            return response()->json("server error", 500);
        }
        return api_response(true, null, 0, 'success',
            "successfully update products", $product_delete);
    }
}
