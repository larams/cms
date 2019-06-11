<div class="clearfix">

    <input name="data[{{$name}}]" type="hidden" id="property_{{$name}}_value" value="@if (!empty( $item->data->$name )){{$item->data->{$name}->id}}@endif"/>
    <div id="property_{{$name}}_name">    @if (!empty( $item->data->$name )){{$item->data->{$name}->name}}@endif</div>

    @if (!empty( $item->data->$name ))
        <label>
            <input type="checkbox" name="data[{{$name}}_delete]" value="1"/> {{trans('admin.button.delete_uploaded_file')}}
        </label>
    @endif

    <a class="btn btn-sm btn-default" href="#" onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name )}}', 'image-{{$name}}', 'width=900,height=600' ); return false;"><span class="fa fa-folder-o"></span> {{trans('admin.button.choose_file')}}</a>

    @if (!empty( $hint ))
        <p class="help-block">{{$hint}}</p>
    @endif
</div>
