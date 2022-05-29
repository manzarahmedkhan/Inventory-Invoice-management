<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class fakeBills extends Model
{
	protected $table = 'fake_bills';
	public function fakeBillsDetails(){
    	return $this->hasMany(fakeBillDetails::class, 'invoice_id', 'id');
    }
    public function payment(){
       return $this->belongsTo(fakeBillDetails::class, 'id','invoice_id');
    }

    public function customer(){
       return $this->hasOne(customer::class, 'id','customer_id');
    }
}
