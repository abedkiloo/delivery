<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $suppliers = Suppliers::paginate(10);
        } catch (QueryException $exception) {
            return response()->json("server error" . $exception->getMessage(), 500);
        }
        return api_response(true, null, 0, 'success', 'Successfully Retrieved suppliers', $suppliers);

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
                'name' => 'required',

            ]);
        if ($validator->fails()) {
            return api_response(false, $validator->errors(), 1, 'failed',
                "Some entries are missing", null);
        } else {
            $suppliers = new Suppliers();
            $suppliers->name = $request->name;
            $suppliers->created_at = Carbon::now();
            $suppliers->save();
            return api_response(true, null, 0, 'success',
                "successfully inserted an new supplier", $suppliers);
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
