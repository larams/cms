<div class="mt20">
    <h2 class="pull-left">{{trans('admin.title.translations')}}</h2>
    <form class="pull-right form-inline" action="{{route( 'admin.translations.add' )}}" method="post">
        {!! csrf_field() !!}
        {{trans('admin.text.keyword')}}: <input type="text" name="title" class="form-control" value=""/>
        <button type="submit" class="btn btn-primary">{{trans('admin.button.create')}}</button>
    </form>
    @if (config('larams.admin.translations.enable_xlf_download'))
        <form class="pull-right form-inline"
              style="margin-right: 20px;"
              enctype="multipart/form-data"
              action="{{route('admin.translations.upload')}}"
              method="post">
            {!! csrf_field() !!}
            {{trans('admin.text.upload_keywords_xlf')}}: <input type="file" name="file" class="form-control"/>
            <button type="submit" class="btn btn-primary"><span
                        class="fa fa-upload"></span> {{trans('admin.button.upload')}}</button>
        </form>
    @endif
    <div class="clearfix"></div>

    <div>
        <label>
            <input type="checkbox" class="js-has-missing" name="missing" value="1"/>
            Display only with missing translations
        </label>
    </div>

    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            @foreach ( $languages as $language )
                <th style="width: {{100/count($languages)}}%">
                    {{$language->name}}
                    @if (config('larams.admin.translations.enable_xlf_download'))
                        <a href="{{route('admin.translations.download', ['languageId' => $language->id ] )}}">
                            <span class="fa fa-download"></span>
                        </a>
                    @endif
                </th>
            @endforeach
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody class="js-translations-list">
        @foreach ( $keywords as $keyword )
            <tr @foreach ( $languages as $language ) @if (empty( $values[ $keyword->id ][ $language->id ])) class="has-missing" @endif @endforeach >
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
                    <a href="{{route( 'admin.translations.edit', [ $keyword->id ] )}}"
                       class="btn btn-xs btn-default">{{trans('admin.button.edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger"
                             href="{{route('admin.translations.delete', [ $keyword->id ] )}}"
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

      .form-control--editable[value="missing"] {
        color: #c00;
      }

      .form-control--editable:focus {
        background: #ffff66;
        color: #000;
      }
    </style>

    <script type="text/javascript">

        var storageUrl = '{{route('admin.translations.save', ['id' => 'ID'])}}/';

        $('.js-has-missing').change(function (e) {

            var onlyMissing = $(this).is(':checked');

            if (onlyMissing) {
                $('.js-translations-list tr').hide();
                $('.js-translations-list tr.has-missing').show();
            } else {
                $('.js-translations-list tr').show();
            }

        });

        $('.js-editable-translation').blur(function (e) {

            var $input = $(e.currentTarget);
            var data = $input.data();

            if (data.value !== $input.val()) {

                var post = {
                    language: {}
                };

                post.language[data.languageId] = $input.val();

                $.post(storageUrl.replace(/ID/, data.keywordId), post, function (response) {
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
