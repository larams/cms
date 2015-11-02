
<h2>Vertimo redagavimas: {{$keyword}}</h2>

<form class="form-horizontal mt20" action="{{url(  act='translations.save' id=$keyword )}}" enctype="multipart/form-data" method="post">
  <fieldset>

    {*bs_input name="keyword" value=$keyword title="Raktažodis"*}

    @foreach (from=$languages item="language")

        {assign var="lang_id" value=$language.item_id}
        {assign var="value" value=$values.$lang_id}

        {bs_input name="value[$lang_id]" value=$value.value title=$language.item_name}


    @endforeach

      <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary">Išsaugoti</button>
              <button class="btn btn-default" onclick="history.back();return false;">Atšaukti</button>
          </div>
      </div>

  </fieldset>
</form>