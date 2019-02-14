<!DOCTYPE html>
<html>

@include('larams::admin.blocks.head')

<body>

@if ( empty( $hideNavigationBar ))
    @include('larams::admin.blocks.navbar')
@endif

<div
        class="@if (!empty( $mainContainerClass )) {{$mainContainerClass}} @else container @endif"
        @if (!empty( $hideNavigationBar )) style="padding-top: 0 !important;" @endif
>

    {!! $content !!}

</div>

<div class="loader" style="display: none;" id="loader">
    <div class="loader-backdrop">&nbsp;</div>
    <div class="loader-content">
        <img src="{{asset('vendor/larams/img/admin/loading.gif')}}"/>
        <div>{{trans('admin.text.loading')}}</div>
    </div>
</div>

@include('larams::admin.blocks.footer_scripts')

</body>

</html>
