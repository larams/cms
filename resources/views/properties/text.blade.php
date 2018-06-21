<div class="clearfix">
    <input
            class="form-control {{$cssClass}}"
            name="data[{{$name}}]"
            value="{{htmlspecialchars( property_exists( $item->data, $name ) ? $item->data->$name  : '', ENT_QUOTES, 'UTF-8')}}"
    />
</div>
