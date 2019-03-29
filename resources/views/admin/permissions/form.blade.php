<div class="row">
    <div class="col-xs-9">
        @if ( !empty( $isCreate ) )
            <h2 class="mt20">Create permission </h2>
        @else
            <h2 class="mt20">Edit permission <span style="font-size: 20px;"> ({{$permission->title}})</span></h2>
        @endif

        <form class="form mt20"
              action="@if(empty($permission) && empty($permission->id)) {{url( 'admin/permissions')}} @else {{url( 'admin/permissions/'.$permission->id)}} @endif"
              enctype="multipart/form-data"
              method="POST">
            @if(!empty($permission))
                {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="well">
                <fieldset>
                    {!! BootstrapForm::input( ['name' => 'title', 'value' => !empty( $permission ) ? $permission->title : '', 'title' => 'Title'] ) !!}
                    {!! BootstrapForm::input( ['name' => 'permission', 'value' => !empty( $permission ) ? $permission->permission : '', 'title' => 'Permission'] ) !!}
                </fieldset>
                <fieldset>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button class="btn btn-default" onclick="history.back();return false;">Cancel</button>
                </fieldset>
            </div>
        </form>
    </div>
</div>
