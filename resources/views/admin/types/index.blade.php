<div class="mt20">
    <h2 class="pull-left">{{trans('admin.title.content_types')}}</h2>
    <a href="{{url('admin/types/add')}}" class="btn btn-primary pull-right">{{trans('admin.button.create')}}</a>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{trans('admin.table_heading.developer_title')}}</th>
            <th>{{trans('admin.table_heading.administrator_title')}}</th>
            <th>{{trans('admin.table_heading.handler')}}</th>
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
                    <a href="{{url('admin/types/edit/'. $type->id )}}" title="{{$type->name}}" class="btn btn-xs btn-default">{{trans('admin.button.edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/types/delete/' . $type->id )}}">{{trans('admin.button.delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>