<html>
    <head>

    </head>
    <body style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
        <p style="font-size: 18px; font-weight: bold;">{{__("New administrator has been created with your email")}}</p>

        <p><strong>URL:</strong> <a href="{{url('/admin')}}">{{url('/admin')}}</a></p>
        <p><strong>Login:</strong> {{$item->email}}</p>
        <p><strong>Password:</strong> {{$input['password']}}</p>
    </body>
</html>