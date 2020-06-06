<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    public function products() {
        return $this->hasMany(Products::class, 'id', 'product_id');
    }
}
