<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\product;
use App\Model\supplier;
use App\Model\unit;
use App\Model\category;
use Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Validator;

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
        $data['lastCode'] = product::latest()->pluck('code')->first() + 1;
    	return view('layouts.Backend.products.productsAdd', $data);
    }
    //---- Products Store ----//
    public function store(Request $request){
         // validation
        $validation = $request->validate([
        	'supplier_id'  => 'required',
        	'unit_id'      => 'required',
        	'category_id'  => 'required',
            'code'         => 'required',
        	'product_name' => 'required'
        ]);
        // Insert Data
        $products = new product;
        $products->supplier_id = $request->supplier_id;
        $products->unit_id     = $request->unit_id;
        $products->category_id = $request->category_id;
        $products->code        = $request->code;
        $products->name        = $request->product_name;
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
        $productUpdate->code        = $request->code;
        $productUpdate->name        = $request->product_name;
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

    public function checkCodeExists(Request $request){
        $checkCodeExists = product::where('code',$request->code)->where('supplier_id',$request->supplier_id)->first();
        if(!$checkCodeExists){
            return false;
        }
        return true;
    }

    public function uploadExcelView(){
        return view('layouts.Backend.products.productsUploadExcel');
    }

    public function uploadExcel(Request $request){
        $filepath  = $request->attachment;
        $readexcel = $this->Readexcel($filepath);
        if (empty($readexcel['error'] == 0)) {

            $error['error_message']   = 'File is  unreadable.';
            return $error;
        } 

        $sheet_data = array_filter($readexcel['sheet_data']);
        unset($sheet_data[1],$sheet_data[2]);
dd($sheet_data);
        foreach ($sheet_data as $sheet_data_loop) {
            $validator = Validator::make($sheet_data_loop, [
                'A'  => 'required',
                'B'  => 'required',
                'C'  => 'required',
                'D'  => 'required',
                'E'  => 'required'
                'F'  => 'required'
                'G'  => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $supplier = supplier::updateOrCreate(['name' => $sheet_data_loop['F']],[
                    'name'   => $sheet_data_loop['F'],
                    'mobile' => str_replace(' ', '', $sheet_data_loop['G']),
                    'created_by' => Auth::id(),
            ]);
            $unit = unit::updateOrCreate(['name' => $sheet_data_loop['C']],[
                    'name' => $sheet_data_loop['F'],
                    'created_by' => Auth::id(),
                    'update_by' => Auth::id(),
            ]);

            $category = category::updateOrCreate(['name' => $sheet_data_loop['D']],[
                    'name' => $sheet_data_loop['G'],
                    'created_by' => Auth::id(),
                    'update_by' => Auth::id(),
            ]);

            $unit = product::updateOrCreate(['code' => $sheet_data_loop['A']],[
                    'supplier_id' => $supplier->id,
                    'unit_id' => $unit->id,
                    'category_id' => $unit->id,
                    'code' => $sheet_data_loop['A'],
                    'created_by' => Auth::id(),
                    'update_by' => Auth::id(),
            ]);
            dd($supplier->id);
            // $error['storage_folder_Path'] = $storage_folder_Path;
            $error['error_message'] = 'File Uploaded Successfully';
            return $error;
        }
    }

     public function Readexcel($filepath)
    {

        $error = array();
        if (!empty($filepath)) {

            $excelarray = array();
            $obj_PhpOffice = IOFactory::load($filepath);
            $objWorksheet = $obj_PhpOffice->setActiveSheetIndex(0);
            $sheet_data = $objWorksheet->rangeToArray('A1:H5000', null, true, true, true);
            $sheet_data = array_filter($sheet_data);
            foreach ($sheet_data as $each_arr_k => $each_arr_v) {
                $flag = 1;
                foreach ($each_arr_v as $val) {
                    if (!empty($val)) {
                        $flag++;
                    }
                }
                if ($flag == 1) {
                    unset($sheet_data[$each_arr_k]);
                }
            }

            $obj_PhpOffice = new Spreadsheet();
            $obj_PhpOffice->setActiveSheetIndex(0);
            $obj_PhpOffice->getDefaultStyle()
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


            $style_array = array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('argb' => '32cd32')
                )
            );
            $style_array_error = array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('argb' => 'ffff00')
                )
            );

            $error_column_style_array = array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'color' => array('argb' => 'ff0000')
                )
            );
            $excelarray['sheet_data'] = $sheet_data;
            $excelarray['style_array'] = $style_array;
            $excelarray['style_array_error'] = $style_array_error;
            $excelarray['error_column_style_array'] = $error_column_style_array;
            $excelarray['obj_PhpOffice'] = $obj_PhpOffice;
            $excelarray['error'] = 0;
            // dd($excelarray);
            return $excelarray;
        }
    }
}
