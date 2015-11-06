@if ( !empty( $isCreate ) )
    <h2 class="mt20">{{__('Create New Content Type')}}</h2>
@else
    <h2 class="mt20">{{__('Edit Content Type')}}</h2>
@endif


<form class="form mt20" action="{{url( 'admin/types/save', [ !empty( $item->id ) ? $item->id : '' ] )}}" enctype="multipart/form-data" method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <fieldset>

        <div class="row">
            <div class="col-xs-4">
                {!! BootstrapForm::input( ['name' => 'name', 'value' => !empty( $item ) ? $item->name : '', 'title' => __('Developer title')] ) !!}
            </div>
            <div class="col-xs-4">
                {!! BootstrapForm::input( ['name' => 'name_lang', 'value' => !empty( $item ) ? $item->name_lang : '', 'title' => __('Administrator title') ] ) !!}
            </div>
            <div class="col-xs-4">
                {!! BootstrapForm::select( ['name' => 'type_id', 'value' => !empty( $item ) ? $item->handler : null, 'title' => __('Handler'), 'values' => $handlers, 'option_key' => 'id', 'option_value' => 'title' ]) !!}
            </div>
        </div>




        <div class="row">
            <div class="col-sm-6">
                <legend>{{__('Child tree elements types')}}</legend>

                <div class="form-group">
                    <div class="col-sm-12">
                        @foreach ( $types as $type )
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="relations[]" value="{{$type->id}}" @if ( !empty( $relations ) && in_array( $type->id, $relations))checked="checked"@endif />
                                    {{$type->name}} ({{$type->name_lang}})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <legend>{{__('Child additional element types')}}</legend>
                <div class="form-group">
                    <div class="col-sm-12">
                        @foreach ( $types as $type )
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="additionals[]" value="{{$type->id}}" @if ( !empty( $additional ) && in_array( $type->id, $additional ))checked="checked"@endif />
                                    {{$type->name}} ({{$type->name_lang}})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                <button class="btn btn-default" onclick="history.back();return false;">{{__('Cancel')}}</button>
            </div>
        </div>

    </fieldset>
</form>