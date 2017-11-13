
<textarea class="form-control" id="{{$name}}" name="data[{{$name}}]" style="width: {{$width}}; height: {{$height}};">@if (isset( $item->data->$name )){{$item->data->$name}}@endif</textarea>

<script type="text/javascript" src="{{bower('ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">

    CKEDITOR.replace( '{{$name}}', {
       customConfig: '{{asset('vendor/larams/js/admin/ckeditor_config.js')}}'
    });

</script>