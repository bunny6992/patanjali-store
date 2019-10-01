<?php

namespace App\Imports;

use App\Product;
use App\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsUpdate implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //throw new ModelNotFoundException('User not found by ID');
        if (strtolower($row[0]) == 'product name' || empty($row[0])) {
            return;
        }

        $product = Product::where('barcode', (string)$row[1])->first();
        if (empty($product)) {
            throw new ModelNotFoundException('Dude, '. $row[0] .' is not there in our system.');
        }

        $batchRate = $row[2];
        $batchMrp = $row[3];
        $batchQty = $row[4];

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

        return;
    }
}