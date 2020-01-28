<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
    * Get sales.
    */
    public function sales()
    {
        return $this->hasMany('App\Sale');
    }
}
