<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>@yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">

    <style type="text/css">
    body {
      background-color: #DADADA;
    }
    [v-cloak] {
      display: none;
    }

    .ui.column.grid>[class*="thirteen wide"].column, .ui.grid>.column.row>[class*="thirteen wide"].column, .ui.grid>.row>[class*="thirteen wide"].column, .ui.grid>[class*="thirteen wide"].column {
        width: 100%!important;
    }

    </style>

    </script>
</head>

<body>

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.special.cards .image').dimmer({
                on: 'hover'
            });
            $('#logoutButton').click(function(){
                $('#logoutModal').modal('show');
            })
        });
        
    </script>

    @yield('script')

</body>
</html>