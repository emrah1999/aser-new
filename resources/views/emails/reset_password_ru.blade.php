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
<table style="width: 600px;  border-top: 6px solid #ffce00; margin: auto;" >
    <thead>
    <tr>
        <th style="  padding: 27px 37px 20px 23px;  border-bottom: 3px solid #f0f0f0;">
            <!-- <div class="logo" style=" width: 180px;   float: left;  background-image: url();   background-size: cover;  height: 55px;   background-position: center;  background-repeat: no-repeat;" > <img src="{{asset("front/css/image/icon/logo.png")}}" /> </div> -->
            <span style=" font-family: 'Kanit', sans-serif; font-size: 29px; color: #20402e;   margin-top: 7px;  display: inline-block;  float: right;  padding-left: 47px;  background-size: 26px; background-image: url('');    background-repeat: no-repeat;  background-position: left 15px center;"> <img src="http://asercargo.az/front/css/image/icon/aserExpressLogo.png" style=" margin-top: -4px;   display: inline-block;  vertical-align: middle;"  /> 012 310 07 09 </span>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style=" padding: 55px 37px 48px 23px;  border-bottom: 3px solid #f0f0f0;">
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Уважаемый покупатель,</p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">
                Aser Cargo Express получила от вас запрос на сброс пароля. Вы можете сбросить пароль, нажав кнопку ниже:
            </p>
            <p>
                <a href="{{$actionUrl}}" style=" padding: 15px 55px;  background-color: #ffce00;    font-family: 'Kanit', sans-serif;  font-size: 12px;  color: #fff;  border-radius: 5px;   display: inline-block;    margin-top: 45px;  margin-bottom: 40px; text-decoration: none;"> Сброс пароля </a>
            </p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">
                Время использования этой ссылки составляет 60 минут.
            </p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">
                Если есть проблема с кнопкой "Сброс пароля", введите этот адрес: {{$actionUrl}}
            </p>
        </td>
    </tr>
    </tbody>
    <tfoot style=" text-align: center;">
    <tr>
        <td style=" padding-bottom: 20px;">
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Благодарим Вас за сотрудничество!</p>
            <p style="font-family: 'Kanit', sans-serif;  font-size: 16px; color: #20402e; line-height: 21px;   margin-bottom: 10px;">Команда Aser Cargo</p>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
