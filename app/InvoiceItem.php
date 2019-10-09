<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /**
    * Get the invoice that owns the item.
    */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
