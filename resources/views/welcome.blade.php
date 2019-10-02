<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
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
                                    <div class="row" style="height: 320px; overflow: scroll; overflow-x: hidden; width: 100%;">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Soyavita</td>
                                                        <td>10%</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            Add Here
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="add-item" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" style="width: 100%;">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Sr. No.</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Tax</th>
                                                    <th scope="col">Price Incl. Tax</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                            </thead>
                                        </table>                             
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
