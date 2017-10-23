<!DOCTYPE html>
<html>

@include('larams::admin.blocks.head')

<body>

@if ( empty( $hideNavigationBar ))
    @include('larams::admin.blocks.navbar')
@endif

<div class="container" @if (!empty( $hideNavigationBar )) style="padding-top: 0 !important;" @endif>

    {!! $content !!}

</div>

<div class="loader" style="display: none;" id="loader">
    <div class="loader-backdrop">&nbsp;</div>
    <div class="loader-content">
        <img src="{{asset('vendor/larams/img/admin/loading.gif')}}" />
        <div>{{trans('admin.text.loading')}}</div>
    </div>
</div>

</body>

</html>