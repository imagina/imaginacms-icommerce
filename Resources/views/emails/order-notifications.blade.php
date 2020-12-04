<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<style type="text/css">
    body {
        min-width: 320px;
    }

    a {
        word-break: break-all;
        text-decoration: none;
    }

    #body {
        color: #000000;
        font-family: 'Open Sans', sans-serif;
        max-width: 1440px;
        margin: auto;
    }

    .header {
        background-color: #841CBB;
        color: #ffffff;
        height: 360px;
    }

    .title {
        text-align: center;
        width: 80%;
        font-size: 40px;
        margin: 74px auto;
    }

    #template-mail {
        background-color: #ffffff;
        width: 70%;
        margin: auto;
    }

    #contenido {
        padding: 15px;
    }

    .header .header-top {
        padding: 15px;
    }

    .footer {
        background-color:{{Setting::get('isite::brandSecondary')}};
        color: white;
    }

    .footer i {
        color: #555;
    }

    .footer .social {
        margin-bottom: 20px;
    }

    .footer .fa-circle-thin {
        color: #555;
    }

    .footer .copyright {
        color: #555;
        font-size: 14px;
    }

    .stripe {
        background-color: {{Setting::get('isite::brandSecondary')}};
        padding: 10px 20px;
    }

    /********* form ************/
    .btn-requirement {
        padding: 25px 0;
    }

    .btn-requirement a {
        text-decoration: none;
        background-color:{{Setting::get('isite::brandPrimary')}};
        padding: 10px;
        margin: 10px 0;
        color: white;
    }

    .seller {
        margin-top: 20px;
    }

    .seller span {
        font-style: italic;
    }

    .seller h3, .seller h4 {
        margin: 2px;
        font-weight: 400;
        text-align: center;
    }

    .contacto {
        background-color:{{Setting::get('isite::brandPrimary')}};
        color: #e2e2e2;
        padding: 15px;
    }

    .contacto a {
        color: #e2e2e2;
    }

    /******** class **********/
    .float-left {
        float: left !important
    }

    .float-right {
        float: right !important
    }

    .float-none {
        float: none !important
    }

    .text-justify {
        text-align: justify !important
    }

    .text-nowrap {
        white-space: nowrap !important
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .text-left {
        text-align: left !important
    }

    .text-right {
        text-align: right !important
    }

    .text-center {
        text-align: center !important
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .text-capitalize {
        text-transform: capitalize;
    }

    .container {
        width: 70%;
        margin: auto;
    }

    .p-3 {
        padding: 1rem !important
    }

    .px-3 {
        padding: 0 1rem !important
    }

    .py-3 {
        padding: 1rem 0 !important
    }

    .header-contend .bg-image {
        border-radius: 50%;
        max-width: 150px;
        height: 150px;
        background: #fff;
        margin: auto;
        padding: 10px;
        overflow: hidden;
        border: #841CBB solid;
        z-index: 10000;
    }

    .header-contend .bg-image img {
        margin-top: 20px;
    }

    .email {
        margin: 120px auto 70px;
        box-shadow: 0px 0px 20px #a99b9b;
    }

    .btn {
        height: 60px;
        width: 200px;
        font-size: 15px;
        font-weight: bold;
        background-color: #BD30F3;
        color: #ffffff;
        margin: 30px 0;
    }

    .password {
        color: #BD30F3;

    }

    hr {
        border:none;
        height: 46px;
        width: 90%;
        box-shadow: 0 20px 20px -20px #333;
        margin: -50px auto 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-products {
        margin-bottom: 15px;
    }

    .table-products thead {
        background-color: #eee;
    }

    .row {
        display: inline-block;
        margin-bottom: 60px;
        text-align: left;
    }

    .col {
        width: 43%;
        display: block;
        float: left;
        padding: 0 15px;
    }

    .row p {
        margin: 0;
    }

    th {
        font-weight: bold;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    @media only screen and (min-width: 320px) and (max-width: 544.98px) {
        #body {
            font-size: 12px;
        }

        .header {
            height: 244px;
        }

        .title {
            font-size: 22px;
            width: 95%;
            margin: 30px auto;
        }

        .btn {
            height: 50px;
            width: 130px;
            font-size: 13px;
        }

        .table-products {
            font-size: 10px;
        }

        .container {
            width: 90%;
        }
    }

    @media only screen and (min-width: 545px) and (max-width: 668px) {
        #body {
            font-size: 14px;
        }

        .header {
            height: 250px;
        }

        .title {
            font-size: 28px;
            margin: 30px auto;
        }

        .table-products {
            font-size: 10px;
        }

        .container {
            width: 90%;
        }
    }

    @media only screen and (min-width: 668px) and (max-width: 754.98px) {
        .header {
            height: 320px;
        }

        .title {
            font-size: 36px;
            margin: 58px auto;
        }
    }

    @media only screen and (max-width: 992px) {
        #template-mail {
            width: 100%;
        }
    }

    @media only screen and (min-width: 755px) and (max-width: 991.98px){
        .header {
            height: 320px;
        }

        .title {
            font-size: 40px;
            margin: 55px auto;
        }
    }

    @media only screen and (min-width: 992px) and (max-width: 1436px) {
        .title {
            font-size: 40px;
            margin: 74px auto;
        }
    }

</style>
<div id="body" style="min-width: 320px; color: #000000;
        font-family: 'Open Sans', sans-serif;
        max-width: 1440px;
        margin: auto;">
    <div id="template-mail" style="background-color: #ffffff;
        width: 70%;
        margin: auto;">
        <div class="header" style="background-color: {{Setting::get('isite::brandPrimary')}};
        color: #ffffff;
        height: 210px;">
            <!-- header contend -->
            <div class="stripe" style="
              background-color: {{Setting::get('isite::brandSecondary')}};
                    padding: 10px 20px;">
                <div class="text-right text-capitalize" style="text-align: right !important; text-transform: capitalize;">
                    {{strftime("%B %d, %G")}}
                </div>
            </div>

            <div>
                <h1 class="title" style="text-align: center;
        width: 80%;
        font-size: 30px;
        margin: 12px auto;">
                    {{trans('icommerce::common.emailMsg.order-notification')}}
                </h1>
            </div>

            <div class="header-contend text-center py-3" style="text-align: center !important; padding: 1rem 0 !important; ">
                <div class="bg-image" style=" border-radius: 50%;
        max-width: 150px;
        height: 150px;
        background: #fff;
        margin: auto;
        padding: 10px;
        overflow: hidden;
                  border: {{Setting::get('isite::brandPrimary')}} solid;
        z-index: 10000;">
                    <img src="{{Setting::get('isite::logo1')}}" alt="" style="max-width: 90px; margin-top: 20px;">
                </div>
            </div>

        </div>

        <div align="center" style="margin: 120px auto 70px; width: 70%; padding: 30px; border: 1px solid #ccc; box-shadow: 0px 0px 20px #a99b9b; ">
            <p><strong> {{$order->first_name}}, {{$order->last_name}}</strong></p>
            <p>
                su orden #{{$order->id}} fue actualizada a estado: <strong>{{$order->status->title}}</strong>
            </p>
            <h4>Comentarios:</h4>
            <p class="px-3" style="padding: 1rem !important">
                <!--//TODO este $dataSend en algunos icommerce esta esperando un Array y en otros un Object por ahora se corrigió validando el dato-->
                {{is_array($dataSend) ? $dataSend["comment"] : $dataSend->comment}}
            </p>
            <p align="center">
                <a href='{{url('/orders/'.$order->id)}}'
                   style="text-decoration: none;
                     background-color: {{Setting::get('isite::brandSecondary')}};
                     padding: 10px;
                     margin: 10px 0;
                     color: white;"
                   target="_blank">Ir a ver la orden: #{{$order->id}}</a>
            </p>

        </div>


        <div class="footer p-3 text-center" style="text-align: center !important; color: white; padding: 12px;">

            <div class="social" style="margin-bottom: 20px;">
                @if(Setting::has('isite::SocialNetworks'))
                    @php
                        $socials = json_decode(Setting::get('isite::SocialNetworks'));
                    @endphp

                    @if(!empty($socials))
                        @foreach($socials as $name => $item)
                            <a href="{{ $item }}" style="word-break: break-all;
        text-decoration: none;">
                                <span class="fa-stack fa-sm" aria-hidden="true">
                                  <i class="fa fa-circle-thin fa-stack-2x" style="color: #555;"></i>
                                  <i class="fa fa-{{$name}} fa-stack-1x" style="color: #555;"></i>
                                </span>
                            </a>
                        @endforeach
                    @endif
                @endif
            </div>

            <span class="copyright" style="color: #555;
        font-size: 14px;">
                Copyrights © {{date('Y')}} {{trans('icommerce::orders.messages.rights')}} {{ setting('core::site-name') }}.
            </span>
        </div>
    </div>
</div>
</body>

</html>
