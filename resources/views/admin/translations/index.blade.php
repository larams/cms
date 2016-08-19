<div class="mt20">
    <h2 class="pull-left">{{__("Translations")}}</h2>
    <form class="pull-right form-inline" action="{{url( 'admin/translations/add' )}}" method="post">
        {!! csrf_field() !!}
        {{__("Keyword")}}: <input type="text" name="title" class="form-control" value=""/>
        <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
    </form>
    <div class="clearfix"></div>


    <table class="table table-striped table-condensed mt20">
        <thead>
        <tr>
            <th>{{__("Keyword")}}</th>
            @foreach ( $languages as $language )
                <th>{{$language->name}}</th>
            @endforeach
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $keywords as $keyword )
            <tr>
                <td><a href="{{url('admin/translations/edit/', [ $keyword->id ] )}}" title="">{{$keyword->keyword}}</a></td>
                @foreach ( $languages as $language )
                    <td>
                        @if (!empty($keyword->lang_value[ $language->id ]))
                            {{$keyword->lang_value[ $language->id ]}}
                        @endif
                    </td>
                @endforeach
                <td class="actions">
                    <a href="{{url( 'admin/translations/edit/', [ $keyword->id ] )}}" class="btn btn-xs btn-default">{{__("Edit")}}</a>
                    &nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url('admin/translations/delete', [ $keyword->id ] )}}" title="Trinti elementą">{{__("Delete")}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>
