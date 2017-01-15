<div class="clearfix">

    <div class="row">
        @foreach ( $sizes as $size )
            <div class="col-xs-12 col-sm-6">

                @if (count( $sizes ) > 1)
                    <div>
                        <strong>{{__("Screen size")}} {{strtoupper( $size )}}</strong>
                    </div>
                @endif

                <div style="margin-top: 10px;">
                    @if (!empty( $item->data->{$name}->{$size} ))
                        <img style="margin-bottom: 10px;" id="property_{{$name}}_{{$size}}_thumb" src="{{url('media/'. $item->data->{$name}->{$size}->id . '_120_120.png')}}"/>
                        <div>
                            <label>
                                <input type="checkbox" name="data[{{$name}}_{{$size}}_delete]" value="1"/> {{__("Delete uploaded image")}}
                            </label>
                        </div>
                    @else
                        <img style="margin-bottom: 10px; display: none;" id="property_{{$name}}_{{$size}}_thumb" src=""/>
                    @endif

                    <input name="data[{{$name}}_{{$size}}]" type="hidden" id="property_{{$name}}_{{$size}}_value" value="@if (!empty( $item->data->{$name}->{$size} )){{$item->data->{$name}->{$size}->id}}@endif"/>

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
                    <a class="btn btn-xs btn-default" href="#" onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name.'_'.$size )}}', 'image-{{$name}}-{{$size}}}', 'width=900,height=600' ); return false;">
                        <span class="fa fa-file-o"></span>
                        {{__("Choose image")}}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>