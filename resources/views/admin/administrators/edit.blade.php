@if ( !empty( $isCreate ) )
    <h2 class="mt20">{{__('Create New administrator')}}</h2>
@else
    <h2 class="mt20">{{__('Edit administrator')}}</h2>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form mt20" action="{{url( 'admin/'.$route.'/save', [ !empty( $item->id ) ? $item->id : '' ] )}}" enctype="multipart/form-data" method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <fieldset>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                {!! BootstrapForm::input( ['name' => 'name', 'value' => !empty( $item ) ? $item->name : '', 'title' => __('Name')] ) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                {!! BootstrapForm::input( ['name' => 'email', 'value' => !empty( $item ) ? $item->email : '', 'title' => __('Email')] ) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                {!! BootstrapForm::input( ['name' => 'password', 'class' => 'js-password', 'type' => 'password', 'title' => !empty( $isCreate ) ? __('Password') : __('New password')] ) !!}
            </div>
            <div class="col-xs-12 col-sm-3">
                {!! BootstrapForm::input( ['name' => 'password2', 'class' => 'js-password-confirm', 'type' => 'password', 'title' => __('Repeat password') ] ) !!}
            </div>
            <div class="col-xs-12 col-sm-1">
                <label class="control-label">&nbsp;</label>
                <a class="btn btn-default js-generate-password">{{__("Generate random password")}}</a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                {!! BootstrapForm::select( ['name' => 'type', 'title' => __('Type'), 'values' => $types, 'value' => !empty( $item ) ? $item->type : null ] ) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" name="save" class="btn btn-primary">{{__('Save')}}</button>
                <button type="submit" name="send" class="btn btn-secondary">{{__('Save & Send')}}</button>
                <button class="btn btn-default" onclick="history.back();return false;">{{__('Cancel')}}</button>
            </div>
        </div>

    </fieldset>
</form>