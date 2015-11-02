<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-sm-4 col-sm-offset-4 col-xs-12">

            @if (!empty($error))
                <div class="alert alert-danger login-alert">
                    {{__('Neteisingas vartotojo vardas arba slaptažodis')}}
                </div>
            @endif

            <form class="form login-container" action="{{url( 'admin/auth/login' )}}" method="post">
                <fieldset>

                    <h1>{{__('Prisijunkite')}}</h1>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input class="form-control" placeholder="{{__('Vartotojo vardas')}}" name="email" type="text" id="username"/>

                    <input class="form-control" placeholder="{{__('Slaptažodis')}}" type="password" name="password" id="password"/>


                    <button type="submit" class="btn btn-primary">{{__('Prisijungti')}}</button>

                </fieldset>
            </form>
        </div>
    </div>
</div>
