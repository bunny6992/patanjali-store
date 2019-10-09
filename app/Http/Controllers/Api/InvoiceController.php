<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use App\Product;
use App\Invoice;
use App\InvoiceItem;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $billItems = $requestData['billItems'];
        $invoice = new Invoice;
        $invoice->products_count = count($billItems);
        $invoice->total = $requestData['billTotal'];
        $invoice->grand_total = $requestData['grandTotal'];
        $invoice->discount = $requestData['discAmt'];
        $invoice->discount_percent =  $requestData['discPercent'];
        $invoice->type = 'sale';
        $invoice->payment_mode = $requestData['paymentMode'];
        $invoice->save();

        $totalCost = 0;
        foreach ($billItems as $id => $item) {
            $product = Product::find($item['product_id']);
            $batch = Batch::find($item['batch_id']);
            $invoiceItem = new InvoiceItem;
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->product_id = $product->id;
            $invoiceItem->batch_id = $batch->id;
            $invoiceItem->name = $product->name;
            $invoiceItem->tax = $product->tax;
            $invoiceItem->mrp = $batch->mrp;
            $invoiceItem->avg_cost = $batch->avg_cost;
            $invoiceItem->qty = $item['qty'];
            $invoiceItem->row_total = $item['qty'] * $batch->mrp;
            $invoiceItem->type = 'sale';
            $invoiceItem->save();
            $totalCost += $item['qty'] * $batch->avg_cost;
        }
        $invoice->total_cost = $totalCost;
        $invoice->profit = $requestData['grandTotal'] - $totalCost;
        $invoice->save();
        $invoiceItems = [];
        $invoice->invoiceItems;
        $returnData = [
            'invoice' => $invoice,
        ];

        return $returnData;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
