<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = DB::table('category as c')->leftJoin('category as pc', 'c.cateId', '=', 'pc.id')->select('c.*', 'pc.cateName as parentName');
        return response()->json($category->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getParentCate()
    {
        $category = DB::table('category as c')->where('level', '<=', 3)->select('*');
        return response()->json($category->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cate = new Category();
        $cate->cateName = $request->get('cateName');
        $cate->cateId = $request->get('parent');
        $cate->level = $request->get('level');
        // $cateData = array(
        //     'cateName'=>$cateName,
        //     'cateId'=>$cateId,
        //     'level'=> $level
        // );
        // DB::table('category')->insert($cateData);
        $cate->save();
        return response()->json($cate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::table('category as c')
            ->leftJoin('category as pc', 'c.cateId', '=', 'pc.id')
            ->select('c.*', 'pc.cateName as parentName')
            ->where('c.id', '=', $id);
        return response()->json($category->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $ret = ['status' => 'failed', 'message' => ''];
        $category = Category::find($id);

        if (!$category) {
            $ret['message'] = 'Cannot found category with id =' . $id;

            return response()->json($ret);
        }
        $category->cateName = $request->get('cateName');
        $category->level = $request->get('level');
        $category->cateId = $request->get('cateId');

        $category->update();

        $ret['status'] = 'success';
        $ret['message'] = 'Updated category successfully';
        $ret['data'] = $category;

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = DB::table('category as c')
            ->where('c.id', '=', $id)->delete();

            return response()->json($category);
    }
}
