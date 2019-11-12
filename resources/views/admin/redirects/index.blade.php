<div class="mt20">
    <div class="clearfix">
        <h2 class="pull-left">{{trans('admin.title.redirects')}}</h2>
        <a href="{{url( 'admin/redirects/add' )}}"
           class="btn btn-primary pull-right js-add-redirect">{{trans('admin.button.create')}}</a>
    </div>

    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{trans('admin.field.from_url')}}</th>
            <th>{{trans('admin.field.to_url')}}</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody class="js-translations-list">
        @foreach ( $items as $item )
            <tr>
                <td>
                    <input
                            class="form-control form-control--editable js-editable-translation"
                            type="text"
                            data-id="{{$item->id}}"
                            data-field-id="from_url"
                            data-value="{{$item->from_url}}"
                            value="{{$item->from_url}}"
                    />
                </td>
                <td>
                    <input
                            class="form-control form-control--editable js-editable-translation"
                            type="text"
                            data-id="{{$item->id}}"
                            data-field-id="to_url"
                            data-value="{{$item->to_url}}"
                            value="{{$item->to_url}}"
                    />
                </td>
                <td class="actions" style="min-width: 120px;">
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger"
                             href="{{url('admin/translations/delete', [ $item->id ] )}}"
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

        var storageUrl = '{{url('admin/redirects/save')}}/';

        $('.js-editable-translation').blur(function (e) {

            var $input = $(e.currentTarget);
            var data = $input.data();

            if (data.value !== $input.val()) {

                var post = {};

                post[data.fieldId] = $input.val();

                $.post(storageUrl + data.id, post, function (response) {
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
