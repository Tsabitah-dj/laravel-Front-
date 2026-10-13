<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';
    protected $fillable = ['gambar_produk','nama_produk','deskripsi_produk','harga_produk',];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
