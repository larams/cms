<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-sm-4 col-sm-offset-4 col-xs-12">

            {{--@if (!empty($error))--}}
                <div class="alert alert-danger login-alert">
                    {{__('Jūsų slaptažodis nustojo galioti, pasikeiskite į naują')}}
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

                    <h1>{{__('Slaptažodžio keitimas')}}</h1>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input class="form-control" placeholder="{{__('Naujas slaptažodis')}}" name="password" type="password" id="password2"/>

                    <input class="form-control" placeholder="{{__('Pakartokite slaptažodį')}}" type="password" name="password_confirmation" id="password"/>


                    <button type="submit" class="btn btn-primary">{{__('Pakeisti slaptažodį')}}</button>

                </fieldset>
            </form>
        </div>
    </div>
</div>
