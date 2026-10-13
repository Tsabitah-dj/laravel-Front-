<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $fillable = [ 'nama_pelanggan','product_id','qty','total_harga','catatan','status',];
     
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
