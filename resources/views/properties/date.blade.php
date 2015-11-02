
<div>
    <input class="form-control" name="data[{{$name}}]" value="@if(!empty( $item->data->$name )){{$item->data->$name}}@endif" id="element_{{$name}}" />
</div>

<link rel="stylesheet" href="{{bower('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />

<script src="{{bower('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

@if ( \App::getLocale() != 'en')
    <script src="{{bower('bootstrap-datepicker/dist/locales/bootstrap-datepicker.'. \App::getLocale() .'.min.js')}}"></script>
@endif

<script type="text/javascript">

    $('#element_{{$name}}').datepicker( {
        format: '{{$format}}',
        autoclose: true
    });

</script>