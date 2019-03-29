<div>
    <div class="row">
        <div class="col-xs-6">
            <h1>Permissions</h1>
        </div>
        <div class="col-xs-6 text-right">
            <a href="{{url('admin/permissions/create')}}" class="btn btn-primary pull-right mt20">Add new</a>
        </div>
    </div>
</div>
<table class="table table-condensed table-striped mt20">
    <thead>
    <tr>
        <th>Title</th>
        <th>Permission</th>
        <th></th>
    </tr>
    </thead>
    @foreach ( $permissions as $permission )
        <tr>
            <td>
                {{$permission->title}}
            </td> <td>
                {{$permission->permission}}
            </td>
            <td>
                <a class="btn btn-default btn-xs" href="{{url('admin/permissions/'.$permission->id.'/edit')}}">Edit</a>
                <a class="btn btn-default btn-xs" href="{{url('admin/permissions/delete/'.$permission->id)}}">Delete</a>
            </td>
        </tr>
    @endforeach
</table>
