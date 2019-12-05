<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyClosing extends Model
{
    /**
     * Get the expenses for the day.
     */
    public function allExpenses()
    {
        return $this->hasMany('App\Expense');
    }
}
