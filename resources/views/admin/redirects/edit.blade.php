<div class="mt20">

    <h2>
        @if (empty($item))
            {{trans('admin.title.create_redirect')}}
        @else
            {{trans('admin.title.edit_redirect')}}
        @endif
    </h2>

    <form class="form mt20" action="{{url('admin/redirects/save/' . (!empty($item) ? $item->id : 0) )}}"
          enctype="multipart/form-data"
          method="post">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        <div class="row">
            <div class="col-xs-12 col-sm-8">
                {!! BootstrapForm::input( ['name' => 'from_url', 'value' => !empty( $item ) ? $item->from_url : '', 'title' => trans('admin.field.from_url') ] ) !!}
                <div class="help-block">
                    {{trans('admin.text.from_url_help_text')}}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-8">
                {!! BootstrapForm::input( ['name' => 'to_url', 'value' => !empty( $item ) ? $item->to_url : '', 'title' => trans('admin.field.to_url') ] ) !!}
                <div class="help-block">
                    {{trans('admin.text.to_url_help_text')}}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">{{trans('admin.button.save')}}</button>
                <button class="btn btn-default"
                        onclick="history.back();return false;">{{trans('admin.button.cancel')}}</button>
            </div>
        </div>

        </fieldset>
    </form>
</div>
