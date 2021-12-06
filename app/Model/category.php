<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = [
        'id','name'
    ];
    // public function categories(){
    // 	return $this->hasMany(product::class);
    // }
}
