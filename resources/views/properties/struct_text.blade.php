<div class="row">
    @if ( !empty( $items ))
        @foreach ( $items as $inputItem )
            <div class="{{$inputWidthClass}}">
                <div class="@if ($inputWidthClass == 'col-xs-12') form-group @endif">
                    <div class="input-group">
                        <span class="input-group-addon">{{$inputItem->name}}</span>
                        <input
                                class="form-control"
                                name="data[{{$name}}][{{$inputItem->id}}]"
                                value="@if (isset( $item->data->{$name}->{$inputItem->id} ) ){{$item->data->{$name}->{$inputItem->id} }}@endif"/>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>