<div class="row">
    <div class="col-xs-9">
        @if ( !empty( $isCreate ) )
            <h2 class="mt20">Create role </h2>
        @else
            <h2 class="mt20">Edit role <span style="font-size: 20px;"> ({{$role->title}})</span></h2>
        @endif

        <form class="form mt20"
              action="@if(empty($role) && empty($role->id)) {{url( 'admin/roles')}} @else {{url( 'admin/roles/'.$role->id)}} @endif"
              enctype="multipart/form-data"
              method="POST">
            @if(!empty($role))
                {{ method_field('PUT') }}
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="well">
                <fieldset>

                    {!! BootstrapForm::input( ['name' => 'title', 'value' => !empty( $role ) ? $role->title : '', 'title' => 'Title'] ) !!}

                    @if(!empty($permissions))

                        <div class="form-group">
                            <label class="control-label">Permissions</label>

                            @foreach($permissions as $permission)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               @if(!empty($permissionIds) && in_array($permission->id, $permissionIds)) checked="checked"
                                               @endif
                                               value="{{$permission->id}}"
                                               name="permission_id[]"/>
                                        {{$permission->title}}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    @endif
                </fieldset>
                <fieldset>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button class="btn btn-default" onclick="history.back();return false;">Cancel</button>
                </fieldset>
            </div>
        </form>
    </div>
</div>
