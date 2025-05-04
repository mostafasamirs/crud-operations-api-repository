<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('dashboard.Reset Password')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{lang('dashboard::auth.reset_your_password')}}</h1>
    </div>
    <div class="content">
        <p>{{lang('dashboard::auth.hello') . $name }}</p>
        <p>{{lang('dashboard::auth.you_have_requested_to_reset_your_password_click_the_button_below_to_reset_it')}}</p>
        <p>{{$otp}}</p>
        <p>{{lang('dashboard::auth.if_you_did_not_request_a_password_reset_no_further_action_is_required')}}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Base Backend</p>
    </div>
</div>
</body>
</html>
