/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function (config) {

    config.allowedContent = true;
    config.forcePasteAsPlainText = true;
    config.toolbar = [
        {name: 'document', items: ['Source']},
        //{ name: 'clipboard', items: [ 'Undo', 'Redo' ] },
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline']},
        {
            name: 'paragraph',
            items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        },
        {name: 'links', items: ['Link', 'Unlink']},
        {name: 'insert', items: ['Image', 'Table', 'HorizontalRule']},
        {name: 'styles', items: ['Format']},
        {name: 'colors', items: ['TextColor', 'BGColor']}
        //{ name: 'tools', items: [ 'Maximize' ] }
    ];

    config.extraPlugins = 'justify';

    var path = document.location.pathname.replace(/admin(.*?)$/, '');

    config.filebrowserBrowseUrl = path + 'admin/gallery/index';
    config.filebrowserImageBrowseUrl = path + 'admin/gallery/index';

};
