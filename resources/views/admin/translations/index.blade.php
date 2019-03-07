<div class="mt20">
    <h2 class="pull-left">{{trans('admin.title.translations')}}</h2>
    <form class="pull-right form-inline" action="{{url( 'admin/translations/add' )}}" method="post">
        {!! csrf_field() !!}
        {{trans('admin.text.keyword')}}: <input type="text" name="title" class="form-control" value=""/>
        <button type="submit" class="btn btn-primary">{{trans('admin.button.create')}}</button>
    </form>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{trans('admin.table_heading.keyword')}}</th>
            @foreach ( $languages as $language )
                <th>{{$language->name}}</th>
            @endforeach
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $keywords as $keyword )
            <tr>
                <td><a href="{{url('admin/translations/edit', [ $keyword->id ] )}}" title="">{{$keyword->keyword}}</a></td>
                @foreach ( $languages as $language )
                    <td>
                        @foreach($keyword->values as $value)
                            @if($value->language_id == $language->id)
                                {{$value->value}}
                            @endif
                        @endforeach
                    </td>
                @endforeach
                <td class="actions">
                    <a href="{{url( 'admin/translations/edit', [ $keyword->id ] )}}" class="btn btn-xs btn-default">{{trans('admin.button.edit')}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/translations/delete', [ $keyword->id ] )}}" title="Trinti elementą">{{trans('admin.button.delete')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>
