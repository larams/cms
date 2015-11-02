<div class="mt20">
    <h2 class="pull-left">{{__('Content types')}}</h2>
    <a href="{{url('admin/types/add')}}" class="btn btn-primary pull-right">{{__('Add new type')}}</a>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{__('Developer title')}}</th>
            <th>{{__('Administrator title')}}</th>
            <th>{{__('Handler')}}</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $types as $type )
            <tr>
                <td>
                    <a href="{{url('admin/types/edit/' . $type->id )}}" title="{{$type->name}}">{{$type->name}}</a>
                </td>
                <td>{{$type->name_lang}}</td>
                <td>{{$type->handler}}</td>
                <td class="actions">
                    <a href="{{url('admin/types/edit/'. $type->id )}}" title="{{$type->name}}" class="btn btn-xs btn-default">{{__('Edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/types/delete/' . $type->id )}}">{{__('Delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>