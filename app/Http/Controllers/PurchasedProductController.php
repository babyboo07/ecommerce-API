<?php

namespace App\Http\Controllers;

use App\Models\purchasedProduct;
use App\Http\Requests\StorepurchasedProductRequest;
use App\Http\Requests\UpdatepurchasedProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $order = DB::table('purchased_products')
        ->where('userId',$userId)
        ->select('*')->get();
        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $productId = $request->get('id');
        $userId =  $request->get('userId');
        $qty = $request->get('cartQty');
        $status = $request->get('status');
        $discount = $request->get('discount');

        $purchased_pr =array(
            'productId' => $productId,
            'userId' => $userId,
            'qty' => $qty,
            'status' => $status,
            'discount' => $discount,
        );

        DB::table('purchased_products')->insert($purchased_pr);
        return response()->json($purchased_pr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepurchasedProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepurchasedProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchasedProduct  $purchasedProduct
     * @return \Illuminate\Http\Response
     */
    public function show(purchasedProduct $purchasedProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchasedProduct  $purchasedProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(purchasedProduct $purchasedProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepurchasedProductRequest  $request
     * @param  \App\Models\purchasedProduct  $purchasedProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepurchasedProductRequest $request, purchasedProduct $purchasedProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchasedProduct  $purchasedProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(purchasedProduct $purchasedProduct)
    {
        //
    }
}
