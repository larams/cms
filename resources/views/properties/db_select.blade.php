<div class="clearfix">

    @if ( $style == 'SELECT' )
        <select {{$multiple ? 'multiple="multiple"' : ''}} name="data[{{$name}}]{{$multiple ? '[]' : ''}}" class="form-control">
    @endif

            @if ( !empty( $allowEmpty ) && empty( $multiple ) )
                @if ( $style == 'SELECT')
                    <option value=""><?=__("Not selected");?></option>
                @else
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="data[{{$name}}]" value=""/> {{__("Not selected")}}
                        </label>
                    </div>
                @endif
            @endif

            @foreach ( $items as $item )
                @if ( $style == 'SELECT' )
                    <option {{$item->selected ? 'selected="selected"' : ''}} value="{{ $item->{$keyColumn} }}">{{$item->{$valueColumn} }}</option>
                @else
                    <div class="checkbox">
                        <label>
                            <input {{$item->hasChilds ? 'style="display: none;"' : ''}} {{$item->selected ? 'checked="checked"' : ''}} type="{{$multiple ? 'checkbox' : 'radio'}}" name="data[{{$name}}]{{$multiple ? '[]' : ''}}" value="{{$item->{$keyColumn} }}"/>
                            {{$item->{$valueColumn} }}
                        </label>
                    </div>
                @endif
            @endforeach

    @if ( $style == 'SELECT' )
        </select>
    @endif

</div>