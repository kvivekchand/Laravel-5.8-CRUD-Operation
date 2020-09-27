<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('user_id', '=', Auth::id())
                    ->latest()
                    ->with(['category' => function($thumb){
                        $thumb->select('id','category_name');
                    }])
                    ->with(['subcategory' => function($thumb){
                        $thumb->select('id','sub_category_name');
                    }])
                    ->paginate(5);
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =Category::select('id', 'category_name')->get();
        $subcategories = '';
        if(!empty($_GET['category_id'])){
            $subcategories =SubCategory::where('category_id', '=', $_GET['category_id'])->select('id', 'sub_category_name')->get();
            return $subcategories;
        }
        return view('products.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg'
        ]);
  
        $product = Product::create($request->all());
        
        if ($request->file('photo')) {
            $request->file('photo')->store('public/products');
        }

        $product->photo = $request->photo->hashName();
        $product->save();
   
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $category =Category::where('id', '=', $product->category_id)->select('id', 'category_name')->first();
        $subCategory =SubCategory::where('id', '=', $product->sub_category_id)->select('id', 'sub_category_name')->first();
        return view('products.show',compact('product', 'category', 'subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories =Category::select('id', 'category_name')->get();
        $subcategories =SubCategory::select('id', 'sub_category_name')->get();
        if(!empty($_GET['category_id'])){
            $subcategories =SubCategory::where('category_id', '=', $_GET['category_id'])->select('id', 'sub_category_name')->get();
            return $subcategories;
        }
        return view('products.edit',compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg'
        ]);
  
        $product->update($request->all());

        if ($request->file('photo')) {
            $request->file('photo')->store('public/products');
        }

        $product->photo = $request->photo->hashName();
        $product->save();
  
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
  
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}
