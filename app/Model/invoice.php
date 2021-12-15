<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use \Milon\Barcode\DNS1D;//barcode link:https://github.com/milon/barcode
use \Milon\Barcode\DNS2D;//QR code
use Auth;

class invoice extends Model
{
    public function payment(){
       return $this->belongsTo(payment::class, 'id','invoice_id');
    }
    public function invoiceDetails(){
    	return $this->hasMany(invoiceDetail::class, 'invoice_id', 'id');
    }

    static function generateQRcode($invoice){
        $QRCodeData = "Seller: ".Auth::user()->arabic_shopName."
C.R: ".Auth::user()->arabic_CR_no."
DATE: ".date('d-m-Y',strtotime($invoice->date)).date(' h:i A',strtotime($invoice->created_at))."
VAT AMOUNT: ".number_format($invoice->vat_amount,2)."
TOTAL AMOUNT: ".number_format($invoice->total_amount,2);
        $d = new DNS2D();
         return  '<img src="data:image/png;base64,' . $d->getBarcodePNG($QRCodeData, 'QRCODE',2,2) . '" alt="barcode"   />';
    }

    static function generateBarCode($invoice_no){
      $d = new DNS1D();
         return  '<img src="data:image/png;base64,' . $d->getBarcodePNG($invoice_no, 'C39',1,23) . '" alt="barcode"   />';
    }
}
