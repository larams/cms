<div class="mt20">
    <h2 class="pull-left">{{__('Administrators')}}</h2>
    <a href="{{url('admin/'.$route.'/add')}}" class="btn btn-primary pull-right">{{__('Add new')}}</a>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{__('Email')}}</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Last login time')}}</th>
            <th>{{__('Last login IP')}}</th>
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
                <td>{{$user->logged_at}}</td>
                <td>{{$user->last_ip}}</td>
                <td class="actions">
                    <a href="{{url('admin/'.$route.'/edit/'. $user->id )}}" class="btn btn-xs btn-default">{{__('Edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/'.$route.'/delete/' . $user->id )}}">{{__('Delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>