<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Http\Requests\StorecartRequest;
use App\Http\Requests\UpdatecartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cart = new Cart();
        $cart->productId = $request->get('productId');
        $cart->cartQty = $request->get('cartQty');
        $cart->userId = $request->get('userId');
        $cart->save();
        return response()->json($cart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = DB::table('carts')
            ->leftJoin('product', 'carts.productId', '=', 'product.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.id', '=', DB::raw('(Select id from product_images where product_images.productId = carts.productId LIMIT 1)'));
            })
            ->select('product.*', 'carts.cartQty','carts.cartId', 'product_images.path')->distinct('productId')
            ->where('userId', $id)->get();
        return response()->json($cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecartRequest  $request
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecartRequest $request, cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = DB::table('carts')
            ->where('userId', $id)->delete();
        return response()->json($cart);
    }


    public function delete($id){
        $cart = DB::table('carts')->where('cartId',$id)->delete();
        return response()->json($cart);
    }
}
