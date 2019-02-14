<head>

    <title>{{trans('admin.title.cms')}}</title>
    <base href="{{url( env('BASE_URL', '/'))}}"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript" src="{{bower('jquery/dist/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{bower('jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{bower('bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{bower('dropzone/dist/dropzone.js')}}"></script>
    <script type="text/javascript" src="{{bower('jstree/dist/jstree.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/larams/js/admin/admin.js')}}"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" type="text/css">
    <link href="{{bower('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{bower('jstree/dist/themes/default/style.css')}}" rel="stylesheet" />
    <link href="{{bower('dropzone/dist/basic.css')}}" rel="stylesheet" />
    <link href="{{bower('dropzone/dist/dropzone.css')}}" rel="stylesheet" />
    <link href="{{asset('vendor/larams/css/jstree/style.css')}}" rel="stylesheet" />
    <link href="{{asset('vendor/larams/css/admin.css')}}" rel="stylesheet">

    @include('larams::admin.blocks.head_scripts')

    <script type="text/javascript">
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
    </script>
</head>
