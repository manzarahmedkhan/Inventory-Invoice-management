<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\product;
use App\Model\supplier;
use App\Model\unit;
use App\Model\category;
use Auth;

class productController extends Controller
{
    //---- Products View ----//
    public function view(){
    	$products = product::all();
    	return view('layouts.Backend.products.productsView', compact('products'));
    }
    //---- Products Add ----//
    public function add(){
        $data['suppliers']  = supplier::select('id','name')->get();
        $data['units']      = unit::select('id','name')->get();
        $data['categories'] = category::select('id','name')->get();
<<<<<<< HEAD
=======
        $data['lastCode'] = product::latest()->pluck('code')->first() + 1;
>>>>>>> ad7fa2c05c2fd6da28f37e5f77ec3f9e878c8405
    	return view('layouts.Backend.products.productsAdd', $data);
    }
    //---- Products Store ----//
    public function store(Request $request){
         // validation
        $validation = $request->validate([
<<<<<<< HEAD
        	'supplier_id' => 'required',
        	'unit_id'     => 'required',
        	'category_id' => 'required',
        	'name'        => 'required'
=======
        	'supplier_id'  => 'required',
        	'unit_id'      => 'required',
        	'category_id'  => 'required',
            'code'         => 'required',
        	'product_name' => 'required'
>>>>>>> ad7fa2c05c2fd6da28f37e5f77ec3f9e878c8405
        ]);
        // Insert Data
        $products = new product;
        $products->supplier_id = $request->supplier_id;
        $products->unit_id     = $request->unit_id;
        $products->category_id = $request->category_id;
<<<<<<< HEAD
        $products->name        = $request->name;
=======
        $products->code        = $request->code;
        $products->name        = $request->product_name;
>>>>>>> ad7fa2c05c2fd6da28f37e5f77ec3f9e878c8405
        $products->created_by  = Auth::user()->id;
        $products->save();
      // Redirect 
      return redirect()->route('products.view')->with('success', 'product Added Successfully');
    }
    //---- Products Edit ----//
    public function edit($id){
    	$data['suppliers']  = supplier::select('id','name')->get();
        $data['units']      = unit::select('id','name')->get();
        $data['categories'] = category::select('id','name')->get();
        $data['products']   = product::find($id);
    	return view('layouts.Backend.products.productEdit', $data);
    }
    //---- Products Update ----//
    public function update($id, Request $request){
    	// Update
        $productUpdate = product::find($id);
        $productUpdate->supplier_id = $request->supplier_id;
        $productUpdate->unit_id     = $request->unit_id;
        $productUpdate->category_id = $request->category_id;
<<<<<<< HEAD
        $productUpdate->name        = $request->name;
=======
        $productUpdate->code        = $request->code;
        $productUpdate->name        = $request->product_name;
>>>>>>> ad7fa2c05c2fd6da28f37e5f77ec3f9e878c8405
        $productUpdate->updated_by  = Auth::user()->id;
        $productUpdate->save();
        // Redirect 
      return redirect()->route('products.view')->with('success', 'Products Updated Successfully');
    }
     //---- Products Delete ----//
    public function delete($id){
    	// Delete
        $productDelete = product::find($id);
        $productDelete->delete();
        // Redirect 
      return redirect()->route('products.view')->with('error', 'products Deleted Successfully');
    }
}
