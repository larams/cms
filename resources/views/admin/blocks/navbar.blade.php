<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand" href="{{url('admin/structure')}}">Administration</a>--}}
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{url('admin/structure')}}">{{__('Content')}}</a></li>
                @if (config('larams.gallery'))
                    <li><a href="{{url('admin/gallery')}}">{{__('Gallery')}}</a></li>
                @endif
                <li><a href="{{url('admin/translations')}}">{{__('Translations')}}</a></li>
                <li><a href="{{url('admin/administrators')}}">{{__('Administrators')}}</a></li>
                <li @if (request()->is('admin/types/*')) class="active" @endif><a href="{{url('admin/types')}}">{{__('Content Types')}}</a></li>
                @include('larams::admin.blocks.navbar_extra')
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="divider-before"><span>{{__("Logged as")}} <strong>{{Auth::user()->name}}</strong></span></li>
                <li><a href="{{url( 'admin/auth/logout' )}}" class="logout-link"> {{__("Logout")}}</a></li>
            </ul>
        </div>
    </div>
</nav>