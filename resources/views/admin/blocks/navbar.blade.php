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
                {{--@todo: is config('larams.admin.menu_items') --}}
                @foreach(config('larams.admin.menu_items') as $menuItem)
                    @if(\Illuminate\Support\Facades\Auth::user()->isAllowed($menuItem['route']))
                        <li @if (request()->is($menuItem['route'])) class="active" @endif><a href="{{route($menuItem['route'])}}">{{trans($menuItem['title'])}}</a></li>
                    @endif
                @endforeach
                {{--@if (config('larams.structure'))--}}
                    {{--<li><a href="{{url('admin/structure')}}">{{trans('admin.menu.content')}}</a></li>--}}
                {{--@endif--}}
                {{--@if (config('larams.gallery'))--}}
                    {{--<li><a href="{{url('admin/gallery')}}">{{trans('admin.menu.gallery')}}</a></li>--}}
                {{--@endif--}}
                {{--@if (config('larams.translations'))--}}
                    {{--<li><a href="{{url('admin/translations')}}">{{trans('admin.menu.translations')}}</a></li>--}}
                {{--@endif--}}
                {{--<li><a href="{{url('admin/administrators')}}">{{trans('admin.menu.administrators')}}</a></li>--}}
                {{--@if (config('larams.structure'))--}}
                    {{--<li><a href="{{url('admin/types')}}">{{trans('admin.menu.content_types')}}</a></li>--}}
                {{--@endif--}}
                {{--@include('larams::admin.blocks.navbar_extra')--}}
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="divider-before"><span>{{trans('admin.text.logged_as')}} <strong>{{Auth::user()->name}}</strong></span></li>
                <li><a href="{{url( 'admin/auth/logout' )}}" class="logout-link"> {{trans('admin.menu.logout')}}</a></li>
            </ul>
        </div>
    </div>
</nav>
