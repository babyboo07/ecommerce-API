<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('product')->leftJoin('category', 'product.cateId', '=', 'category.id')->select('product.*', 'category.cateName');
        $product = $product->get();
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->get('productName');
        $product->cateId = $request->get('cateId');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->qty = $request->get('qty');
        $product->material = $request->get('material');
        $product->createdDate = date('Y-m-d');
        $product->updatedDate = date('Y-m-d');
        $product->save();
        $imgs = $request->get('images');
        $productImgs = [];
        if ($imgs !== null && is_array($imgs)) {
            foreach ($imgs as $img) {
                $imgPath = Common::saveImgBase64($img, 'images');
                array_push($productImgs, [
                    'productId' => $product->id,
                    'path' => $imgPath
                ]);
            }
        }

        DB::table('product_images')->insert($productImgs);
        return response()->json($product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getCategoryList()
    {
        return response()->json(DB::table('category')->select('*')->get());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('product as pro')
            ->leftJoin('category', 'pro.cateId', '=', 'category.id')
            ->select('pro.*', 'category.cateName')
            ->where('pro.id', '=', $id)->first();

        if ($product !== null) {
            $product->images = DB::table('product_images')
                ->select('*')
                ->where('productId', '=', $id)->get();
        }

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $ret = ['status' => 'failed', 'message' => ''];
        $product = Product::find($id);

        if (!$product) {
            $ret['message'] = 'Cannot found product with id =' . $id;

            return response()->json($ret);
        }
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->cateId = $request->get('cateName');
        $product->qty = $request->get('qty');
        $product->price = $request->get('price');
        $product->material = $request->get('material');
        $product->updatedDate = date('Y-m-d');
        $product->update();
        $imgs = $request->get('images');
        $productImgs = [];
        if ($imgs !== null && is_array($imgs)) {
            foreach ($imgs as $img) {
                $imgPath = Common::saveImgBase64($img, 'images');
                array_push($productImgs, [
                    'productId' => $product->id,
                    'path' => $imgPath
                ]);
            }
        }
        $ret['status'] = 'success';
        $ret['message'] = 'Updated product successfully';
        $ret['data'] = $product;

        DB::table('product_images')->update($productImgs);
        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('product')->select('*')->where('id', '=', $id)->delete();
        return response()->json($product);
    }
}
