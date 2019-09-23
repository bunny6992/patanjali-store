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
                                <a href="#">Sale</a>
                                <a href="#">Return</a>
                            </div>
                        </div>
                        <div class="dropdown" style="margin-left: 2%; margin-top: 0.6%;">
                            <a style="font-size: x-large;">Inventory</a>
                            <div class="dropdown-content">
                                <a href="#">Stock List</a>
                                <a href="#">Update Stock</a>
                            </div>
                        </div>          
                    </div>

                    <div class="content" style="margin-top: 1%">
                        <div class="m-b-md" style="font-size: 65px;">
                            Sale
                        </div>
                        <div class="m-b-md" style="font-size: 65px;">
                            Return
                        </div>
                        <div class="m-b-md" style="font-size: 65px;">
                            Stock List
                        </div>
                        <div class="m-b-md" style="font-size: 65px;">
                            Update Stock
                        </div>
                    </div>
                </div>
            </router-component>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
