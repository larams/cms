@if ( !empty( $isCreate ) )
    <h2 class="mt20">{{trans('admin.title.administrator.create_new')}}</h2>
@else
    <h2 class="mt20">{{trans('admin.title.administrator.edit')}}</h2>
@endif

@if (!empty($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form mt20" action="{{url( 'admin/'.$route.'/save', [ !empty( $item->id ) ? $item->id : '' ] )}}"
      enctype="multipart/form-data" method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <fieldset>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                {!! BootstrapForm::input( ['name' => 'name', 'value' => !empty( $item ) ? $item->name : '', 'title' => trans('admin.field.name')] ) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                {!! BootstrapForm::input( ['name' => 'email', 'value' => !empty( $item ) ? $item->email : '', 'title' => trans('admin.field.email')] ) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                {!! BootstrapForm::input( ['name' => 'password', 'class' => 'js-password', 'type' => 'password', 'title' => !empty( $isCreate ) ? trans('admin.field.password') : trans('admin.field.new_password')] ) !!}
            </div>
            <div class="col-xs-12 col-sm-3">
                {!! BootstrapForm::input( ['name' => 'password2', 'class' => 'js-password-confirm', 'type' => 'password', 'title' => trans('admin.field.repeat_password') ] ) !!}
            </div>
            <div class="col-xs-12 col-sm-1">
                <label class="control-label">&nbsp;</label>
                <a class="btn btn-default js-generate-password">{{trans('admin.button.generate_random_password')}}</a>
            </div>
        </div>

        @if ( $user->isAllowed('admin.administrators.change_role') )
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    {!! BootstrapForm::select( [
                        'name' => 'role_id',
                        'title' => trans('admin.field.role'),
                        'values' => $roles,
                        'option_key' => 'id',
                        'option_value' => 'title',
                        'value' => !empty( $item ) ? $item->role_id : null
                       ] ) !!}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" name="save" class="btn btn-primary">{{trans('admin.button.save')}}</button>
                <button type="submit" name="send" class="btn btn-secondary">{{trans('admin.button.save_send')}}</button>
                <button class="btn btn-default"
                        onclick="history.back();return false;">{{trans('admin.button.cancel')}}</button>
            </div>
        </div>

    </fieldset>
</form>
