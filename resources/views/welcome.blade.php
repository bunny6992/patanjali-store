<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>M I S F I T</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Amatic+SC" /> -->
        <link href="css/app.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.css') }}">
        <style type="text/css">
/*@font-face {
    font-family: 'Amatic SC';
    src: url('{{ public_path('fonts/misfitBold.tff') }}');
}*/
* {
  font-family: 'Amatic SC';
  font-size: 32px;
  font-weight: bold;
}
/*@font-face {
    font-family: "Amatic SC";
    src: url('{{ public_path('fonts/misfit.tff') }}');
}*/


        </style>
        <style type="text/css">
.test {
    font-weight: bold;
    font-size: 32px;
}


            input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
.VuePagination {
  text-align: center;
}

.vue-title {
  text-align: center;
  margin-bottom: 10px;
}

.vue-pagination-ad {
  text-align: center;
}
#test {
  width: 95%;
  margin: 0 auto;
}

/* Switcher Css*/
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 20px;
  top: 5px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 40%;
  height: 95%;
  position: inherit;
  top: 0px;
}

/*End of Switcher Css*/
        </style>
    </head>
    <body style="overflow-x: hidden;">
        <div id="app">
            <router-component inline-template>
                <div>
                    <div style="width: 100%; background: #fdd325; height: 60px; color: white;">
                        <!-- @if (Route::has('login'))   
                        <div class="top-right links">
                            @auth
                                <a href="{{ url('/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                            @endauth
                        </div>
                        @endif    -->
                        <div class="dropdown" style="margin-left: 2%; margin-top: 0.4%;">
                            <a>Sales</a>
                            <div class="dropdown-content">
                                <a href="#" @click="getInvoicer()">Sale</a>
                                <a href="#" @click="getInvoices('false')">Invoices</a>
                                <a href="#" @click="getInvoices('true')">Expenses and Closing</a>
                            </div>
                        </div>
                        <div class="dropdown" style="margin-left: 2%;">
                            <a>Inventory</a>
                            <div class="dropdown-content">
                                <a href="#" @click="route = 'stockList'">Stock List</a>
                                <a href="#" @click="route = 'updateStock'">Update Stock</a>
                                <a href="#" @click="route = 'addNewProducts'">Add New Products</a>
                            </div>
                        </div>
                        <!-- <div>
                            <img style="position: relative; bottom: 89px; margin-left: 40%; height: 170px; width: 255px;" src="images/logo-name-black.svg" alt="Logo"><br>
                        </div>    -->       
                    </div>

                    <div class="content" style="margin-top: 0.7%;">
                        <div v-if="route === 'sale' || route === 'invoices' || route == 'expenses'">
                            
                            <invoicer ref="invoicer" inline-template>

                                <div style="width: 80%; margin: 0 auto;" v-if="$parent.route === 'invoices'">
                                    <span style="font-size: 65px;">Invoices</span>
                                    <!-- <div id="test" class="row" style=""> -->
                                        <!-- <div class="col-md-12"> -->
                                            <v-client-table :data="invoices" :columns="invoice_columns" :options="table_options">
                                                <a slot="view" slot-scope="props" class="fa fa-expand-arrows-alt" @click="editInvoice(props.row.id)" style="cursor: pointer;"></a>
                                                <a slot="print" slot-scope="props" class="fa fa-print" @click="printBill(props.row.id)" style="cursor: pointer;"></a>
                                            </v-client-table>
                                            <modal name="showInvoice" height="auto" width="75%" style="overflow-y: auto; font-size: 32px; font-weight: bold; text-align: center;">
                                                
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">Sr No</th>
                                                            <th scope="col">Style Name</th>
                                                            <th scope="col">Color</th>
                                                            <th scope="col">Size</th>
                                                            <th scope="col">How Much</th>
                                                            <th scope="col">How Many</th>
                                                            <th scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in billItems">
                                                            <th scope="row">@{{ index + 1 }}</th>
                                                            <td>@{{ item.name }}</td>
                                                            <td>@{{ item.color }}</td>
                                                            <td>@{{ item.size }}</td>
                                                            <td>@{{ item.mrp }}</td>
                                                            <td>@{{ item.qty }}</td>
                                                            <td>@{{ item.mrp * item.qty }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                <span v-if="discPercent">
                                                                    <span>Disc % :&nbsp;&nbsp;</span>
                                                                    <span>@{{ discPercent }}</span>
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span v-if="discAmt">
                                                                    <span>Disc Amt:&nbsp;&nbsp;</span>
                                                                    <span>@{{ discAmt }}</span>
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span>
                                                                    <span>Payment Mode:&nbsp;&nbsp;</span>
                                                                    <span>@{{ paymentMode }}</span>
                                                                </span>
                                                            </th>
                                                            <th scope="col" v-if="paymentMode == 'Patanjali Card'">
                                                                <span>
                                                                    <span>Recharge Amt:&nbsp;&nbsp;</span>
                                                                    <span>@{{ rechargeAmt }}</span>
                                                                </span>
                                                            </th>
                                                            <th scope="col" style="width: 30%;">
                                                                <span>
                                                                    <span>Grand Total:&nbsp;&nbsp;</span>
                                                                    <span>@{{ grand_total }}</span>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <div class="row" style="font-size: x-large; color: white; text-align: center; cursor: pointer;">
                                                    <div @click="$modal.hide('showInvoice')" class="col-md-6" style="background-color: #abd0e8">
                                                        Cancel
                                                    </div>
                                                    <!-- <div @click="printBill(invoice_id)" class="col-md-6" style="background-color: #fdd325">
                                                        Print
                                                    </div> -->
                                                    <div @click="printBill('printMe')" class="col-md-6" style="background-color: #fdd325">
                                                        Print
                                                    </div>
                                                </div>

                                                <div id="printMe" hidden>
                                                    <div class="row" style="font-size: 28px; margin-top: 0.5%; margin-bottom: 0.5%">
                                                        <div class="col-md-3" style="text-align: center; font-weight: bold;"><br>
                                                            <span v-if="invoiceType == 'Return'" style="font-size: 32px; font-weight: bold;">Return</span><br>&nbsp;
                                                            <span style="font-size: 32px; font-weight: bold;">
                                                                Invoice No. &nbsp; @{{ invoice_id }}<br>
                                                                <span v-if="customerName">
                                                                    &nbsp;FOR: &nbsp; @{{ customerName }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="col-md-6" style="text-align: center; font-weight: bold;">
                                                            <img src="images/logo-name-black.svg" alt="Logo" height="140px" width="200px"><br>
                                                            <img src="images/name-address.svg" alt="Logo" height="120px" width="360px">
                                                            <!-- <div class="test">
                                                                Misfit Style,<br>
                                                                Bhim Chowk, Jaripatka, Nagpur-440014 <br>
                                                                Ph: 9595034566
                                                            </div> -->
                                                        </div>      
                                                        <div class="col-md-3" style="font: cursive; font-size: 32px; font-weight: bold;"><br><br>
                                                            @{{ invoice_date }}
                                                        </div>
                                                    </div>
                                                    <div class="row" style="font-size: 32px; height: 1000px" v-bind:style="{ 'min-height': invoiceHeight + 'px' }">
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                                <thead style="font-size: 32px; text-align: center;">
                                                                    <tr>
                                                                        <th scope="col">Sr. No.</th>
                                                                        <th scope="col">Style Name</th>
                                                                        <th scope="col">Color</th>
                                                                        <th scope="col">Size</th>
                                                                        <th scope="col">MRP</th>
                                                                        <th scope="col">Qty</th>
                                                                        <th scope="col">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style="font-size: 32px; text-align: center;">
                                                                    <tr v-for="(item, index) in billItems">
                                                                        <th scope="row">@{{ index + 1 }}</th>
                                                                        <th scope="row">@{{ item.name }}</th>
                                                                        <th scope="row">@{{ item.color }}</th>
                                                                        <th scope="row">@{{ item.size }}</th>
                                                                        <th scope="row">@{{ item.mrp }}</th>
                                                                        <th scope="row">@{{ item.qty }}</th>
                                                                        <th scope="row">@{{ item.mrp * item.qty }}</th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table" style="font-size: 32px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">
                                                                        </th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col">
                                                                            <span v-if="discPercent">
                                                                                <span>Disc %:&nbsp;&nbsp;</span>
                                                                                <span>@{{ discPercent }}</span>
                                                                            </span>
                                                                        </th>
                                                                        <th scope="col">
                                                                            <span v-if="discAmt">
                                                                                <span>Disc Amt:&nbsp;&nbsp;</span>
                                                                                <span>@{{ discAmt }}</span>
                                                                            </span>
                                                                        </th>
                                                                        <th scope="col" style="width: 30%;">
                                                                            <span>Grand Total:&nbsp;&nbsp;</span>
                                                                            <span style="font-size: 42px;">@{{ grand_total }}</span>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>                                                    
                                                        </div>
                                                    </div>
                                                    <div class="row" style="font: cursive; text-align: center; font-size: 32px; font-weight: bold;">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-1" style="text-align: left;">
                                                            <img style="position: relative; left: 60px;" src="images/gs2.svg" alt="Logo" height="100px" width="75px">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            It was great to see you<br>!! Do visit again !!
                                                        </div>
                                                        <div class="col-sm-1" style="text-align: left;">
                                                            <img style="position: relative; right: 70px;" src="images/gs1.svg" alt="Logo" height="100px" width="75px">
                                                        </div>
                                                        <div class="col-sm-3"></div>
                                                    </div>
                                                    <!-- <img style="position: relative; bottom: 95px; margin-left: 48px;" src="images/smiley.svg" alt="Logo" height="100px" width="150px"><br>
                                                    <img style="position: relative; bottom: 196px; margin-left: 388px;" src="images/smiley.svg" alt="Logo" height="100px" width="150px"><br> -->
                                                </div>

                                            </modal>
                                            <!-- <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Invoice No.</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Disc Amt</th>
                                                        <th scope="col">Disc %</th>
                                                        <th scope="col">No of Items</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Grand Total</th>
                                                        <th scope="col">Payment Mode</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(inv, index) in invoices">
                                                        <th scope="row">@{{ inv.id }}</th>
                                                        <td>@{{ inv.created_at }}</td>
                                                        <td>@{{ inv.discount }}%</td>
                                                        <td>@{{ inv.discount_percent }}</td>
                                                        <td>@{{ inv.products_count }}</td>
                                                        <td>@{{ inv.payment_mode }}</td>
                                                        <td>@{{ inv.total }}</td>
                                                        <td>@{{ inv.grand_total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table> -->
                                        <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                                
                                <div class="m-b-md" style="font-size: 18px;" v-else-if="$parent.route == 'expenses'">
                                    <div style="font-size: 65px;">Expenses and Daily Closing</div>
                                    <b>Select Date:&nbsp;&nbsp;</b> <input type="date" name="" @change="changedClosingDate" style="font-size: 32px;" v-model="closingDate">
                                    <div class="row">
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-4">
                                            <div style="font-size: 32px; text-align: left;">
                                                <p>Sales:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="total_sales"></span>
                                                </p>
                                                <p>Returns:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="total_returns"></span>
                                                </p>
                                                <p>Total Expenses:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="totalExpenses"></span>
                                                </p>
                                                <p>Expected Closing Cash:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="expected_closing_cash"></span>
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-4">Closing Cash:</div>
                                                    <div class="col-md-5">
                                                        <input style="font-size:32px; width: 50%; margin: auto;" class="form-control" type="number" name="" v-model="closing_cash">
                                                    </div>
                                                     <div class="col-md-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="font-size: 36px;">Expenses</div>
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Remark</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(expense, index) in expenses">
                                                        <th scope="row">@{{ index + 1 }}</th>
                                                        <td>
                                                            <input class="form-control" type="text" name="" v-model="expense.remark" style="font-size: 32px;">
                                                        </td>
                                                        <td>
                                                            <input style="width: 60%; margin: auto;" class="form-control" type="number" name="" v-model="expense.amount" style="font-size: 32px;">
                                                        </td>
                                                        <td><i @click="removeExpense(index)" class="fas fa-trash" style="cursor: pointer;"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <i style="cursor: pointer; color: #fdd325; font-size: 32;" class="fas fa-plus-circle" @click="addExpense()"> Add Expense</i>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                    </div>
                                    <span style="font-size: 32px; margin:20px; cursor: pointer; padding: 12px; background-color: #fdd325; color: white;" @click="saveExpense()">Save</span>
                                    <span style="font-size: 32px; margin:20px; cursor: pointer; padding: 12px; background-color: #fdd325; color: white;" @click="printExpenses()">Print</span>

                                    <div hidden>
                                    <!-- SOURCE -->
                                        <div id="printStatement">
                                            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                            <div class="row" style="font-size: 28px;">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-6" style="text-align: center; font-weight: bold;">
                                                    <img src="images/logo-name-black.svg" alt="Logo" height="140px" width="200px">
                                                </div>
                                            </div>
                                            <div style="font-size: 32px; text-align: center;">
                                                <p>Statement Date:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="closingDate"></span>
                                                </p>
                                                <p>Sales:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="total_sales"></span>
                                                </p>
                                                <p>Returns:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="total_returns"></span>
                                                </p>
                                                <p>Total Expenses:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="totalExpenses"></span>
                                                </p>
                                                <p>Expected Closing Cash:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="expected_closing_cash"></span>
                                                </p>
                                                <p>Closing Cash:&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="closing_cash"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div style="font-size: 32px;" v-else="">                
                                    <div class="row" style="margin-top: 0.8%; margin-bottom: 3%; margin-left: 8%;">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-1">
                                            Add Here
                                        </div>
                                        <div class="col-md-5">
                                            <v-select autofocus @change.native="changed" ref="test" label="name" taggable :filterable="false" :options="options" @search="onSearch" @keyup.delete.native="myFunction">
                                                <template slot="no-options">
                                                   Type what you want or scan if you are feeling lazy..
                                                </template>
                                            </v-select>
                                        </div>
                                        <button class="btn" style="background-color: #fdd325; color: white;"><i class="fas fa-redo-alt" @click="resetSearch"></i></button>
                                        <!-- <button class="btn btn-primary"><i class="fas fa-redo-alt" @click="test"></i></button> -->
                                    </div>

                                    <div hidden>
                                        <!-- SOURCE -->
                                        <div id="printMeNew">
                                            <div class="row" style="font-size: 28px; margin-top: 0.5%; margin-bottom: 0.5%">
                                                <div class="col-md-3" style="text-align: center; font-weight: bold;"><br><br>
                                                    <span v-if="invoiceType == 'Return'" style="font-size: 32px; font-weight: bold;">Return</span>
                                                    <span style="font-size: 32px; font-weight: bold;">
                                                        Invoice No. &nbsp; @{{ invoice_id }}<br>
                                                        <span v-if="customerName">
                                                            &nbsp;FOR: &nbsp; @{{ customerName }}
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="col-md-6" style="text-align: center; font-weight: bold;">
                                                    <img src="images/logo-name-black.svg" alt="Logo" height="140px" width="200px"><br>
                                                    <img src="images/name-address.svg" alt="Logo" height="120px" width="360px">
                                                </div>      
                                                <div class="col-md-3" style="font: cursive; font-size: 32px; font-weight: bold;"><br><br>
                                                    @{{ invoice_date }}
                                                </div>
                                            </div>
                                            <div class="row" style="font-size: 32px; height: 1000px" v-bind:style="{ height: invoiceHeight + 'px' }">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead style="font-size: 32px; text-align: center;">
                                                            <tr>
                                                                <th scope="col">Sr. No.</th>
                                                                <th scope="col">Style Name</th>
                                                                <th scope="col">Color</th>
                                                                <th scope="col">Size</th>
                                                                <th scope="col">MRP</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 32px; text-align: center;">
                                                            <tr v-for="(item, index) in billItems">
                                                                <th scope="row">@{{ index + 1 }}</th>
                                                                <th scope="row">@{{ item.name }}</th>
                                                                <th scope="row">@{{ item.color }}</th>
                                                                <th scope="row">@{{ item.size }}</th>
                                                                <th scope="row">@{{ item.mrp }}</th>
                                                                <th scope="row">@{{ item.qty }}</th>
                                                                <th scope="row">@{{ item.mrp * item.qty }}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table" style="font-size: 32px;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">
                                                                </th>
                                                                <th scope="col"></th>
                                                                <th scope="col">
                                                                    <span v-if="discPercent">
                                                                        <span>Disc %:&nbsp;&nbsp;</span>
                                                                        <span>@{{ discPercent }}</span>
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span v-if="discAmt">
                                                                        <span>Disc Amt:&nbsp;&nbsp;</span>
                                                                        <span>@{{ discAmt }}</span>
                                                                    </span>
                                                                </th>
                                                                <th scope="col" style="width: 30%;">
                                                                    <span>Grand Total:&nbsp;&nbsp;</span>
                                                                    <span style="font-size: 36px;">@{{ grandTotal }}</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>                                                    
                                                </div>
                                            </div>
                                            <div class="row" style="font: cursive; text-align: center; font-size: 32px; font-weight: bold;">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-1" style="text-align: left;">
                                                    <img style="position: relative; left: 60px;" src="images/gs2.svg" alt="Logo" height="100px" width="75px">
                                                </div>
                                                <div class="col-sm-4">
                                                    It was great to see you<br>!! Do visit again !!
                                                </div>
                                                <div class="col-sm-1" style="text-align: left;">
                                                    <img style="position: relative; right: 70px;" src="images/gs1.svg" alt="Logo" height="100px" width="75px">
                                                </div>
                                                <div class="col-sm-3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="billing-table" class="row" style="max-height: 60vh; overflow: scroll; overflow-x: hidden; width: 100%;">
                                        <div class="col-md-12">
                                            <div style="margin-top: 40px; margin-bottom: 20px;">
                                                <span>
                                                    Customer Name:
                                                    <input style="width: 30%" type="text" name="customer_name" v-model="customerName">
                                                </span>
                                                <span style="margin-left: 20px;">
                                                    Ph:
                                                    <input type="number" name="phone" v-model="phone">
                                                </span>
                                            </div>
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Style Name</th>
                                                        <th scope="col">Color</th>
                                                        <th scope="col">Size</th>
                                                        <th scope="col">How Much</th>
                                                        <th scope="col">How Many</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in billItems">
                                                        <th scope="row">@{{ index + 1 }}</th>
                                                        <td>@{{ item.name }}</td>
                                                        <td>@{{ item.color }}</td>
                                                        <td>@{{ item.size }}</td>
                                                        <td>@{{ item.mrp }}</td>
                                                        <td style="width: 10%;"><i @click="decreaseQty(item)" class="fas fa-minus-circle" style="font-size: 15px; cursor: pointer;"></i>  <input @input="qtyChanged($event.target.value, item)" type="number" name="qty" v-model="item.qty" style="width: 45%; text-align: center; border-radius: 10%;">  <i class="fas fa-plus-circle" style="font-size: 15px; cursor: pointer;" @click="increaseQty(item)"></i></td>
                                                        <td>@{{ item.mrp * item.qty }}</td>
                                                        <td><i @click="removeItem(index)" class="fas fa-trash" style="cursor: pointer;"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" style="width: 100%; position: sticky; bottom: 0;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Payment Mode: 
                                                        <select v-model="paymentMode">
                                                            <option disabled value="">Please select one</option>
                                                            <option>Cash</option>
                                                            <option>Paytm</option>
                                                            <option>Google Pay</option>
                                                            <option>Phone Pay</option>
                                                            <option>Credit Card</option>
                                                            <option>Debit Card</option>
                                                        </select>
                                                    </th>
                                                    <th scope="col">
                                                        <select v-model="invoiceType">
                                                            <option disabled value="">Please select one</option>
                                                            <option>Sale</option>
                                                            <option>Return</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <i @click="showDiscount = 'true'" class="fas fa-chevron-left" v-if="showDiscount == 'false'"></i>
                                                        <i @click="showDiscount = 'false'" class="fas fa-chevron-right" v-else></i>
                                                    </th>
                                                    <th v-if="showDiscount == 'true'">
                                                        <span>Disc %:&nbsp;&nbsp;</span>
                                                        <input @keyup="calDiscAmt" v-model="discPercent" type="number" style="width: 14%; text-align: center;">
                                                    </th>
                                                    <th scope="col" v-if="showDiscount == 'true'">
                                                        <span>Disc Amt:&nbsp;&nbsp;</span>
                                                        <input @keyup="calDiscPercent" v-model="discAmt" type="number" style="width: 14%; text-align: center;">
                                                    </th>
                                                    <th scope="col">
                                                        <span>Grand Total:&nbsp;&nbsp;</span>
                                                        <span v-if="grandTotal > 0">@{{ grandTotal }}</span>
                                                    </th>
                                                    <th scope="col"></th>
                                                </tr>
                                                <tr>
                                                    <td><span style="cursor: pointer; padding: 7px; background-color: #fdd325; color: white;" @click="saveAndClose()">Save And New</span></td>
                                                    <td></td>
                                                    <td><span style="cursor: pointer; padding: 7px; background-color: #fdd325; color: white;" @click="saveAndPrint()">Save And Print</span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <notifications group="foo" position="top center" width="50%">

                                        </notifications>                         
                                    </div>
                                </div>
                            </invoicer>
                        </div>

                        <div class="m-b-md" style="font-size: 65px;" v-else-if="route == 'Bills'">
                            Purchase Orders
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Bill No</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bill, index) in savedBills">
                                        <td>
                                            <span v-text="bill.bill_no">
                                        </td>
                                        <td>
                                            <span v-text="bill.amount">
                                        </td>
                                        <td><span v-text="bill.remark"></td>
                                        <td><i @click="removeSavedBill(index)" class="fas fa-trash" style="cursor: pointer;"></i></td>
                                    </tr>
                                    <tr v-for="(bill, index) in newBills">
                                        <td>
                                            <input class="form-control" type="text" name="" v-model="bill.bill_no">
                                        </td>
                                        <td>
                                            <input style="width: 30%; margin: auto;" class="form-control" type="number" name="" v-model="bill.amount">
                                        </td>
                                        <td>
                                            <input style="width: 30%; margin: auto;" class="form-control" type="number" name="" v-model="bill.remark">
                                        </td>
                                        <td><i @click="removeBill(index)" class="fas fa-trash" style="cursor: pointer;"></i></td>
                                        <i style="cursor: pointer; color: #fdd325; font-size: 22px;" class="fas fa-plus-circle" @click="addExpense()"> Add New Bill</i>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="m-b-md" style="font-size: 65px;" v-else-if="route === 'stockList'">
                            Stock List
                        </div>
                        <div class="m-b-md" style="font-size: 16px;" v-else-if="route === 'updateStock'">
                            <div style="text-align: left; margin: 30px;">
                                <span style="font-weight: bold; font-size: 24px; position: relative; top: 7px;">Bulk Update</span>
                                <label class="switch">
                                    <input type="checkbox" v-model="bulkUpdate">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="container" v-if="bulkUpdate">
                                <div class="card bg-light mt-3">
                                    <div class="card-header">
                                        Hey Sexy, Hope you are having a great day!
                                    </div>
                                    <div class="card-body">
                                        <form  @submit.prevent="submit('bulkUpdateStock')">
                                            @csrf
                                            <input class="form-control" type="file" id="file" ref="file" @change="handleFileUpload()">
                                            <br>
                                            <button class="btn btn-success">Update Stock</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                
                                <invoicer ref="stock-updater" inline-template>

                                <div style="font-size: 18px;">

                                    <div class="row" style="margin-top: 0.8%; margin-bottom: 3%; margin-left: 8%;">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-1">
                                            Search Here
                                        </div>
                                        <div class="col-md-5">
                                            <v-select autofocus @change.native="changed" ref="test" label="name" taggable :filterable="false" :options="options" @search="onSearch" @keyup.delete.native="myFunction">
                                                <template slot="no-options">
                                                   Type what you want or scan if you are feeling lazy..
                                                </template>
                                            </v-select>
                                        </div>
                                        <button style="background-color: #fdd325"><i class="fas fa-redo-alt" @click="resetSearch"></i></button>
                                        <!-- <button class="btn btn-primary"><i class="fas fa-redo-alt" @click="test"></i></button> -->
                                    </div>

                                    <div id="billing-table" class="row" style="max-height: 60vh; overflow: scroll; overflow-x: hidden; width: 100%;">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">
                                                            <label class="switch">
                                                                <input type="checkbox" v-model="applyTax">
                                                                <span class="slider round"></span>
                                                            </label>
                                                            Tax
                                                        </th>
                                                        <th scope="col">MRP</th>
                                                        <th scope="col">Qty Available</th>
                                                        <th scope="col">Cost Price</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in billItems">
                                                        <th scope="row">@{{ index + 1 }}</th>
                                                        <td>@{{ item.name }}</td>
                                                        <td>@{{ item.tax }}%</td>
                                                        <td>@{{ item.mrp }}</td>
                                                        <td>@{{ item.qty_avl }}</td>
                                                        <td style="width: 10%;"><input type="number" name="cost-price" style="width: 60%; text-align: center; border-radius: 10%;" v-model="item.cost_price"></td>
                                                        <td style="width: 10%;"><input type="number" name="qty" v-model="item.qty" style="width: 45%; text-align: center; border-radius: 10%;"></td>
                                                        <td v-if="applyTax">@{{ getTaxedPrice(item) * item.qty }}</td>
                                                        <td v-else>@{{ item.cost_price * item.qty }}</td>   
                                                        <td><i @click="removeItem(index)" class="fas fa-trash" style="cursor: pointer;"></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" style="width: 100%; position: sticky; bottom: 0;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <span>Grand Total:&nbsp;&nbsp;</span>
                                                        <span v-if="grandTotal > 0">@{{ grandTotal }}</span>
                                                    </th>
                                                    <th scope="col"></th>
                                                </tr>   
                                                <tr>
                                                    <td>
                                                    <span style="cursor: pointer; padding: 7px; background-color: #fdd325; color: white;" @click="updateStock()">Update Items</span>
                                                    </td>
                                                </tr>  
                                            </thead>
                                        </table>
                                        <notifications group="foo" position="top center" width="50%">

                                        </notifications>                         
                                    </div>
                                </div>
                            </invoicer>

                            </div>
                        </div>
                        <!-- Import New Products -->
                        <div class="m-b-md" style="font-size: 16px;" v-else-if="route === 'addNewProducts'">
                            
                            <div style="width: 90%; margin:auto;">
                                <div class="card bg-light mt-6">
                                    <div class="card-header">
                                        Hey Sexy, Hope you are having a great day!
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="importNewProducts()">
                                            @csrf
                                            <!-- <input class="form-control" type="file" id="file" ref="file" @change="handleFileUpload()"> -->
                                            <br>
                                            <input class="form-control" type="file" id="fileUploader" name="fileUploader" accept=".xls, .xlsx" @change="myFunction($event)">
                                            </br>
                                            <v-client-table :data="newProducts" :columns="columns" :options="options">
                                            </v-client-table>
                                            <button class="btn btn-success">Import New Products</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div> 
                        <div class="m-b-md" style="font-size: 65px;" v-else>
                            Hey Dude!
                            What up?
                        </div>
                    </div>
                </div>
            </router-component>
        </div>
        <script src="js/app.js"></script>
        <script src="js/xlsx.full.min.js"></script>
    </body>
</html>
