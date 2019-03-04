<script type="text/javascript">

    var target = '{{$target}}';

    function GetUrlParam(paramName) {
        var oRegex = new RegExp('[\?&]' + paramName + '=([^&]+)', 'i');
        var oMatch = oRegex.exec(window.top.location.search);

        if (oMatch && oMatch.length > 1)
            return decodeURIComponent(oMatch[1]);
        else
            return '';
    }

    function OpenFile(fileUrl) {

        var funcNum = GetUrlParam('CKEditorFuncNum');

        window.top.opener.CKEDITOR.tools.callFunction(''+funcNum, fileUrl);

    }

    function assignFile(item_id, thumb_url, original_url) {

        if (target.length > 0) {

            try {
                window.opener.document.getElementById('property_' + target + '_value').value = item_id;

                if (window.opener.document.getElementById('property_' + target + '_thumb')) {

                    var elem = window.opener.document.getElementById('property_' + target + '_thumb');

                    elem.style.display = 'block';
                    elem.src = thumb_url;
                } else {
                    window.opener.document.getElementById('property_' + target + '_name').innerHTML = thumb_url;
                }

            } catch (e) {
                window.opener.console.log( e );
            }
        } else {
            OpenFile(original_url);
        }

        window.top.close();

    }

</script>

<div class="mt20 clearfix">


    @if ( count( $currentPath )  > 1)
        <ul class="breadcrumb">
            @foreach ( $currentPath as $pathItem )
                @if ($pathItem->id == $currentItem->id)
                    <li class="active">{{$pathItem->name}}</li>
                @else
                    <li>
                        <a href="{{url( 'admin/gallery/index/' . $pathItem->id . '/' . $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}">{{$pathItem->name}}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    <div class="pull-right">
        <form class="form-inline" action="{{url( 'admin/gallery/save-folder/' . $currentItem->id . '/' . $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}" method="post">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="text" name="folder" class="form-control"/>
            <button class="btn btn-primary">{{trans('admin.button.create_folder')}}</button>
        </form>
    </div>

    <div class="clearfix"></div>

    <form class="dropzone" id="galleryDropzone" action="{{url( 'admin/gallery/upload/' . $currentItem->id . '/' .  $select . '/' . $target )}}" enctype="multipart/form-data" method="post">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        @if (count( $folders ) > 0 || count( $files ) > 0)
        <ul class="list-unstyled clearfix" id="gallerySortable"  data-url="{{url( 'admin/structure/sort/' . $currentItem->id )}}" data-move-url="{{url('admin/gallery/move')}}">
            @foreach ( $folders as $k => $mediaItem )
                <li id="item-{{$mediaItem->id}}" data-id="{{$mediaItem->id}}" class="dz-preview dz-folder-preview">
                    <div class="dz-details">
                        <a onclick="return( confirmDelete() );" href="{{url('admin/gallery/delete/' . $currentItem->id . '/' . $mediaItem->id . '/'.  $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}" class="fa fa-times-circle-o dz-delete"></a>
                        <a href="{{url('admin/gallery/index/' . $mediaItem->id . '/'.  $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}">
                            <div class="dz-filename"><span data-dz-name>{{$mediaItem->name}}</span></div>
                            <span class="fa fa-folder-o thumbnail__icon"></span>
                        </a>
                    </div>
                </li>
            @endforeach

            @foreach ( $files as $k => $mediaItem )
                @if ( !empty($mediaItem->data->is_file) )
                    <li id="item-{{$mediaItem->id}}" data-id="{{$mediaItem->id}}" class="dz-preview dz-file-preview" @if (!empty( $select ) || !empty( $CKEditor )) onclick="assignFile( '{{$mediaItem->id}}', '{{$mediaItem->name.'.'.$mediaItem->extension}}', '{{url('file/'. $mediaItem->id . '_' . $mediaItem->name.'.'.$mediaItem->extension )}}' );" @endif>
                        <div class="dz-image">&nbsp;</div>
                        <div class="dz-details">
                            <a onclick="return( confirmDelete() );" href="{{url('admin/gallery/delete/' . $currentItem->id . '/' . $mediaItem->id . '/'.  $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}" class="fa fa-times-circle-o dz-delete"></a>
                            <div class="dz-filename"><span>{{$mediaItem->name}}</span></div>
                        </div>
                    </li>
                @elseif (!empty( $mediaItem->data->is_svg ))
                    <li id="item-{{$mediaItem->id}}" data-id="{{$mediaItem->id}}" class="dz-preview dz-image-preview" @if (!empty( $select ) || !empty( $CKEditor )) onclick="assignFile( '{{$mediaItem->id}}', '{{url('media/'. $mediaItem->id . '.svg')}}', '{{url('media/'. $mediaItem->id . '.svg')}}' );" @endif>
                        <div class="dz-image"><img style="width: 120px; height: 120px;" src="{{url('media/'. $mediaItem->id . '.svg' )}}"  /></div>
                        <div class="dz-details">
                            <a onclick="return( confirmDelete() );" href="{{url('admin/gallery/delete/' . $currentItem->id . '/' . $mediaItem->id . '/'.  $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}" class="fa fa-times-circle-o dz-delete"></a>
                            <div class="dz-filename"><span>{{$mediaItem->name}}</span></div>
                        </div>
                    </li>
                @else
                    <li id="item-{{$mediaItem->id}}" data-id="{{$mediaItem->id}}" class="dz-preview dz-image-preview" @if (!empty( $select ) || !empty( $CKEditor )) onclick="assignFile( '{{$mediaItem->id}}', '{{url('media/'. $mediaItem->id . '_120_120.png')}}', '{{url('media/'. $mediaItem->id . '.png')}}' );" @endif>
                        <div class="dz-image"><img src="{{url('media/'. $mediaItem->id . '_120_120_1.png' )}}"/></div>
                        <div class="dz-details">
                            <a onclick="return( confirmDelete() );" href="{{url('admin/gallery/delete/' . $currentItem->id . '/' . $mediaItem->id . '/'.  $select . '/' . $target )}}?CKEditor={{$CKEditor}}&amp;CKEditorFuncNum={{$CKEditorFuncNum}}" class="fa fa-times-circle-o dz-delete"></a>
                            <div class="dz-filename"><span>{{$mediaItem->name}}</span></div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        @endif

    </form>

</div>
