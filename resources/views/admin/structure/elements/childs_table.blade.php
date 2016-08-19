<table class="table table-striped table-condensed table-sortable" data-url="{{url( 'admin/structure/sort/' . $currentItem->id )}}">
    <thead>
    <tr>
        @if (!empty( $sorting ))
            <th>&nbsp;</th>
        @endif
        <th>{{__("Title")}}</th>
        <th class="col-xs-1">{{__("Status")}}</th>
        <th class="col-xs-2">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach ( $childs as $item )
        <tr id="item_{{$item->id}}">
            @if (!empty( $sorting ))
                <td class="sort-column">
                    <a href="#">
                        <span class="fa fa-align-justify"></span>
                    </a>
                </td>
            @endif
            <td>
                <a href="{{url( '/admin/structure/index/' . $item->id )}}" title="{{$item->name}}">{{$item->name}}</a>
            </td>
            <td>
                <a class="label @if ($item->active == 1)label-success @else label-danger @endif " href="{{url( '/admin/structure/active/'. $currentItem->id .'/'. $item->id . '/' . $item->active )}}" title="@if ($item->active == 1) {{__('Hide element')}} @else {{__('Make visible')}} @endif">@if ($item->active == 1)
                        {{__("Visible")}} @else {{__("Hidden")}} @endif </a>
            </td>
            <td class="actions">
                <a href="{{url(  '/admin/structure/index/' . $item->id )}}" title="{{$item->name}}" class="btn btn-xs btn-default edit-row-link">{{__("Edit")}}</a>
                &nbsp;<a href="{{url( '/admin/structure/delete/' . $currentItem->id . '/'. $item->id )}}" class="btn btn-xs btn-default delete-row-link">{{__("Delete")}}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>