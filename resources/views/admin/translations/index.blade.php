<div class="mt20">
    <h2 class="pull-left">{{trans('admin.title.translations')}}</h2>
    <form class="pull-right form-inline" action="{{url( 'admin/translations/add' )}}" method="post">
        {!! csrf_field() !!}
        {{trans('admin.text.keyword')}}: <input type="text" name="title" class="form-control" value=""/>
        <button type="submit" class="btn btn-primary">{{trans('admin.button.create')}}</button>
    </form>
    <form class="pull-right form-inline"
          style="margin-right: 20px;"
          enctype="multipart/form-data"
          action="{{url('admin/translations/upload')}}"
          method="post">
        {!! csrf_field() !!}
        {{trans('admin.text.upload_keywords_xlf')}}: <input type="file" name="file" class="form-control"/>
        <button type="submit" class="btn btn-primary"><span
                    class="fa fa-upload"></span> {{trans('admin.button.upload')}}</button>
    </form>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            @foreach ( $languages as $language )
                <th>
                    {{$language->name}}
                    <a href="{{route('admin.translations.download', ['languageId' => $language->id ] )}}"><span
                                class="fa fa-download"></span></a>
                </th>
            @endforeach
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $keywords as $keyword )
            <tr>
                @foreach ( $languages as $k => $language )
                    <td>

                        <div style="color: #888; font-size: 12px;">
                            @if ( $k == 0)
                                {{$keyword->keyword}}
                            @else
                                &nbsp;
                            @endif
                        </div>

                        <input
                                class="form-control form-control--editable js-editable-translation"
                                type="text"
                                data-keyword-id="{{$keyword->id}}"
                                data-language-id="{{$language->id}}"
                                data-value="{{!empty($values [ $keyword->id ][ $language->id ]) ? $values [ $keyword->id ][ $language->id ] : 'missing'}}"
                                value="{{!empty($values [ $keyword->id ][ $language->id ]) ? $values [ $keyword->id ][ $language->id ] : 'missing'}}"/>
                    </td>
                @endforeach
                <td class="actions" style="min-width: 120px;">
                    <a href="{{url( 'admin/translations/edit', [ $keyword->id ] )}}"
                       class="btn btn-xs btn-default">{{trans('admin.button.edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger"
                             href="{{url('admin/translations/delete', [ $keyword->id ] )}}"
                             title="Trinti elementą">{{trans('admin.button.delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <style type="text/css">
        .form-control--editable {
            background: transparent;
            padding: 0;
            border: 0;
            line-height: 1;
            height: auto;
        }

        .form-control--editable:focus {
            background: #ffff66;
            color: #000;
        }
    </style>

    <script type="text/javascript">

        var storageUrl = '{{url('admin/translations/save')}}/';

        $('.js-editable-translation').blur(function (e) {

            var $input = $(e.currentTarget);
            var data = $input.data();

            if (data.value !== $input.val()) {

                var post = {
                    language: {}
                };

                post.language[data.languageId] = $input.val();

                $.post(storageUrl + data.keywordId, post, function (response) {
                    console.log(response);
                });
            }

        }).keyup(function (e) {
            if (e.which == 13) {
                $(e.currentTarget).blur();
            }
        });
    </script>

</div>
