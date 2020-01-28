<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    /**
    * Get the invoice that owns the item.
    */
    public function invoice()
    {
        return $this->belongsTo('App\Sale');
    }
}
