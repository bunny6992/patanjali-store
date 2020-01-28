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
                    'name' => $product->style_name,
                    'for' => $product->for,
                    'size' => $product->size,
                    'color' => $product->color,
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

    public function bulkAddProducts(Request $request)
    {
        $requestData = $request->all();
        foreach ($requestData as $newProduct) {

            $product = Product::where('barcode', $newProduct['Barcode'])->first();
            if (!empty($product)) {
                continue;
            }
            $product = new Product;
            $product->style_name = (string)$newProduct['Style Name'];
            $product->barcode = (string)$newProduct['Barcode'];
            $product->for = (string)$newProduct['FOR'];
            $product->size = (string)$newProduct['Size'];
            $product->color = (string)$newProduct['Color'];
            $product->save();
            $batchRate = $newProduct['Cost Price'];
            $batchMrp = $newProduct['MRP'];
            $batchQty = $newProduct['QTY'];

            $batches = Batch::where('product_id', $product->id)->get();
            $batchFlag = false;

            if (!empty($batches)) {
                foreach ($batches as $BatchId => $batch) {
                    if ($batchMrp == $batch['mrp']) {
                        $batch['avg_cost'] = (($batch['avg_cost'] * $batch['qty']) + ($batchRate * $batchQty)) / ($batch['qty'] + $batchQty);
                        $batch['qty'] += intval($batchQty);
                        $batchFlag = true;
                        $batch->save();
                        break;
                    }
                }
            }

            if(!$batchFlag) {
                $batch = new Batch;
                $batch->product_id = $product->id;
                $batch->avg_cost = $batchRate;
                $batch->mrp = $batchMrp;
                $batch->qty = $batchQty;
                $batch->save();
            }
        }
    }

    public function bulkUpdateProducts(Request $request)
    {
        return $request->all();
    }
}
