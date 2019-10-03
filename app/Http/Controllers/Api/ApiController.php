<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Batch;

class ApiController extends Controller
{
    public function getItems($query)
    {
    	$products = Product::where('barcode', $query)->get();
// return count($products);
    	if (count($products) == 0) {
    		$products = Product::where('name', 'LIKE', "%{$query}%")->get();
    	}

    	if (count($products) == 0) {
    		return "No Products Found.";
    	}

    	$return = [];
        $sortedProducts = $products->sortBy('name');
    	foreach ($sortedProducts as $id => $product) {
            foreach ($product->batches as $batchId => $batch) {
                $returnProduct = [
                    'product_id' => $product->id,
                    'batch_id' => $batch->id,
                    'name' => $product->name,
                    'tax' => $product->tax,
                    'mrp' => $batch->mrp,
                    'qty' => $batch->qty,
                    'avg_cost' => $batch->avg_cost
                ];
            }

    		array_push($return, $returnProduct);
    	}

        return $return;
    }
}
