<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
    * Get the daily closing that owns the item.
    */
    public function dailyClosing()
    {
        return $this->belongsTo('App\DailyClosing');
    }
}
