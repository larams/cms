<div class="clearfix">
    <textarea class="form-control {{$cssClass}}" rows="{{$rows}}" name="data[{{$name}}]">{{htmlspecialchars( (array_key_exists( $name, $item->data) ? $item->data->$name  : ''), ENT_QUOTES, 'UTF-8' )}}</textarea>
    @if (!empty( $hint ))
        <p class="help-block">{{$hint}}</p>
    @endif
</div>
