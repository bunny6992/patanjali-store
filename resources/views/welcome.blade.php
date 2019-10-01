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
    <body>
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
                        <div class="dropdown" style="margin-left: 2%; margin-top: 0.6%;">
                            <a style="font-size: x-large;">Sales</a>
                            <div class="dropdown-content">
                                <a href="#" @click="route = 'sale'">Sale</a>
                                <a href="#" @click="route = 'return'">Return</a>
                            </div>
                        </div>
                        <div class="dropdown" style="margin-left: 2%; margin-top: 0.6%;">
                            <a style="font-size: x-large;">Inventory</a>
                            <div class="dropdown-content">
                                <a href="#" @click="route = 'stockList'">Stock List</a>
                                <a href="#" @click="route = 'updateStock'">Update Stock</a>
                                <a href="#" @click="route = 'addNewProducts'">Add New Products</a>
                            </div>
                        </div>          
                    </div>

                    <div class="content" style="margin-top: 1%">
                        <div class="m-b-md" style="font-size: 65px;" v-if="route === 'sale'">
                            Sale
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
