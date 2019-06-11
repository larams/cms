<div class="clearfix">

    @if ( $style == 'SELECT' )
        <select {{$multiple ? 'multiple="multiple"' : ''}} name="data[{{$name}}]{{$multiple ? '[]' : ''}}" class="form-control">
    @endif

            @if ( !empty( $allowEmpty ) && empty( $multiple ) )
                @if ( $style == 'SELECT')
                    <option value=""><?=trans('admin.text.not_selected');?></option>
                @else
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="data[{{$name}}]" value=""/> {{trans('admin..text.not_selected')}}
                        </label>
                    </div>
                @endif
            @endif

            @foreach ( $childs as $child )
                @if ( $style == 'SELECT' )
                    <option {{$child->selected ? 'selected="selected"' : ''}} value="{{$child->id}}">{{$child->whitespaces}}{{$child->name}}</option>
                @else
                    <div class="checkbox">
                        <label style="padding-left: {{($child->level - $childs[0]->level + 1) * 20}}px">
                            <input {{$child->hasChilds ? 'style="display: none;"' : ''}} {{$child->selected ? 'checked="checked"' : ''}} type="{{$multiple ? 'checkbox' : 'radio'}}" name="data[{{$name}}]{{$multiple ? '[]' : ''}}" value="{{$child->id}}"/>
                            {{$child->name}}
                        </label>
                    </div>
                @endif
            @endforeach

    @if ( $style == 'SELECT' )
        </select>
    @endif

        @if (!empty( $hint ))
            <p class="help-block">{{$hint}}</p>
        @endif

</div>
