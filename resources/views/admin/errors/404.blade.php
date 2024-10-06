<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page not found - 404</title>
    @vite('resources/admin_assets/sass/app.scss')

    <style type="text/css">
        body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}
            .error-template {padding: 40px 15px;text-align: center;}
            .error-actions {margin-top:15px;margin-bottom:15px;}
            .error-actions .btn { margin-right:10px; }
        .pt-10{
            padding-top:10rem;
        }
        .btn.btn-lg{
            padding: 0.875rem 1.4rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-10">
                <div class="error-template">
                    <h1><img src="{{ Vite::asset(\App\Library\Enum::LOGO_PATH) }}" class="mr-2" alt="logo" width="200"/></h1>
                    <h2 class="mt-4"> 404 Not Found </h2>
                    <div class="error-details">
                        Sorry, an error has occured, Requested page not found!
                    </div>
                    <div class="error-actions text-center">
                        <a href="#" onclick="history.back()" class="btn btn2-secondary btn-lg">
                            <span class="glyphicon glyphicon-envelope"></span> Back
                        </a>
                        <a href="{{ route('admin.home.dashboard') }}" class="btn btn2-secondary btn-lg">
                            <span class="glyphicon glyphicon-home"></span> Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
