<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\product;
use App\Model\supplier;
use App\Model\unit;
use App\Model\category;
use Auth;

class DefaultController extends Controller
{   
	// Category Show Query With Ajax //
    public function getCategory(Request $request){
       $supplier_id = $request->supplier_id;
       $allCategory = product::select('category_id')->with(['category'])->where('supplier_id',$supplier_id)->groupBy('category_id')->get();
       //dd($allCategory->toArray());
       return response()->json($allCategory);
    }
    // Product Show Query With Ajax //
    public function getProduct(Request $request){
        $category_id = $request->category_id;
        $allProduct  = product::where('category_id',$category_id)->get();
        //dd($allProduct->toArray());
        return response()->json($allProduct);
    }
    // Invoice Show Query With Ajax //
    public function getInvoiceCategory(Request $request){
       $category_id = $request->category_id;
       $allProduct  = product::where('category_id',$category_id)->get();
       //dd($allProduct->toArray());
       return response()->json($allProduct);
    }
    // Invoice Quantity show with Ajax //
    public function getProductQuantity(Request $request){
       $product_id = $request->product_id;
       $productQuantity = product::where('id',$product_id)->first()->quantity;
       return response()->json($productQuantity);
    }
    // Product Wais Report PDF //
    public function getProductWaisReport(Request $request){
      $category_id = $request->category_id;
      $product = product::where('category_id', $category_id)->get();
      return response()->json($product);
    }

    //Get Product code
    public function getProductCode(Request $request){
       $supplier_id = $request->supplier_id;
       $allCategory = product::select('id','code','category_id','name')->with(['category'])->where('supplier_id',$supplier_id)->get();
       return response()->json($allCategory);
    }

    //Get Supplier and product details from Product code
    public function getSupplier(Request $request){
       $code = $request->code;
       $allCategory = product::select('id','category_id','name','supplier_id')->with(['category','supplier'])->where('code',$code)->get();
       // dd($allCategory);
       return response()->json($allCategory);
    }
}
