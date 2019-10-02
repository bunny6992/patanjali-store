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
    	foreach ($products as $id => $product) {
    		$returnProduct['product'] = $product;
    		$returnProduct['batches'] = $product->batches;
    		array_push($return, $returnProduct);
    	}

        return $return;
    }
}
