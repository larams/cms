<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-sm-4 col-sm-offset-4 col-xs-12">

            {{--@if (!empty($error))--}}
                <div class="alert alert-danger login-alert">
                    {{trans('admin.error.password_expired')}}
                </div>
            {{--@endif--}}

            @if ( $errors->all() )
                <div class="alert alert-danger login-alert">
                    @foreach ( $errors->all() as $error )
                        {{$error}}
                    @endforeach
                </div>
            @endif

            <form class="form login-container" action="{{url( 'admin/password' )}}" method="post">
                <fieldset>

                    <h1>{{trans('admin.title.password_reset')}}</h1>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input class="form-control" placeholder="{{trans('admin.field.new_password')}}" name="password" type="password" id="password2"/>

                    <input class="form-control" placeholder="{{trans('admin.field.repeat_password')}}" type="password" name="password_confirmation" id="password"/>


                    <button type="submit" class="btn btn-primary">{{trans('admin.button.change_password')}}</button>

                </fieldset>
            </form>
        </div>
    </div>
</div>
