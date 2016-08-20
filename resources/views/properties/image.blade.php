<div class="clearfix">

    @if (!empty( $item->data->$name ))
    <img style="margin-bottom: 10px;" id="property_{{$name}}_thumb" src="{{url('media/'. $item->data->{$name}->id . '_120_120.png')}}" />
    @endif
    <input name="data[{{$name}}]" type="hidden" id="property_{{$name}}_value" value="@if (!empty( $item->data->$name )){{$item->data->{$name}->id}}@endif" />


    @if ( !empty( $versions ))

        @if ( count( $versions) == 1)
            <br />Paveiksliuko dydis: <strong>{{$versions['default']['width']}}x{{$versions['default']['height']}}</strong><br />
        @else

            <br />Paveiksliuko dydžiai:<br />

            @foreach ( $versions as $versionName => $version )
                @if (!empty( $version['title'] )) {{$version['title']}}: @else {{$versionName}} @endif <strong>{{$version['width']}}x{{$version['height']}}</strong><br />
            @endforeach
        @endif

    @endif

    <!-- target={{$name}} -->
    <a class="btn btn-xs btn-default" href="#" onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name )}}', 'image-{{$name}}', 'width=900,height=600' ); return false;"> <span class="fa fa-file-o"></span> {{__("Choose image")}}</a>
</div>

{{--
$ret_val = '

			<div>



			';

            if ( !empty( $this->_config['versions'] )) {

                if ( count( $this->_config['versions'] ) == 1 ) {

                    $version = $this->_config['versions'][0];
                    $ret_val .= '';
                } else {


                }

            }

			if ( isset( $this->_intern_data[$this->_config['name']]['thumb']['url'] ) ) {

				$ret_val .= '<div class="checkbox"><label><input type="checkbox" name="'.$prefix.'['.$this->_config['name'].'_delete]" /> Ištrinti paveiksliuka</label></div>';

			}

			$ret_val .= '
			</div>
			';

		return( $ret_val );
		--}}