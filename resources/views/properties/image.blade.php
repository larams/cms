<div class="clearfix">

    <div class="row">
        @if (!empty( $automatic))
            <div class="col-xs-12 col-sm-3">
                <div style="margin-top: 10px;">
                    @if (!empty( $item->data->{$name} ))
                        <img style="margin-bottom: 10px; max-width: 120px;" id="property_{{$name}}_thumb"
                             src="{{url('media/'. $item->data->{$name}->id . '_120_120.' . $format )}}"/>
                        <div>
                            <label>
                                <input type="checkbox" name="data[{{$name}}_delete]"
                                       value="1"/> {{trans('admin.button.delete_uploaded_image')}}
                            </label>
                        </div>
                    @else
                        <img style="margin-bottom: 10px; max-width: 120px; display: none;" id="property_{{$name}}_thumb"
                             src=""/>
                    @endif

                    <input name="data[{{$name}}]" type="hidden" id="property_{{$name}}_value"
                           value="@if (!empty( $item->data->{$name} )){{$item->data->{$name}->id}}@endif"/>

                    <a class="btn btn-xs btn-default" href="#"
                       onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name )}}', 'image-{{$name}}', 'width=900,height=600' ); return false;">
                        <span class="fa fa-file-o"></span>
                        {{trans('admin.button.choose_image')}}
                    </a>
                </div>
            </div>
            @if (count( $versions ) > 1)
                <div class="col-xs-12 col-sm-6">
                    <strong>{{trans('admin.text.automatically_generated_versions')}}<br/>
                        @foreach ( $versions as $version => $versionDetails )
                            {{strtoupper( $version )}}, {{$versionDetails['width']}}x{{$versionDetails['height']}}<br/>
                        @endforeach
                    </strong>
                </div>
            @else
                @foreach ( $versions as $version => $versionDetails )
                    <div>
                        <strong>
                            {{trans('admin.text.image_size')}}: {{$versionDetails['width']}}x{{$versionDetails['height']}}
                        </strong>
                    </div>
                @endforeach
            @endif
        @else
            @foreach ( $versions as $version => $versionDetails )
                <div class="col-xs-12 col-sm-6">
                    @if (count( $versions ) > 1)
                        <div>
                            <strong>
                                {{trans('admin.text.version')}} {{strtoupper( $version )}}, {{$versionDetails['width']}}x{{$versionDetails['height']}}
                            </strong>
                        </div>
                    @else
                        @foreach ( $versions as $version => $versionDetails )
                            <div>
                                <strong>{{trans('admin.text.image_size')}}: {{$versionDetails['width']}}x{{$versionDetails['height']}}</strong>
                            </div>
                        @endforeach
                    @endif

                    <div style="margin-top: 10px;">
                        @if (!empty( $item->data->{$name}->{$version} ))
                            <img style="margin-bottom: 10px; max-width: 120px;"
                                 id="property_{{$name}}_{{$version}}_thumb"
                                 src="{{url('media/'. $item->data->{$name}->{$version}->id . '_120_120.'. $format )}}"/>
                            <div>
                                <label>
                                    <input type="checkbox" name="data[{{$name}}_{{$version}}_delete]"
                                           value="1"/> {{trans('admin.button.delete_uploaded_image')}}
                                </label>
                            </div>
                        @else
                            <img style="margin-bottom: 10px; max-width: 120px; display: none;"
                                 id="property_{{$name}}_{{$version}}_thumb" src=""/>
                        @endif

                        <input name="data[{{$name}}_{{$version}}]" type="hidden"
                               id="property_{{$name}}_{{$version}}_value"
                               value="@if (!empty( $item->data->{$name}->{$version} )){{$item->data->{$name}->{$version}->id}}@endif"/>

                        <a class="btn btn-xs btn-default" href="#"
                           onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name.'_'.$version )}}', 'image-{{$name}}-{{$version}}}', 'width=900,height=600' ); return false;">
                            <span class="fa fa-file-o"></span>
                            {{trans('admin.button.choose_image')}}
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="row mt20">
        <div class="col-xs-12">
            <label>{{trans('admin.text.image_alt_text')}}</label>
            <input name="data[{{$name}}_alt]"
                   class="form-control"
                   type="text"
                   value="@if (!empty( $item->data->{$name}->alt )){{$item->data->{$name}->alt}}@endif"
            />
        </div>
    </div>
</div>
