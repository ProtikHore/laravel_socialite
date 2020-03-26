<!DOCTYPE html>
<html lang="en">
<head>
    <title> Laravel Socialite </title>
    <link rel="icon" href="{{ asset('image/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/angular.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery-ui.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/font-awesome.all.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.toaster.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/jquery.treegrid.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/jquery.treegrid.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/popupWindow.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/popupWindow.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/bootstrap-clockpicker.min.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/bootstrap-clockpicker.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/jquery-confirm.min.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/jquery-confirm.min.js') }}" type="text/javascript"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <style type="text/css">
        body {
            background-color: #FFFFFF;
            font-size: 0.9rem;
        }

        .text_orange {
            color: #A60A67;
        }

        .btn_default {
            background-color: #1b4b72;
            color: white;
        }

        .form-control {
            height: calc(1.75em + .75rem + 2px);
            padding: .5rem .75rem;
        }

        .btn_orange {
            background-color: #A60A67;
            color: white;
        }


        #header {
            height:50px;
            background-color: #FC649F;
        }

        .ajax_loading_modal {
            display:    none;
            position:   fixed;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('{{ asset('image/loading.gif') }}')
            50% 50%
            no-repeat;
        }
        .modal-ninety{
            max-width: 90%;
        }
        ::placeholder {
            font-size: 70%;
        }

    </style>
</head>
<body>

<div class="container-fluid" id="header">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-11 col-lg-10 col-xl-9 mx-auto text-center">
            <div class="row">
                <div class="col pt-2 text-white text-center" style="font-size: 20px;">Laravel Socialite</div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col fixed-top" style="height: 60px; background-color: #F5F5F5;">
            <div class="row" style="padding-top: 10px;">
                <div class="col text-right">
                    <a href="#" id="user_icon" data-toggle="popover" data-trigger="focus" onclick="return false;"><img src="{{ asset('image/user_icon.png') }}" class="rounded-circle" style="width: 40px; height: 40px;"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @yield('content')
</div>
<div class="container-fluid fixed-bottom" style="font-size: 0.7rem;">
    <div class="row">
        <div class="col text-center" style="padding-top: 15px; padding-bottom: 15px; color: white; background-color: #222d3f;">
            Designed & Developed by <a href="https://protikit.com" target="_blank">Protik Hore</a>
        </div>
    </div>
</div>

<div class="ajax_loading_modal">

</div>


<script>

    $(document).ready(function () {
        $('#user_icon').popover({
            html: true,
            placement: 'bottom',
            content: "<ul><li><a href='#' id='user_profile'>Profile</a></li><li><a href='#' id='change_password'>Change Password</li><li><a href='{{ url('logout') }}'>Log out</a></li></ul>",
            title: '<div id="user_title" style="font-weight: bold;">{{ session('user_type') . ' ' . session('name') }}</div><div class="text-left" style="font-size:70%;"></div>'
        });
    });

    $body = $("body");
    $(document).on({
        ajaxStart: function() {
            var zIndex = 999;
            if ($('body').hasClass('modal-open')) {
                zIndex = parseInt($('div.modal').css('z-index')) + 1;
            }
            $(".ajax_loading_modal").css({
                'z-index': zIndex
            });
            $body.addClass("loading");
            $('body.loading .ajax_loading_modal').css({
                'overflow': 'hidden',
                'display': 'block'
            });
        },
        ajaxStop: function() {
            $('body.loading .ajax_loading_modal').css({
                'overflow': 'visible',
                'display': 'none'
            });
            $body.removeClass("loading");

        }
    });
</script>


</body>
</html>
