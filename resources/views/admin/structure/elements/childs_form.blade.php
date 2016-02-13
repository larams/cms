<a class="toggle-link create_child_item-link btn btn-xs btn-default" href="#create_child_item_<?=$index;?>"><i class="fa fa-plus-circle"></i>

    {{$title}}

</a>

<div id="create_child_item_<?=$index?>" class="hidden">
    <h3 class="pull-left">{{$title}}</h3>

    <div class="clearfix"></div>

    <form action="{{url('admin/structure/add/' . $currentItem->id )}}" method="post" name="create_new_element" class="form mt20">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="tree" value="<?=$index; ?>"/>

        {!! BootstrapForm::input( ['name' => 'name', 'title' => __('Title'), 'max_length' => '255' ] ) !!}

        @if ( count( $types ) == 1 )
            <input type="hidden" name="type_id" value="{{$types->first()->id}}"/>
        @else
            {!! BootstrapForm::select( ['name' => 'type_id', 'title' => __('Type'), 'values' => $types, 'option_key' => 'id', 'option_value' => 'name_lang' ]) !!}
        @endif

        <div class="form-group">

            <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
            <a href="#create_child_item" class="btn btn-default cancel-link">{{__('Cancel')}}</a>

        </div>

    </form>
</div>