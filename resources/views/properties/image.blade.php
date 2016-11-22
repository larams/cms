<div class="clearfix">

    @if (!empty( $item->data->$name ))
        <img style="margin-bottom: 10px;" id="property_{{$name}}_thumb" src="{{url('media/'. $item->data->{$name}->id . '_120_120.png')}}"/>
        <div>
            <label>
                <input type="checkbox" name="data[{{$name}}_delete]" value="1"/> {{__("Delete uploaded image")}}
            </label>
        </div>
    @else
        <img style="margin-bottom: 10px; display: none;" id="property_{{$name}}_thumb" src=""/>
    @endif

    <input name="data[{{$name}}]" type="hidden" id="property_{{$name}}_value" value="@if (!empty( $item->data->$name )){{$item->data->{$name}->id}}@endif"/>


    @if ( !empty( $versions ))

        @if ( count( $versions) == 1)
            <br/>{{__("Image size")}}: <strong>{{$versions['default']['width']}}x{{$versions['default']['height']}}</strong><br/>
        @else

            <br/>{{__("Image sizes")}}:<br/>

            @foreach ( $versions as $versionName => $version )
                @if (!empty( $version['title'] )) {{$version['title']}}: @else {{$versionName}} @endif <strong>{{$version['width']}}x{{$version['height']}}</strong><br/>
        @endforeach
    @endif

@endif

<!-- target={{$name}} -->
    <a class="btn btn-xs btn-default" href="#" onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name )}}', 'image-{{$name}}', 'width=900,height=600' ); return false;"> <span class="fa fa-file-o"></span> {{__("Choose image")}}</a>
</div>