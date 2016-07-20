<div class="clearfix">

    <input name="data[{{$name}}]" type="hidden" id="property_{{$name}}_value" value="@if (!empty( $item->data->$name )){{$item->data->{$name}->id}}@endif" />
    <div id="property_{{$name}}_name">    @if (!empty( $item->data->$name )){{$item->data->{$name}->name}}@endif</div>

    <a class="btn btn-sm btn-default" href="#" onclick="window.open( '{{url('admin/gallery/index/0/1/'.$name )}}', 'image-{{$name}}', 'width=900,height=600' ); return false;"><span class="fa fa-folder-o"></span> {{__("Choose file")}}</a>
</div>