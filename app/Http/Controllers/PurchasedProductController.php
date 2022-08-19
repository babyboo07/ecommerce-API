<?php

namespace App\Http\Controllers;

use App\Models\purchasedProduct;
use App\Http\Requests\StorepurchasedProductRequest;
use App\Http\Requests\UpdatepurchasedProductRequest;
use Illuminate\Foundation\Console\UpCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PurchasedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId, $status)
    {
        $order = DB::table('purchased_products as p')
            ->leftJoin('product', 'p.productId', '=', 'product.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.id', '=', DB::raw('(Select id from product_images where product_images.productId = p.productId LIMIT 1)'));
            })
            ->select('product.*', 'p', 'product_images.path')->distinct('productId')
            ->where('userId', $userId)->where('p.status', $status)
            ->select('*')->get();
        return response()->json($order);
    }

    public function getall($id)
    {
        $order = DB::table('purchased_products as p')
            ->leftJoin('product', 'p.productId', '=', 'product.id')
            //->leftJoin('product_images', 'p.productId', '=', 'product_images.productId')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.id', '=', DB::raw('(Select id from product_images where product_images.productId = p.productId LIMIT 1)'));
            })
            ->select('product.*', 'p.*', 'product_images.path')->distinct('productId')
            ->where('userId', $id)->get();
        return response()->json($order);
    }

    public function getorder($status)
    {
        $order = DB::table('purchased_products as p')
            ->leftJoin('product', 'p.productId', '=', 'product.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.id', '=', DB::raw('(Select id from product_images where product_images.productId = p.productId LIMIT 1)'));
            })
            ->leftJoin('address', function ($join) {
                $join->on('address.id', '=', DB::raw('(Select id from address where address.userId = p.userId LIMIT 1)'));
            })
            ->leftJoin('category', 'product.cateId', '=', 'category.id')
            ->where('p.status', $status)
            ->select('product.*', 'p.*', 'product_images.path')->distinct('productId')
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

        $purchased_pr = array(
            'productId' => $productId,
            'userId' => $userId,
            'orderQty' => $qty,
            'status' => $status,
            'orderDiscount' => $discount,
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
    public function show($orderId)
    {
        $order = DB::table('purchased_products as p')
            ->leftJoin('product', 'p.productId', '=', 'product.id')
            ->leftJoin('address', function ($join) {
                $join->on('address.id', '=', DB::raw('(Select id from address where address.userId = p.userId LIMIT 1)'));
            })
            ->leftJoin('category', 'product.cateId', '=', 'category.id')
            ->where('orderId', $orderId)->get();
        return response()->json($order);
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

    public function cancel($orderId , Request $request){
        $ret = ['status' => 'failed', 'message' => ''];
        $order = purchasedProduct::where('orderId', '=', $orderId);

        if (!$order) {
            $ret['message'] = 'Cannot found order with id =' . $orderId;

            return response()->json($ret);
        }
        
        $order->update(['status' => $request->get('status')]);

        $ret['status'] = 'success';
        $ret['message'] = 'Updated order successfully';
        $ret['data'] = $order;

        return response()->json($ret);
    }
}
