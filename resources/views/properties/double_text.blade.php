<div class="row">
    @if ( !empty( $inputs ))

        @foreach ( $inputs as $input )

            <div class="{{$input['class']}}">

                @if (!empty( $input['prefix'] ) || !empty( $input['suffix']))
                    <div class="input-group">
                @endif

                    @if (!empty( $input['prefix']))
                        <span class="input-group-addon">{{$input['prefix']}}</span>
                    @endif

                        <input class="form-control" name="data[{{$name}}][{{$input['name']}}]" value="@if (isset( $item->data->{$name}->{$input['name']} ) ){{$item->data->{$name}->{$input['name']} }}@endif" />

                    @if (!empty( $input['suffix']))
                        <span class="input-group-addon">{{$input['suffix']}}</span>
                    @endif

                @if (!empty( $input['prefix'] ) || !empty( $input['suffix']))
                    </div>
                @endif

            </div>

        @endforeach

        @if (!empty( $hint ))
            <p class="help-block">{{$hint}}</p>
        @endif

    @endif
</div>
