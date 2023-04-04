<!DOCTYPE html>
<html>

<head>
    <title>VSMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/inc/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/inc/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inc/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inc/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inc/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('client/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/product/category.css') }}">
    <link rel="stylesheet" href="{{ asset('client/post/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/product/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/page/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/cart/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/cart/checkout.css') }}">
    <link href="{{ asset('css/inc/responsive.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <title> @yield('title')</title>
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('gallery')
    <div id="site">
        <div id="container">
            @include('client.layouts.header')
            @yield('content')
            @include('client.layouts.footer')
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script> --}}

    <script src="{{ asset('js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/main_client.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/cart/main.js') }}" type="text/javascript"></script>
    @yield('js')
    <script>
        $(document).ready(function() {
            // province district ward
            $("select#province").change(function() {
                var province_id = $(this).val();
                var url = $(this).attr('data-urlDistrict');
                var data = {
                    province_id: province_id
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        $("select#district").html(response.data);
                    },
                });
            });
            $("select#district").change(function() {
                var district_id = $(this).val();
                var url = $(this).attr('data-urlWard');
                var data = {
                    district_id: district_id
                };

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        $("select#ward").html(response.data);
                    },
                });
            });

        });
    </script>

    <script type="text/javascript" charset="utf-8">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>

</html>