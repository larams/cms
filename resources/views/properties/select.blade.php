<div class="clearfix">
    @if (!empty( $multiple ))
        @foreach ( $options as $optionKey => $optionTitle )
            <div class="checkbox">
                <label>
                    <input {{!empty( $item->data->$name ) && is_array( $item->data->$name ) && in_array( $optionKey, $item->data->$name ) ? 'checked="checked"' : ''}} type="checkbox" name="data[{{$name}}]{{$multiple ? '[]' : ''}}" value="{{$optionKey}}"/>
                    {{$optionTitle}}
                </label>
            </div>
        @endforeach
    @else
        <select class="form-control {{$cssClass}}" name="data[{{$name}}]">
            @foreach ( $options as $optionKey => $optionTitle )
                <option @if (!empty( $item->data->$name) && $item->data->$name == $optionKey )selected="selected" @endif value="{{$optionKey}}">{{$optionTitle}}</option>
            @endforeach
        </select>
    @endif
</div>