<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\invoice;
use App\Model\invoiceDetail;
use App\Model\payment;
use App\Model\paymentDetail;
use App\Model\customer;
use App\Model\fakeBills;
use App\Model\fakeBillDetails;
use DB;
use Auth;
use PDF;
class fakeBillsController extends Controller
{
    //---- Invoice View ----//
    public function view(){
        $data['invoices'] = invoice::orderBy('date','desc')->orderBy('id','desc')->where('status', '1')->get();
    	return view('layouts.Backend.invoice.invoiceView', $data);
    }
    //---- Invoice Add ----//
    public function add(){
    	$invoice_no = fakeBills::orderBy('id','desc')->first();
        if($invoice_no == null){
            $firstInvoice = '0';
            $data['invoiceData']  =  $firstInvoice+1;
        } else{
            $invoiceCheck = fakeBills::orderBy('id','desc')->first()->invoice_no;
            $data['invoiceData'] = $invoiceCheck+1;
        }
        return view('layouts.Backend.fakeBills.add', $data);
    }
    //---- Invoice Store With Multipal Table ----//
    public function store(Request $request){
                $invoice = new fakeBills();
                $invoice->invoice_no  = $request->invoice_no;
                $invoice->date        = date('Y-m-d', strtotime($request->date));
                $invoice->vat_percent = $request->vat_percent;
                $invoice->vat_amount  = number_format($request->vat_amount,2, '.', '');
                $invoice->discount_amount = number_format($request->discount_amount,2, '.', '');
                $invoice->total_amount = number_format($request->estimated_amount,2, '.', '');
                $invoice->customer_name    = $request->customer_name;
                $invoice->customer_mobile  = $request->customer_mobile;
                $invoice->comments = $request->description;
                $invoice->status      = '1';
                $invoice->created_by  = Auth::user()->id;
                DB::transaction(function() use($request,$invoice) {
                   if($invoice->save()) {
                    // Invoice Details Insert Start //
                    $category_id = count($request->product_code);
                    for ($i=0; $i < $category_id; $i++) { 
                        $invoiceDetail = new fakeBillDetails();
                        $invoiceDetail->invoice_id  = $invoice->id;
                        // $invoiceDetail->category    = $request->category_name[$i];
                        $invoiceDetail->name     = $request->product_name[$i];
                        $invoiceDetail->code        = $request->product_code[$i];
                        $invoiceDetail->quantity        = $request->selling_qty[$i];
                        $invoiceDetail->unit_price   = number_format($request->unit_price[$i],2, '.', '');
                        $invoiceDetail->selling_price = number_format($request->selling_price[$i],2, '.', '');
                        $invoiceDetail->status        = '0';
                        $invoiceDetail->save();
                    }
                    // Invoice Details Insert End //
                    // Customer Data Insert Start //
                  
                   }
                });
              // Multipale Data Insert End //
        // Redirect //
        return redirect()->route('invoice.pending.list')->with('success', 'Invoice Added Successfully');
    }
    //---- Invoice Pending List ----//
    public function pendingList(){
        $invoicePending = invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('layouts.Backend.invoice.invoicePendingList', compact('invoicePending'));
    }
    //---- Invoice Approvede ----//
    public function approve($id){
      $data['invoice'] = invoice::with('invoiceDetails')->find($id);
      return view('layouts.Backend.invoice.invoiceApproved', $data);
    }
     //---- Invoice ApprovedProcess ----//
    public function approveprocesses(Request $request, $id){
        foreach($request->selling_qty as $key => $val){
            $invoiceDetail = invoiceDetail::where('id', $key)->first();
            $product  = product::where('id', $invoiceDetail->product_id)->first();
            if($product->quantity < $invoiceDetail->selling_qty) {
                return redirect()->back()->with('error', 'Sorry! Check your Product Stock');
            }
        }
        $invoice  = invoice::find($id);
        $invoice->status = '1';
        $invoice->approved_by = Auth::user()->id;
        DB::transaction(function() use($request,$invoice,$id) {
           foreach($request->selling_qty as $key => $val){
              $invoiceDetail = invoiceDetail::where('id', $key)->first();
              $invoiceDetail->status = '1';
              $invoiceDetail->save();
              $product = product::where('id', $invoiceDetail->product_id)->first();
              $product->quantity = ((float)$product->quantity)-((float)$invoiceDetail->selling_qty);
              $product->save(); 
           }
           $invoice->save();
        });
        // Redirect 
        return redirect()->route('invoice.pending.list')->with('success', 'Invoice approved successfullly');
    }
    // Invoice Print List //
    public function printList(){
        $data['invoices'] = fakeBills::orderBy('date','desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('layouts.Backend.fakeBills.billPrintList', $data);
    }
    // Invoice Print //
    function print($id) {
    $data['invoice'] = fakeBills::with('fakeBillsDetails')->find($id);
    // return view('layouts.Backend.pdf.invoicePrint', $data);
    // dd($data['invoice']);
    $pdf = PDF::loadView('layouts.Backend.fakeBills.billPrint', $data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');
   }
   // Invoice Daily //
   public function DailyInvoice(){
    return view('layouts.Backend.invoice.dailyInvoice');
   }
   // Invoice Daily Print //
   public function DailyInvoicePrint(Request $request){
    // validation
    $validation = $request->validate([
        'start_date' => 'required',
        'end_date'   => 'required'
    ]);
     $start_date = date('Y-m-d', strtotime($request->start_date));
     $end_date = date('Y-m-d', strtotime($request->end_date));
     $data['invoices'] = invoice::whereBetween('date', [$start_date, $end_date])->where('status', '1')->get();
     $data['stime'] = date('Y-m-d', strtotime($request->start_date));
     $data['etime'] = date('Y-m-d', strtotime($request->end_date));
     $pdf = PDF::loadView('layouts.Backend.pdf.invoiceDaily', $data);
     $pdf->SetProtection(['copy', 'print'], '', 'pass');
     return $pdf->stream('document.pdf');
   }
    //---- Invoice Delete ----//
    public function delete($id){
      $invoiceDelete = invoice::find($id);
      $invoiceDelete->delete();
      invoiceDetail::where('invoice_id', $invoiceDelete->id)->delete();
      payment::where('invoice_id', $invoiceDelete->id)->delete();
      paymentDetail::where('invoice_id', $invoiceDelete->id)->delete();
      return redirect()->route('invoice.pending.list')->with('success', 'Invoice Deleted successfully');
    }
}    
