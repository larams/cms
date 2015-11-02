<h2 class="pull-left">Vertimai</h2>

<form class="pull-right form-inline" action="{{url(  act='translations.add' )}}" method="post">
    Raktažodis: <input type="text" name="title" class="form-control" value="" />
    <button type="submit" class="btn btn-primary">Sukurti</button>
</form>

<div class="clearfix"></div>


			<table class="table table-striped table-condensed mt20">
			     <thead>
				<tr>
					<th>Raktažodis</th>
					@foreach (from=$languages item="language")
					<th>{{$language.item_name}}</th>
					@endforeach
					<th>&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				@foreach (from=$keywords name="keywords" item="item")
					<tr>
						<td><a href="{{url(  id=$item.keyword act='translations.edit' )}}" title="">{{$item.keyword}}</a></td>
						@foreach (from=$languages item="language")
				        <td>
				            {assign var="values" value=$item.values}
				            {assign var="lang_id" value=$language.item_id}
				            {{$values.$lang_id}}
				        </td>
				        @endforeach
						<td class="actions">
							<a href="{{url(  id=$item.keyword act='translations.edit' )}}" class="btn btn-xs btn-default">redaguoti</a>
							&nbsp;<a onclick="return( confirmDelete() );" class="btn btn-xs btn-danger" href="{{url(  id=$item.keyword act='translations.delete' )}}" title="Trinti elementą">ištrinti</a>
						</td>
					</tr>
				@endforeach
				</tbody>

				{*if $pageCount > 1}
				<tr>
					<th colspan="4">
						<ul class="pages fr">
							@if ($currPage > 1)<li><a href="{{url(  act='registrations' page=$currPage-1 )}}">Ankstesnis</a></li>@endif
							{section name="pages" loop=$pageCount step=1}
							<li><a href="{{url(  act='registrations' page=$smarty.section.pages.iteration )}}">{{$smarty.section.pages.iteration}}</a></li>
							{/section}
							@if ($currPage < $pageCount)<li><a href="{{url(  act='registrations' page=$currPage+1 )}}">Kitas</a></li>@endif
						</ul>
						<div class="clr"></div>
					</th>
				</tr>
				{/if*}
			</table>
