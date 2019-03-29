<div class="mt20">
    <h2 class="pull-left">{{trans('admin.title.administrator.list')}}</h2>
    <a href="{{url('admin/'.$route.'/add')}}" class="btn btn-primary pull-right">{{trans('admin.button.create')}}</a>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{trans('admin.table_heading.email')}}</th>
            <th>{{trans('admin.table_heading.name')}}</th>
            <th>{{trans('admin.table_heading.type')}}</th>
            <th>{{trans('admin.table_heading.last_logged_at')}}</th>
            <th>{{trans('admin.table_heading.last_logged_ip')}}</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $users as $user )
            <tr>
                <td>
                    <a href="{{url('admin/'.$route.'/edit/' . $user->id )}}" title="{{$user->email}}">{{$user->email}}</a>
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->role->title}}</td>
                <td>{{$user->logged_at}}</td>
                <td>{{$user->last_ip}}</td>
                <td class="actions">
                    <a href="{{url('admin/'.$route.'/edit/'. $user->id )}}" class="btn btn-xs btn-default">{{trans('admin.button.edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/'.$route.'/delete/' . $user->id )}}">{{trans('admin.button.delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>
