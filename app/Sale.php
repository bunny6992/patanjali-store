<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * Get the items for the invoice.
     */
    public function salesItems()
    {
        return $this->hasMany('App\SalesItem', 'sales_id');
    }

    /**
     * Get customer for the invoice.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
