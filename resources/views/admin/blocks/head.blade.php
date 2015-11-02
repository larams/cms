<head>

    <title>{{__('Administravimo aplinka')}}</title>

    <base href="{{url()}}"/>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript" src="{{bower('jquery/dist/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{bower('jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{bower('bootstrap/dist/js/bootstrap.min.js')}}"></script>
    {{--<script type="text/javascript" src="{{bower('swfobject/swfobject/swfobject.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{bower('uploadify/jquery.uploadify.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{bower('dropzone/dist/dropzone.js')}}"></script>

    <script type="text/javascript" src="{{bower('jstree/dist/jstree.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/admin/admin.js')}}"></script>

    <link href="{{bower('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="{{bower('jstree/dist/themes/default/style.css')}}" rel="stylesheet" />
    <link href="{{bower('dropzone/dist/basic.css')}}" rel="stylesheet" />
    <link href="{{bower('dropzone/dist/dropzone.css')}}" rel="stylesheet" />
    <link href="{{asset('css/jstree/style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>

    <script type="text/javascript">

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

    </script>



</head>