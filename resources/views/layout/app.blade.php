<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Scheduler</title>

        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
    </head>

    <body>
        @include('layout.navbar')
        <div class="container">
            <div class="section">
                @yield('content')
            </div>
        </div>

        <!-- Compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        <script src="{{ URL::to('js/script.js') }}"></script>
        <script>
            $(function(){
                $('select').material_select();
                $('.datepicker').pickadate(picker_settings);
                var from = '{!! Input::get('from') !!}';
                var till = '{!! Input::get('till') !!}';

                if (from) $('#from').val(from);
                if (till) $('#till').val(till);
            })
        </script>
        @yield('script')
    </body>
</html>
