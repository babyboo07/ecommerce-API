<?php

namespace App\Http\Controllers;

use App\Models\ProductLover;
use App\Http\Requests\StoreProductLoverRequest;
use App\Http\Requests\UpdateProductLoverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductLoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $productLovers = DB::table('product_lovers')
            ->leftJoin('product', 'product_lovers.productId', '=', 'product.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.id', '=', DB::raw('(Select id from product_images where product_images.productId = product_lovers.productId LIMIT 1)'));
            })
            ->select('product.*', 'product_lovers.userId', 'product_lovers.proLoverId', 'product_images.path')->distinct('productId')
            ->where('userId', $id)->get();
        return response()->json($productLovers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $productId = $request->get('productId');
        $userId = $request->get('userId');

        $loverData = array(
            'productId' => $productId,
            'userId' => $userId
        );
        DB::table('product_lovers')->insert($loverData);
        return response()->json($loverData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductLoverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductLoverRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductLover  $productLover
     * @return \Illuminate\Http\Response
     */
    public function show(ProductLover $productLover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductLover  $productLover
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductLover $productLover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductLoverRequest  $request
     * @param  \App\Models\ProductLover  $productLover
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductLoverRequest $request, ProductLover $productLover)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductLover  $productLover
     * @return \Illuminate\Http\Response
     */
    public function destroy($proLoverId , $userId)
    {
        $proLover = DB::table('product_lovers')
        ->where('proLoverId', $proLoverId)
        ->where('userId', $userId)
        ->delete();
        return response()->json($proLover);
    }
}
