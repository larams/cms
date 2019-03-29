<div>
    <div class="row">
        <div class="col-xs-6">
            <h1>Roles</h1>
        </div>
        <div class="col-xs-6 text-right">
            <a href="{{url('admin/roles/create')}}" class="btn btn-primary pull-right mt20">Add new</a>
        </div>
    </div>
</div>
<table class="table table-condensed table-striped mt20">
    <thead>
    <tr>
        <th>Title</th>
        <th></th>
    </tr>
    </thead>
    @foreach ( $roles as $role )
        <tr>
            <td>
                {{$role->title}}
            </td>
            <td>
                <a class="btn btn-default btn-xs" href="{{url('admin/roles/'.$role->id.'/edit')}}">Edit</a>
                <a class="btn btn-default btn-xs" href="{{url('admin/roles/delete/'.$role->id)}}">Delete</a>
            </td>
        </tr>
    @endforeach
</table>
