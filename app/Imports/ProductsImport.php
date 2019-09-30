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

        $product = Product::where('barccode', (string)$row[3])->first();
        if (empty($product)) {
            $product = new Product;
            $product->name = $row[0];
            $product->barcode = (string)$row[3];
            $product->sap = intval($row[1]);
            $product->hsn = intval($row[2]);
            $product->tax = intval($row[4]);
            $product->save();
        }

        $batch = new Batch;
        $batch->product_id = $product->id;
        $batch->avg_cost = $row[5];
        $batch->mrp = $row[6];
        $batch->qty = $row[7];
        $batch->save();

        return;
    }
}
