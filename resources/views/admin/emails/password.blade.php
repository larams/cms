<html>
    <head>

    </head>
    <body style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;">
        <p style="font-size: 18px; font-weight: bold;">{{trans('admin.text.new_administrator_has_been_created')}}</p>

        <p><strong>{{trans('admin.password_mail.url')}}:</strong> <a href="{{url('/admin')}}">{{url('/admin')}}</a></p>
        <p><strong>{{trans('admin.password_mail.login')}}:</strong> {{$item->email}}</p>
        <p><strong>{{trans('admin.password_mail.password')}}:</strong> {{$input['password']}}</p>
    </body>
</html>
