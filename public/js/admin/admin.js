function confirmDelete() {
    return (window.confirm('Ar tikrai norite ištrinti?'));
}

function generatePassword() {
    var length = 15,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

$(document).ready(function () {

    $('.js-generate-password').click(function () {

        var pass = generatePassword();

        $('.js-password').val(pass).attr('type', 'text');
        $('.js-password-confirm').val(pass).attr('type', 'text');
        return false;

    });

    $('.js-password, .js-password-confirm').focus(function () {
        $('.js-password, .js-password-confirm').attr('type', 'password');
    });

    $('.delete-row-link').click(function (e) {
        if (confirmDelete()) {
            var element = $(e.currentTarget);
            $('#loader').show();
            $.get(element.attr('href'), function () {
                var table = element.parents('tbody');
                element.parents('tr').remove();
                if (table.find('tr').length == 0) {
                    table.parents('table').remove();
                }

                $('#loader').hide();
            });
        }
        return false;
    });

    $('.edit-row-link').click(function () {
        $('#loader').show();
    });

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

            $.post(update_url, $(this).sortable('serialize'), function (response) {
//
//                console.log( response );

            });

        }
    });

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

    var dropped = false;

    $('#gallerySortable').sortable({
        placeholder: "dz-preview dz-image-preview dz-placeholder",
        connectWith: '.dz-folder-preview',
        stop: function (event, ui) {

            if (!dropped) {

                var update_url = $(this).data('url');

                $.post(update_url, $(this).sortable('serialize'), function (response) {
                });

            }

            dropped = false;

        }
    });

    if (window.allowFolderMoving) {
        $('#gallerySortable .dz-folder-preview').droppable({
            accept: '#gallerySortable li',
            drop: function (ev, ui) {

                dropped = true;

                var move_url = $(this).parent().data('move-url');

                $('#loader').show();

                $.post(move_url, {
                    position: 1,
                    parent_id: $(this).data('id'),
                    id: ui.draggable.data('id')
                }, function () {
                    ui.draggable.remove();
                    $('#loader').hide();
                });

            }
        });
    }

});

Dropzone.options.galleryDropzone = {

    queuecomplete: function () {
        $('#loader').show();
        document.location.reload();
    }
};
