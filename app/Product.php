<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['name', 'hsn', 'sap', 'barcode', 'tax'];
    /**
     * Get the batches for the blog post.
     */
    public function batches()
    {
        return $this->hasMany('App\Batch');
    }
}
