<div class="row">
    <div class="col-xs-3 sidebar">

        <div class="mt20">

            @if ( count( $languages) )
                <ul class="nav nav-pills">
                    @foreach ( $languages as $language )
                        <li @if ( $language->id == $currentLanguage->id ) class="active" @endif>
                            <a href="{{url('admin/structure/index/' . $language->id )}}">{{$language->name}}</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div id="structure-tree" class="mt20">
                <ul></ul>
            </div>
            <script>
                $(function () {
                    $('#structure-tree').jstree({
                        core: {
                            data: {
                                url: '{{url('admin/structure/tree/' . $currentLanguage->id )}}'
                            }
                        },
                        state: {
                            key: 'structure'
                        },
                        types: {
                            'default': {
                                icon: "fa fa-folder text-yellow icon-lg"
                            },
                            file: {
                                icon: "fa fa-file-o icon-lg"
                            }
                        },
                        plugins: ['wholerow', 'state', 'types']
                    }).on('activate_node.jstree', function (e, data) {

                        $('#loader').show();

                        document.location.href = '{{url('admin/structure/index')}}/' + data.node.id;

                    });
                });
            </script>

        </div>

    </div><!--/span-->
    <div class="col-xs-9">

        <div class="mt20">

            @if ( count( $currentPath )  > 1)
                <ul class="breadcrumb">
                    @foreach ( $currentPath as $pathItem )
                        @if ($pathItem->id == $currentItem->id)
                            <li class="active">{{$pathItem->name}}</li>
                        @else
                            <li>
                                @if ($pathItem->level > 2 || !empty( $isDeveloper ))
                                    <a href="{{url( 'admin/structure/index/' . $pathItem->id )}}">{{$pathItem->name}}</a>
                                @else
                                    {{$pathItem->name}}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <h2 class="pull-left">{{$currentItem->name}}</h2>
            @if ( count( $treeChilds ) || count( $extraChilds ) )
                <a class="btn btn-xs btn-primary pull-right edit-link" href="#edit-item"><i class="fa fa-pencil fa-selected"></i>
                    redaguoti</a>
            @endif
            <div class="clearfix"></div>

            <div id="edit-item" @if ( count( $treeChilds ) || count( $extraChilds ) )class="hidden"@endif>
                @if ($currentItem->level > 3 || $isDeveloper)
                    <form class="mt20 form" action="{{url('admin/structure/save/' . $currentItem->id )}}" enctype="multipart/form-data" method="post" name="doing_stuff_with_content">
                        <fieldset>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {!! BootstrapForm::input( ['name' => 'name', 'value' => $currentItem->name, 'title' => __('Title') ] ) !!}
                            {!! BootstrapForm::input( ['name' => 'uri', 'value' => $currentItem->uri, 'title' => __('Link') ] ) !!}

                            @if ( !empty( $isDeveloper ) )
                                {!! BootstrapForm::select( ['name' => 'type_id', 'value' => $currentItem->type_id, 'title' => __('Type'), 'values' => $types, 'option_key' => 'id', 'option_value' => 'name_lang' ]) !!}
                            @endif

                            @if ( !empty( $typeConfiguration['properties'] ) )
                                @foreach ( $typeConfiguration['properties'] as $property )

                                    <div class="form-group">
                                        <label class="control-label" for="{{$property['name']}}">
                                            @if (!empty( $property['title'] ) ) {{__( $property['title'] )}}
                                            @elseif ( $property['name'] == 'date') {{__('Date')}}
                                            @elseif ( $property['name'] == 'text') {{__('Text')}}
                                            @elseif ( $property['name'] == 'image') {{__('Image')}}
                                            @else {{__( $property['name'] )}}
                                            @endif
                                        </label>
                                        <div class="">
                                            {!! $property['html'] !!}
                                        </div>
                                    </div>

                                @endforeach
                            @endif

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                                <a class="btn btn-default edit-cancel-link" href="#edit-item">{{__('Cancel')}}</a>

                            </div>

                        </fieldset>
                    </form>
                @endif
            </div>

            @if ( count( $treeChilds ) )

                @if ( !empty($typeConfiguration['child_tree_items_list_title']) )
                    <h3>{{__($typeConfiguration['child_tree_items_list_title'])}}</h3>
                @endif

                @include('larams::admin.structure.elements.childs_table', ['childs' => $treeChilds ] )

            @endif

            @if ( count( $extraChilds ) )

                @if ( !empty($typeConfiguration['child_items_list_title']) )
                    <h3>{{__($typeConfiguration['child_items_list_title'])}}</h3>
                @endif

                @include('larams::admin.structure.elements.childs_table', ['childs' => $extraChilds ] )

            @endif

            @if ( count( $treeTypes ) )

                @include('larams::admin.structure.elements.childs_form', [ 'types' => $treeTypes, 'title' => !empty( $typeConfiguration['child_tree_item_create_title'] ) ? __($typeConfiguration['child_tree_item_create_title']) : __("Add new tree item") ] )

            @endif

            @if ( count( $extraTypes ) )

                @include('larams::admin.structure.elements.childs_form', [ 'types' => $extraTypes, 'title' => !empty( $typeConfiguration['child_item_create_title'] ) ? __($typeConfiguration['child_item_create_title']) : __("Add new item") ] )

            @endif

        </div>

    </div>
</div>

