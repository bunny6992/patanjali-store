<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.css') }}">
        <style type="text/css">
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
                    <div style="width: 100%; background: powderblue; height: 60px; color: white;">
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
                            <a style="font-size: x-large;">Sales</a>
                            <div class="dropdown-content">
                                <a href="#" @click="getInvoicer()">Sale</a>
                                <a href="#" @click="getInvoices()">Invoices</a>
                            </div>
                        </div>
                        <div class="dropdown" style="margin-left: 2%;">
                            <a style="font-size: x-large;">Inventory</a>
                            <div class="dropdown-content">
                                <a href="#" @click="route = 'stockList'">Stock List</a>
                                <a href="#" @click="route = 'updateStock'">Update Stock</a>
                                <a href="#" @click="route = 'addNewProducts'">Add New Products</a>
                            </div>
                        </div>          
                    </div>

                    <div class="content" style="margin-top: 0.7%;">
                        <div v-if="route === 'sale' || route === 'invoices'">
                            
                            <invoicer ref="invoicer" inline-template>

                                <div style="width: 80%; margin: 0 auto;" v-if="$parent.route === 'invoices'">
                                    <span style="font-size: 65px;">Invoices</span>
                                    <!-- <div id="test" class="row" style=""> -->
                                        <!-- <div class="col-md-12"> -->
                                            <v-client-table :data="invoices" :columns="invoice_columns" :options="table_options">
                                                <a slot="view" slot-scope="props" class="fa fa-expand-arrows-alt" @click="editInvoice(props.row.id)" style="cursor: pointer;"></a>
                                                <a slot="print" slot-scope="props" class="fa fa-print" @click="printBill(props.row.id)" style="cursor: pointer;"></a>
                                            </v-client-table>
                                            <modal name="showInvoice" height="auto" width="75%" style="font-size: 18px; text-align: center;">
                                                
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">Sr No</th>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Tax</th>
                                                            <th scope="col">Price Incl. Tax</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in billItems">
                                                            <th scope="row">@{{ index + 1 }}</th>
                                                            <td>@{{ item.name }}</td>
                                                            <td>@{{ item.tax }}%</td>
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
                                                    <div @click="$modal.hide('showInvoice')" class="col-md-6" style="background-color: indianred">
                                                        Cancel
                                                    </div>
                                                    <div @click="printBill(invoice_id)" class="col-md-6" style="background-color: darkseagreen">
                                                        Print
                                                    </div>
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


                                <div style="font-size: 18px;" v-else="">

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
                                        <button class="btn btn-primary"><i class="fas fa-redo-alt" @click="resetSearch"></i></button>
                                        <!-- <button class="btn btn-primary"><i class="fas fa-redo-alt" @click="test"></i></button> -->
                                    </div>

                                    <div id="billing-table" class="row" style="max-height: 60vh; overflow: scroll; overflow-x: hidden; width: 100%;">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Tax</th>
                                                        <th scope="col">Price Incl. Tax</th>
                                                        <th scope="col">Qty Available</th>
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
                                                            <option>Patanjali Card</option>
                                                        </select>
                                                    </th>
                                                    <th scope="col" v-if="paymentMode == 'Patanjali Card'">
                                                        <span>Recharge Amt:&nbsp;&nbsp;</span>
                                                        <input v-model="rechargeAmt" type="number" style="width: 14%; text-align: center;">
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
                                                    <td><span style="cursor: pointer; padding: 7px; background-color: seagreen; color: white;" @click="saveAndClose()">Save And New</span></td>
                                                    <td></td>
                                                    <td><span style="cursor: pointer; padding: 7px; background-color: seagreen; color: white;" @click="saveAndPrint()">Save And Print</span></td>
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
                                        <button class="btn btn-primary"><i class="fas fa-redo-alt" @click="resetSearch"></i></button>
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
                                                        <td v-if="applyTax">@{{ getTaxedPrice(item) }}</td>
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
                                                    <span style="cursor: pointer; padding: 7px; background-color: seagreen; color: white;" @click="updateStock()">Update Items</span>
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
                            
                            <div class="container">
                                <div class="card bg-light mt-3">
                                    <div class="card-header">
                                        Hey Sexy, Hope you are having a great day!
                                    </div>
                                    <div class="card-body">
                                        <form  @submit.prevent="submit('bulkAddNewStock')">
                                            @csrf
                                            <input class="form-control" type="file" id="file" ref="file" @change="handleFileUpload()">
                                            <br>
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
    </body>
</html>
