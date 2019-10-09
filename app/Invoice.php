<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * Get the items for the invoice.
     */
    public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem');
    }
}
