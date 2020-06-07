<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function details() {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}
