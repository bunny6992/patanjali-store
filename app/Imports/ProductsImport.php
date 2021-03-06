<?php

namespace App\Imports;

use App\Product;
use App\Batch;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (strtolower($row[0]) == 'product name' || empty($row[0])) {
            return;
        }

        $product = Product::where('barcode', (string)$row[3])->first();
        if (empty($product)) {
            $product = new Product;
            $product->name = $row[0];
            $product->barcode = (string)$row[3];
            $product->sap = intval($row[1]);
            $product->hsn = intval($row[2]);
            $product->tax = intval($row[4]);
            $product->save();
        }
        $batchRate = $row[5];
        $batchMrp = $row[6];
        $batchQty = $row[7];

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
