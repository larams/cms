<div class="clearfix">
    <select class="form-control {{$cssClass}}" name="data[{{$name}}]">
        @foreach ( $options as $optionKey => $optionTitle )
            <option @if (!empty( $item->data->$name) && $item->data->$name == $optionKey )selected="selected"@endif value="{{$optionKey}}">{{$optionTitle}}</option>
        @endforeach
    </select>
</div>