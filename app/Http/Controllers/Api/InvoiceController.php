<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use App\Product;
use App\Invoice;
use App\InvoiceItem;
use App\DailyClosing;
use App\Expense;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnData = Invoice::orderBy('id','DESC')->get();
        return $returnData;
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
        $invoice->type = $requestData['type'];
        $invoice->payment_mode = $requestData['paymentMode'];
        $invoice->recharge_amount = $requestData['rechargeAmt'];
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

            if ($requestData['type'] == 'Return') {
                $batch->qty += $item['qty'];
            } else {
                if ($batch->qty > $item['qty']) {
                    $batch->qty -= $item['qty'];
                } else {
                    $batch->qty = 0;
                }
            }
            $batch->save();
            
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
        $returnData = Invoice::find($id);
        foreach ($returnData->invoiceItems as $key => $value) {
            $value->return_qty = 0;
        }
        
        return $returnData;
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

    public function printInvoice($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        try {
            $total = 0;
            $totalQty = 0;
            // Enter the share name for your USB printer here
            //$connector = "POS-58";
            $connector = new WindowsPrintConnector("POS-58-Series");
            //$connector = new WindowsPrintConnector("103.252.169.199");
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            /* Name of shop */
            // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->setJustification(Printer::JUSTIFY_CENTER);

            $printer->selectPrintMode(Printer::MODE_FONT_A);
            $printer->setFont(Printer::FONT_A);
            $printer->text("--------------------------------\n");

            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setFont(Printer::FONT_A);
            $printer->text("Sai Ram Store\n");
            $printer->text("Patanjali Aarogya Kendra\n");
            
            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setFont(Printer::FONT_C);
            $printer->text("EWS/101, Housing Board Colony, Bhim Chowk\n");

            $printer->selectPrintMode(Printer::MODE_FONT_A);
            $printer->setFont(Printer::FONT_C);
            $printer->text("--------------------------------\n");

            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setFont(Printer::FONT_C);

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printId = $invoice->id;

            for ($loop = count($invoice->id); $loop < 15; $loop++) { 
                $printId = $printId." ";
            }

            $printer->text("Inv. No: ".$printId);

            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setFont(Printer::FONT_C);
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            date_default_timezone_set("Asia/Calcutta");
            $printer->text("Date: ".date("d/m/Y") ."\n\n");

            $printer->selectPrintMode(Printer::MODE_UNDERLINE);
            $printer->setFont(Printer::FONT_C);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Item         Price  Qty  Total \n\n");

            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setJustification(Printer::JUSTIFY_LEFT);

            foreach ($invoice->invoiceItems as $item) {
                $printName = [];
                $printIndex = 0;
                $words = explode(' ', $item['name']);
                foreach ($words as $index => $word) {
                    if (strlen($word) > 14) {
                        $word = substr($word, 0, 12);
                        $word .= "..";
                    }

                    if (!array_key_exists($printIndex, $printName)) {
                        $printName[$printIndex] = "";
                    }

                    if (strlen($printName[$printIndex]) + strlen($word) > 15) {
                        $printIndex++;
                    }
                    if (!array_key_exists($printIndex, $printName)) {
                        $printName[$printIndex] = "";
                    }
                    
                    $printName[$printIndex] .= $word . " ";
                    echo strlen($word . " ");
                }
                
                foreach ($printName as $index => $name) {
                    if ($index > 3) {
                        break;
                    }

                    if ($index == 0) {
                        $name .= "               ";
                        $name = substr($name, 0, 15);
                        $price = $item['mrp'] . "               ";
                        $price = substr($price, 0, 8);
                        $quantity = $item['qty'] . "               ";
                        $quantity = substr($quantity, 0, 4);
                        $itemTotal = $item['qty'] * $item['mrp'] . "               ";
                        $itemTotal = substr($itemTotal, 0, 9);

                        $printer->text($name."  ".$price."  ".$quantity."  ".$itemTotal."\n");
                    } else {
                        $printer->text($name."\n");
                    }
                }
                $printer->text("------------------------------------------\n");
                $total += $item['qty'] * $item['mrp'];
            }
           
            $printer->setFont(Printer::FONT_A);
            if ($invoice['discount'] > 0) {
                // $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text("Subtotal:          Rs.". $total ."/-\n");
                $printer->text("Discount:          Rs.". $invoice['discount'] ."/-\n");
            }
            $total -= $invoice['discount'];
            $printer->text("Grand Total:       Rs.". $total ."/-\n");
            $printer->text("--------------------------------\n");

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setFont(Printer::FONT_C);
            $printer->text("Nice to see you. \nDo visit again.\n");

            $printer->feed();
            /* Title of receipt */
            $printer->setEmphasis(true);

            $printer->feed(2);

            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();
            /* Close printer */
            $printer->close();
            return 'true';
        } catch (Exception $e) {
            // $message = "Couldn't print to this printer: " . $e->getMessage() . "\n";
            return 'false';
        }
    }

    public function printClosing($closingDayId)
    {
        $closingDay = DailyClosing::find($closingDayId);
        try {
            $total = 0;
            $totalQty = 0;
            // Enter the share name for your USB printer here
            //$connector = "POS-58";
            $connector = new WindowsPrintConnector("POS-58-Series");
            //$connector = new WindowsPrintConnector("103.252.169.199");
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            /* Name of shop */
            // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->setJustification(Printer::JUSTIFY_CENTER);

            $printer->selectPrintMode(Printer::MODE_FONT_A);
            $printer->setFont(Printer::FONT_A);

            $printer->text("--------------------------------\n");
            $printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setFont(Printer::FONT_A);
            $printer->text("Date:  ".$closingDay['date']."\n");
            $printer->text("Total Sales:  ".$closingDay['sales']."\n");
            $printer->text("Total Returns:  ".$closingDay['returns']."\n");
            $printer->text("Total Expenses:  ".$closingDay['expenses']."\n");
            $printer->text("Expected Closing Cash:  ".$closingDay['expected_closing_cash']."\n"); 
            $printer->text("Closing Cash:  ".$closingDay['closing_cash']."\n");     
            $printer->text("--------------------------------\n");

            $printer->feed();
            /* Title of receipt */
            $printer->setEmphasis(true);

            $printer->feed(2);

            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();
            /* Close printer */
            $printer->close();
            return 'true';
        } catch (Exception $e) {
            // $message = "Couldn't print to this printer: " . $e->getMessage() . "\n";
            return 'false';
        }
    }
}
