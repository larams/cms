<div class="clearfix">
    <input
            class="form-control {{$cssClass}}"
            name="data[{{$name}}]"
            value="{{ property_exists( $item->data, $name ) ? $item->data->$name  : '' }}"
    />
    @if (!empty( $hint ))
        <p class="help-block">{{$hint}}</p>
    @endif
</div>
