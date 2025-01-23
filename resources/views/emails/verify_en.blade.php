<!DOCTYPE html>
<html lang="en">
<head>
    <!-- head  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Kanit:300&amp;subset=latin-ext,thai,vietnamese" rel="stylesheet">
    <title> asercargo.az </title>
    <style>

        @media only screen and (max-width:767px) {
            table {
                width: 100% !important;
            }

            .logo img {
                width: 100px !important;
            }

            .logo {
                text-align: left !important;
            }

            table thead span {
                margin-top: -2px !important;
            }

            table tbody p {
                font-size: 17px !important;
            }

            table thead span img {
                width: 20px !important;
            }

            table tfoot a, table tfoot p {
                font-size: 14px !important;
            }
        }

    </style>

</head>
<body>
<table style="width: 600px;  border-top: 6px solid #f15922; margin: auto;" >
    <thead>
    <tr>
        <th style="  padding: 27px 37px 20px 23px;  border-bottom: 3px solid #f0f0f0;">
            <!-- <div class="logo" style=" width: 180px;   float: left;  background-image: url();   background-size: cover;  height: 55px;   background-position: center;  background-repeat: no-repeat;" > <img src="{{asset("front/css/image/icon/logo.png")}}" /> </div> -->
            <span style=" font-family: 'Kanit', sans-serif; font-size: 29px; color: #20402e;   margin-top: 7px;  display: inline-block;  float: right;  padding-left: 47px;  background-size: 26px; background-image: url('');    background-repeat: no-repeat;  background-position: left 15px center;"> <img src="http://asercargo.az/front/css/image/icon/aser_logo.png" style=" margin-top: -4px;   display: inline-block;  vertical-align: middle;"  /> 012 000 00 00 </span>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style=" padding: 55px 37px 48px 23px;  border-bottom: 3px solid #f0f0f0;">
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Dear {{Auth::user()->name}} {{Auth::user()->surname}} , </p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">
                Thank you for choosing Aser Cargo!
                You are just one step away from finishing your registration.
                Please click the button below in order to verify your e-mail.
            </p>
            <a href="{{$actionUrl}}" style=" padding: 15px 55px;  background-color: #f15922;    font-family: 'Kanit', sans-serif;  font-size: 12px;  color: #fff;  border-radius: 5px;   display: inline-block;    margin-top: 45px;  margin-bottom: 40px; text-decoration: none;"> VERIFY </a>
            <br>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">
                If there is a problem with the "VERIFY" button, enter this address: {{$actionUrl}}
            </p>
        </td>
    </tr>
    </tbody>
    <tfoot style=" text-align: center;">
    <tr>
        <td style=" padding-bottom: 20px;">
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Thank you for shopping and shipping with us!</p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Your Aser Cargo Team</p>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
