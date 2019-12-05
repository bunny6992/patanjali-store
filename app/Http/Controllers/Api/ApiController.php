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
                    'avg_cost' => $batch->avg_cost,
                    'barcode' => $product->barcode
                ];
                if ($batch->qty > 0) {
                    array_push($return, $returnProduct);
                }                
            }
    	}

        return $return;
    }

    public function getAllItems()
    {
        $products = Product::all();

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
                    'avg_cost' => $batch->avg_cost,
                    'barcode' => $product->barcode
                ];
                //if ($batch->qty > 0) {
                    array_push($return, $returnProduct);
                //}                
            }
        }

        return $return;
    }

    public function updateItems(Request $request)
    {
        $requestData = $request->all();
        foreach ($requestData as $item) {
            // $product = Product::find($item['product_id']);
            $batch = Batch::find($item['batch_id']);
            $batch['avg_cost'] = (($batch['avg_cost'] * $batch['qty']) + ($item['cost_price'] * $item['qty'])) / ($batch['qty'] + $item['qty']);
            $batch->qty += $item['qty'];
            $batch->save();
        }

        return;
    }

    public function saveSalesReturn(Request $request)
    {
        return $request->all();
        $requestData = $request->all();
        $closingModel = DailyClosing::find($requestData['closing_date_id']);
        $closingModel->sales = $requestData['total_sales'];
        $closingModel->returns = $requestData['total_returns'];
        $closingModel->expected_closing_cash = $requestData['expected_closing_cash'];
        $closingModel->save();

        return ;
    }
}
