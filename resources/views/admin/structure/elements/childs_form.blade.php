<a class="btn btn-xs btn-primary" data-toggle="modal" href="#create_child_item_<?=$tree;?>"><i class="fa fa-plus-circle"></i>
    {{$title}}
</a>

<div id="create_child_item_<?=$tree?>" class="modal fade" tabindex="-1" role="dialog">

    <form action="{{url('admin/structure/add/' . $currentItem->id )}}" method="post" name="create_new_element" class="form mt20">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{$title}}</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tree" value="<?=$tree; ?>"/>

                    {!! BootstrapForm::input( ['name' => 'name', 'title' => __('Title'), 'max_length' => '255' ] ) !!}

                    @if ( count( $types ) == 1 )
                        <input type="hidden" name="type_id" value="{{$types->first()->id}}"/>
                    @else
                        {!! BootstrapForm::select( ['name' => 'type_id', 'title' => __('Type'), 'values' => $types, 'option_key' => 'id', 'option_value' => 'name_lang' ]) !!}
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Cancel")}}</button>
                    <button type="submit" class="btn btn-primary">{{__("Continue")}}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->