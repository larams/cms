<div class="clearfix">
    <input class="form-control {{$cssClass}}" name="data[{{$name}}]" value="{{htmlspecialchars( array_key_exists( $name, $item->data) ? $item->data->$name  : '', ENT_QUOTES, 'UTF-8')}}" />
</div>