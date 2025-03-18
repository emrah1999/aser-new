<link rel="icon" type="text/css" href="{{ asset('web/images/logo/logo.png') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('web/css/library/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('web/css/library/owl.carousel.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset("frontend/css/sweetalert2.min.css")}}">
<link rel="stylesheet" type="text/css" href="{{ asset('web/css/style.css?ver=9.16') }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>

    .section-margin-top{
        margin-top: 30px;
    }
    .footer-new {
        margin-top: 20px;
    }
    .nav-padding{
        padding-bottom: 7px;
    }
    .section-margin-bottom{
        margin-bottom: 10px;
    }
    .content{
        padding-top : 109px;
    }
    .content-page-section{
        padding-top : 109px;

    }
    .language-col{
        position:absolute;
        right: 5px;
        top: 42px;

    }
    .nav-menu__link {
        display: flex;
        padding: 12px 18px;
    }
    .nav-profile-menu__link-title{
        font-size: 17px;
    }


    .header-bottom {
        /*position: relative;*/
        /*z-index: 1000;*/
        position: fixed;
        width: 100%;
        background: white;
        z-index:100000;
    }
    .nav-menu__item {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0 !important;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        /*min-width: 250px;*/

    }
    .align-text-custom{
        text-align: center;
    }

    .nav-menu__item:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu li {
        padding: 10px 15px;
        white-space: nowrap;
    }

    .dropdown-menu li a {
        text-decoration: none;
        color: #333;
        display: block;
    }

    .dropdown-menu li:hover {
        background-color: #f4f4f4;
    }

    @media (max-width: 768px) {
        .dropdown-menu{
            max-width: 200px;
        }
    }


</style>