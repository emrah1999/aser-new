<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Hello, {{ $customer_name }}!</h2>
    <p>Your OTP code for verification is:</p>
    <p class="otp">{{ $otp }}</p>
    <p>Please enter this code to verify your identity. Do not share this code with anyone.</p>
    <p>Thank you!</p>
</div>
</body>
</html>
