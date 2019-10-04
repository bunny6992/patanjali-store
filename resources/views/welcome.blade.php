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
                                <a href="#" @click="route = 'sale'">Sale</a>
                                <a href="#" @click="route = 'return'">Return</a>
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
                        <div class="m-b-md" style="font-size: 65px;" v-if="route === 'sale'">
                            Sale
                            
                            <invoicer inline-template>
                                <div style="font-size: 18px;">

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
                                                        <td style="width: 10%;"><i @click="decreaseQty(item)" class="fas fa-minus-circle" style="font-size: 15px; cursor: pointer;"></i>  <input type="number" name="qty" v-model="item.qty" style="width: 45%; text-align: center; border-radius: 10%;">  <i class="fas fa-plus-circle" style="font-size: 15px; cursor: pointer;" @click="increaseQty(item)"></i></td>
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
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                    <th>
                                                        <span>Disc %:&nbsp;&nbsp;</span>
                                                        <input @keyup="calDiscAmt" v-model="discPercent" type="number" style="width: 14%; text-align: center;">
                                                    </th>
                                                    <th scope="col">
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
                                                    <td style="cursor: pointer;"></td>
                                                    <td><span style="cursor: pointer;">All Bills</span></td>
                                                    <td><span style="cursor: pointer;">Recall Bills</span></td>
                                                    <td><span style="cursor: pointer;">Minimise</span></td>
                                                    <td><span style="cursor: pointer;">Save And Close</span></td>
                                                    <td><span style="cursor: pointer;">Save And Print</span></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <notifications group="foo" position="top center" width="50%">

                                        </notifications>                         
                                    </div>
                                </div>
                            </invoicer>
                        </div>
                        <div class="m-b-md" style="font-size: 65px;" v-else-if="route === 'return'">
                            Return
                        </div>
                        <div class="m-b-md" style="font-size: 65px;" v-else-if="route === 'stockList'">
                            Stock List
                        </div>
                        <div class="m-b-md" style="font-size: 16px;" v-else-if="route === 'updateStock'">
                            <div class="container">
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
