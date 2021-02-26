<div class="mt20">

    <h2>{{$keyword->keyword}}</h2>

    <form class="form mt20" action="{{route('admin.translations.save', ['id' => $id ] )}}" enctype="multipart/form-data" method="post">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        @foreach ( $languages as $language )

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    {!! BootstrapForm::input( ['name' => 'language['.$language->id.']', 'value' => !empty( $values[ $language->id ] ) ? $values[ $language->id ]->value : '', 'title' => $language->name ] ) !!}
                </div>
            </div>



        @endforeach

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">{{trans('admin.button.save')}}</button>
                <button class="btn btn-default" onclick="history.back();return false;">{{trans('admin.button.cancel')}}</button>
            </div>
        </div>

        </fieldset>
    </form>
</div>
