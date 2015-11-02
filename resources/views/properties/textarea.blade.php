<div class="clearfix">
    <textarea class="form-control {{$cssClass}}" rows="{{$rows}}" name="data[{{$name}}]">{{htmlspecialchars( (!empty( $item->data->$name ) ? $item->data->$name  : ''), ENT_QUOTES, 'UTF-8' )}}</textarea>
</div>