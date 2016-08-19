function confirmDelete() {

    return( window.confirm('Ar tikrai norite ištrinti?') );

}

function deleteRow( event )
{

    if ( confirmDelete() ) {

        var element = $( event.currentTarget );

        $('#loader').show();

        $.get( element.attr('href'), function() {
            element.parents('tr').remove();
            $('#loader').hide();
        } );

    }

    return false;
}

$(document).ready(function () {

    $('.table-sortable tbody').sortable({
        handler: '.fa-align-justify',
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                // Set helper cell sizes to match the original sizes
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },
        update: function () {

            var update_url = $(this).parents('table').data('url');

            $.post( update_url, $( this).sortable('serialize'), function( response ) {
//
//                console.log( response );

            } );

        }
    });
//
//    $('.widgets').sortable({
//        handle: '.sort-handle',
//        update: function () {
////
////            console.log(URLS.widget_sort + '&' + $(this).sortable('serialize') + '&zone_id=' + $(this).parent().attr('id').replace(/zone_/, ''));
//
//            $.get(URLS.widget_sort + '&' + $(this).sortable('serialize') + '&zone_id=' + $(this).parent().attr('id').replace(/zone_/, ''), function (response) {
//            });
////
////            console.log($(this).sortable('serialize'));
//
//        }
//
//    });

    $('.zone-add-item').click(function () {

        $(this.hash).toggle();

        return false;
    });

    $('.toggle-link').click(function () {

        var $element = $(this.hash);

        if ($element.hasClass('hidden')) {
            $element.removeClass('hidden');
        } else {
            $element.addClass('hidden');
        }

        $(this).hide();

        return false;

    });

    $('.edit-cancel-link').click(function () {

        $('.edit-link').show();
        $(this.hash).addClass('hidden');

        return false;

    });

    $('.edit-link').click(function () {

        $(this).hide();
        $(this.hash).removeClass('hidden');
        return false;

    });

    $('.cancel-link').click(function () {

        var $element = $(this.hash);
        var $link = $('.' + this.hash.replace(/#/, '') + '-link');

        if ($element.hasClass('hidden')) {
            $element.removeClass('hidden');
            $link.hide();
        } else {
            $element.addClass('hidden');
            $link.show();
        }

        return false;

    });

});