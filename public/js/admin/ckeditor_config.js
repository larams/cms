/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{

        config.allowedContent = true;
        config.toolbar = [
            { name: 'document', items: [ 'Source' ] },
            //{ name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'basicstyles',  items: [ 'Bold', 'Italic', 'Underline' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule' ] },
            //{ name: 'styles', items: [ 'Format' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
            //{ name: 'tools', items: [ 'Maximize' ] }
    	];

//    config.toolbar = 'Full';
////    config.skin = 'chris';
//
    config.extraPlugins = 'justify';
//
//
//    config.toolbar_Full =
//    [
//        { name: 'first', items: ['Cut','Copy','Paste','PasteText','PasteFromWord', '-', 'Undo','Redo','-','Link','Unlink','Anchor','-','SelectAll','RemoveFormat', '-', 'Image','Table', '-','Source'] },
//        { name: 'second', items: ['TextColor','Bold','Italic','Underline','Strike','-','Subscript','Superscript', '-', 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'] },
//        { name: 'third', items: ['Format', 'wpmore'] }
//    ];

     //, 'wpmore'

    config.filebrowserBrowseUrl = '/admin/gallery/index/';
    config.filebrowserImageBrowseUrl = '/admin/gallery/index/';

};

/*
FCKConfig.PluginsPath = FCKConfig.BasePath + 'plugins/' ;
FCKConfig.Plugins.Add( 'wpmore' );
FCKConfig.DefaultLanguage		= 'lt' ;

FCKConfig.ProcessHTMLEntities	= true ;
FCKConfig.IncludeLatinEntities	= true ;
FCKConfig.IncludeGreekEntities	= true ;

FCKConfig.ToolbarSets["Default"] = [
	['Cut','Copy','Paste','PasteText','PasteWord', '-', 'Undo','Redo','-','Link','Unlink','Anchor','-','SelectAll','RemoveFormat', '-', 'Image','Table', '-','Source'],
	['TextColor','Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript', '-', 'OrderedList','UnorderedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['FontFormat', 'wpmore']
] ;

FCKConfig.EnterMode = 'p' ;			// p | div | br
FCKConfig.ShiftEnterMode = 'br' ;	// p | div | br

FCKConfig.EnableMoreFontColors = true ;
FCKConfig.FontColors = '000000,993300,333300,003300,003366,000080,333399,333333,800000,FF6600,808000,808080,008080,0000FF,666699,808080,FF0000,FF9900,99CC00,339966,33CCCC,3366FF,800080,999999,FF00FF,FFCC00,FFFF00,00FF00,00FFFF,00CCFF,993366,C0C0C0,FF99CC,FFCC99,FFFF99,CCFFCC,CCFFFF,99CCFF,CC99FF,FFFFFF' ;

FCKConfig.FontFormats	= 'p;h1;h2;h3;h4;h5;h6;pre;address;div' ;
FCKConfig.FontNames		= 'Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana' ;
FCKConfig.FontSizes		= 'smaller;larger;xx-small;x-small;small;medium;large;x-large;xx-large' ;

var _FileBrowserLanguage	= 'php' ;	// asp | aspx | cfm | lasso | perl | php | py
var _QuickUploadLanguage	= 'php' ;	// asp | aspx | cfm | lasso | perl | php | py

// Don't care about the following two lines. It just calculates the correct connector
// extension to use for the default File Browser (Perl uses "cgi").
var _FileBrowserExtension = _FileBrowserLanguage == 'perl' ? 'cgi' : _FileBrowserLanguage ;
var _QuickUploadExtension = _QuickUploadLanguage == 'perl' ? 'cgi' : _QuickUploadLanguage ;

FCKConfig.LinkBrowser = true ;
FCKConfig.LinkBrowserURL = FCKConfig.ImageBrowserURL = FCKConfig.BasePath +  '../../../index.php?act=mediaselect';
//FCKConfig.LinkBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.LinkBrowserWindowWidth	= FCKConfig.ScreenWidth * 0.7 ;		// 70%
FCKConfig.LinkBrowserWindowHeight	= FCKConfig.ScreenHeight * 0.7 ;	// 70%

FCKConfig.ImageBrowser = true ;
FCKConfig.ImageBrowserURL = FCKConfig.BasePath +  '../../../index.php?act=mediaselect';
//FCKConfig.ImageBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Image&Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.ImageBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;	// 70% ;
FCKConfig.ImageBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ;	// 70% ;

FCKConfig.FlashBrowser = true ;
FCKConfig.FlashBrowserURL = FCKConfig.BasePath +  '../../../index.php?act=mediaselect';
//FCKConfig.FlashBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Flash&Connector=' + encodeURIComponent( FCKConfig.BasePath + 'filemanager/connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ) ;
FCKConfig.FlashBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;	//70% ;
FCKConfig.FlashBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ;	//70% ;

FCKConfig.LinkUpload = false ;
FCKConfig.LinkUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension ;
FCKConfig.LinkUploadAllowedExtensions	= ".(7z|aiff|asf|avi|bmp|csv|doc|fla|flv|gif|gz|gzip|jpeg|jpg|mid|mov|mp3|mp4|mpc|mpeg|mpg|ods|odt|pdf|png|ppt|pxd|qt|ram|rar|rm|rmi|rmvb|rtf|sdc|sitd|swf|sxc|sxw|tar|tgz|tif|tiff|txt|vsd|wav|wma|wmv|xls|xml|zip)$" ;			// empty for all
FCKConfig.LinkUploadDeniedExtensions	= "" ;	// empty for no one

FCKConfig.ImageUpload = false ;
FCKConfig.ImageUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension + '?Type=Image' ;
FCKConfig.ImageUploadAllowedExtensions	= ".(jpg|gif|jpeg|png|bmp)$" ;		// empty for all
FCKConfig.ImageUploadDeniedExtensions	= "" ;							// empty for no one

FCKConfig.FlashUpload = false ;
FCKConfig.FlashUploadURL = FCKConfig.BasePath + 'filemanager/connectors/' + _QuickUploadLanguage + '/upload.' + _QuickUploadExtension + '?Type=Flash' ;
FCKConfig.FlashUploadAllowedExtensions	= ".(swf|flv)$" ;		// empty for all
FCKConfig.FlashUploadDeniedExtensions	= "" ;					// empty for no one




*/
