<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: admin.php,v 1.5 23/11/2005 13:47:52 BitC3R0 Exp $                   //
// ------------------------------------------------------------------------ //
// RM+Soft Downloads Plus 1.5                                               //
// Copyright © 2005. Red Mexico Soft                                        //
// <www.redmexico.com.mx>                                                   //
// Modulo XOOPS que permite el control y distribución avanzado de           //
// descargas.                                                               //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful, but      //
// WITHOUT ANY WARRANTY; without even the implied warranty of               //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU         //
// General Public License for more details.                                 //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the                            //
// Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,      //
// MA 02111-1307 USA                                                        //
// ------------------------------------------------------------------------ //
// Questions, Bugs or any comment plese write me                            //
// Preguntas, errores o cualquier comentario escribeme                      //
// <adminone@redmexico.com.mx>                                              //
// ------------------------------------------------------------------------ //
// Visita http://www.xoops-mexico.net para obtener los últimos módulos      //
// de Red México Soft.                                                      //
//                                                                          //
// For more modules from Red México Soft visit http://www.xoops-mexico.net  //
// ------------------------------------------------------------------------ //
//////////////////////////////////////////////////////////////////////////////

global $location;

define('_AM_RMDP_SEND', 'Send');
define('_AM_RMDP_CANCEL', 'Cancel');
define('_AM_RMDP_MODIFY', 'Edit');
define('_AM_RMDP_DELETE', 'Delete');
define('_AM_RMDP_NEWCATEGO', 'New Category');
define('_AM_RMDP_YES', 'Yes');
define('_AM_RMDP_NO', 'No');
define('_AM_RMDP_CATEGOFAIL', 'There was an error:<br>');

/**
 * Declaraciones para la barra de navegación
 */
define('_AM_RMDP_CATEGOS', 'Categories');
define('_AM_RMDP_DOWNLOADS', 'Downloads');
define('_AM_RMDP_DSPONSOR', 'Sponsored');
define('_AM_RMDP_OS', 'Platforms');
define('_AM_RMDP_OPTIONS', 'Options');
define('_AM_RMDP_SLICS', 'Licenses');
define('_AM_RMDP_SNSENDED', 'Received');
define('_AM_RMDP_SMODIFIED', 'Modifications');
define('_AM_RMDP_GOPAGE', 'Page: ');
define('_AM_RMDP_HELP', 'Help');

// NUEVO EN VERSION 1.3
define('_AM_RMDP_ACTUAL', '<span style="font-size: 10px;">Current: <strong>%s</strong></span>');
define('_AM_RMDP_ERRMOVEFILE', 'It happened an error trying to upload the file. Please verify the permissions of the directory "%s".');

if ('indice' == $location) {
    define('_AM_RMDP_ACTUALSTATUS', 'Current State');

    define('_AM_RMDP_CATEGOS', 'Number of Categories:');

    define('_AM_RMDP_SEE', 'See');

    define('_AM_RMDP_DOWNS', 'Number of Downloads:');

    define('_AM_RMDP_SPONSOR', 'Sponsored Downloads:');

    define('_AM_RMDP_CARS', 'Characteristics:');

    define('_AM_RMDP_LICS', 'Number of Licenses:');

    define('_AM_RMDP_OSNUM', 'Number of Platforms:');

    define('_AM_RMDP_DSEND', 'Received Downloads:');

    define('_AM_RMDP_NSHOTS', 'Screenshots:');
} elseif ('categorias' == $location) {
    define('_AM_RMDP_FNAME', 'Name:');

    define('_AM_RMDP_FACCESS', 'Access:');

    define('_AM_RMDP_REGISTERED', 'Registered Only');

    define('_AM_RMDP_EVERYBODY', 'All');

    define('_AM_RMDP_FPARENT', 'Parent Category:');

    define('_AM_RMDP_FIMG', 'Image:');

    define('_AM_RMDP_FIMGURL', 'Image(URL):<br><span style="font-size: 10px;">It is not needed if an image file has been specified.</span>');

    define('_AM_RMDP_SELECT', 'Select...');

    define('_AM_RMDP_ERRNAME', 'Error: You did not specify the name of the category.');

    define('_AM_RMDP_ERREXIST', 'Error: A category with the same name already exists.');

    define('_AM_RMDP_ERRNOEXIST', 'Error: The specified category does not exist.');

    define('_AM_RMDP_CATEGOOK', 'Category created succescfully');

    define('_AM_RMDP_CATEGOMODOK', 'Category modified successfully');

    define('_AM_RMDP_CATEGOLIST', "Categories' List");

    define('_AM_RMDP_LNAME', 'Name');

    define('_AM_RMDP_LACCESS', 'Access');

    define('_AM_RMDP_MODCATEGO', 'Edit Category');

    define('_AM_RMDP_DELOK', 'The Category was eliminated successfully');

    define('_AM_RMDP_CONFIRM', '¿Do you really wanto to eliminate this category?');

    define('_AM_RMDP_DOWNSLIST', 'Downloads List in "%s"');

    define('_AM_RMDP_SOFTCARS', 'Characteristics');

    define('_AM_RMDP_SOFTOS', 'Platforms');

    define('_AM_RMDP_SOFTSHOTS', 'Screenshots');

    define('_AM_RMDP_NEWDOWN', 'New Download');

    define('_AM_RMDP_SHOWNEWS', 'Show news in top page of the módule:');
} elseif ('descargas' == $location) {
    // SIN CAMBIO //

    define('_AM_RMDP_DOWNSLIST', 'Downloads List');

    define('_AM_RMDP_SOFTCARS', 'Characteristics');

    define('_AM_RMDP_SOFTOS', 'Platforms');

    define('_AM_RMDP_SOFTSHOTS', 'Screenshots');

    define('_AM_RMDP_NEWDOWN', 'New Download');

    define('_AM_RMDP_MODDOWN', 'Edit Download');

    define('_AM_RMDP_FNAME', 'Name:');

    define('_AM_RMDP_SENDBY', 'Send by:');

    define('_AM_RMDP_FVERSION', 'Version:');

    define('_AM_RMDP_FLICENSE', 'License:');

    define('_AM_RMDP_FFILE', 'File:');

    define('_AM_RMDP_RATING', 'Rate:');

    define('_AM_RMDP_FIMG', 'Image:');

    define('_AM_RMDP_FCATEGO', 'Category:');

    define('_AM_RMDP_SELECT', 'Select...');

    define('_AM_RMDP_FLONG', 'Description:');

    define('_AM_RMDP_FSIZE', 'Size (in bytes):');

    define('_AM_RMDP_FFAVS', 'Add to Favorites:');

    define('_AM_RMDP_FALLOWANONIM', 'Allow anonymous downloads:');

    define('_AM_RMDP_FRESALTE', 'Stand out:');

    define('_AM_RMDP_FURLTITLE', 'Submitter Homepage Title:');

    define('_AM_RMDP_FURL', 'Submitter Homepage URL:');

    // NEW IN VERSION 1.3 //

    define('_AM_RMDP_MIRRORS_TITLE', 'Mirrors (optional)');

    define('_AM_RMDP_FFILEURL', 'File (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'It is not needed if a file has been specified');

    define('_AM_RMDP_FIMGURL', 'Image (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'It is not needed if an image file has been specified');

    define('_AM_RMDP_FSIZE_DESC', 'If a local file has been indicated it calculates automatically.');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Title %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'File URL %s:');

    define('_AM_RMDP_ERRSIZE', 'The current file size exceed the allowed file size');

    define('_AM_RMDP_MAXSIZE', 'Max Size: <strong>%s</strong>');

    define('_AM_RMDP_OSS', 'Platforms:');

    // SIN CAMBIOS //

    define('_AM_RMDP_ERRNAME', 'The downloads name is missing');

    define('_AM_RMDP_ERRNAMECAR', 'The characteristic name is missing');

    define('_AM_RMDP_ERRVERSION', 'Please specify the file versión');

    define('_AM_RMDP_ERRVFILE', 'Please specify the file to download');

    define('_AM_RMDP_ERRCATEGO', 'Select a category for this download');

    define('_AM_RMDP_ERRDESC', 'Please write a short description for this download');

    define('_AM_RMDP_ERREXIST', 'A download with de same name already exists');

    define('_AM_RMDP_ERRCAREXIST', 'A characteristic whith the same name already exists');

    define('_AM_RMDP_DOWNOK', 'Download created successfully');

    define('_AM_RMDP_DOWNMODOK', 'Download modified successfully');

    define('_AM_RMDP_ERRNOEXIST', 'The specified download does not exits');

    define('_AM_RMDP_CONFIRM', '¿Do you really want to eliminate this download?<br><br>Also will be deleted all screenshots.');

    define('_AM_RMDP_DELOK', 'Download deleted successfully');

    define('_AM_RMDP_OSALL', 'Existing Platforms');

    define('_AM_RMDP_OSASSIGN', 'Assigned Platforms');

    define('_AM_RMDP_LISTNAME', 'Name');

    define('_AM_RMDP_LISTACCESS', 'Access');

    define('_AM_RMDP_REGISTERED', 'Registered Only');

    define('_AM_RMDP_EVERYBODY', 'All');

    // Sección para las capturas de pantalla

    define('_AM_RMDP_SHOTLIST', 'Screen shots for "%s"');

    define('_AM_RMDP_SHOTNEW', 'New ScreenShot');

    define('_AM_RMDP_SHOTMOD', 'Edit Screenshot');

    define('_AM_RMDP_SHOTDOWN', 'Download:');

    define('_AM_RMDP_SHOTSMALL', 'Small Image:');

    define('_AM_RMDP_SHOTBIG', 'Normal Image:');

    define('_AM_RMDP_SHOT', 'Image:');

    define('_AM_RMDP_SHOTDESC', 'Description:');

    define('_AM_RMDP_SHOTERRSB', 'Error: Please specify the small and normal images');

    define('_AM_RMDP_SHOTNOEXIST', 'The specified screenshot does not exists');

    define('_AM_RMDP_SHOTCONFIRM', '¿do you really want to eliminate this screenshot?');

    define('_AM_RMDP_SHOTDEL', 'Screenshot deleted succesfully');

    // Sección de Reviews

    define('_AM_RMDP_REVIEWTITLE', 'Editor Review');

    define('_AM_RMDP_REVIEW', 'Reviews:');

    define('_AM_RMDP_REVIEWOK', 'Your review has been sent successfully');
} elseif ('licencias' == $location) {
    define('_AM_RMDP_LICEXISTS', 'Existing Licenses');

    define('_AM_RMDP_NEWLIC', 'New License');

    define('_AM_RMDP_MODLIC', 'Edit License');

    define('_AM_RMDP_FNAME', 'Name:');

    define('_AM_RMDP_FURL', 'Reading URL:');

    define('_AM_RMDP_ERRNAME', 'The license name is missing');

    define('_AM_RMDP_ERREXIST', 'A license with the same name already exists');

    define('_AM_RMDP_LICOK', 'License created successfully');

    define('_AM_RMDP_LICMODOK', 'License modified succesfully');

    define('_AM_RMDP_ERRNOEXIST', 'The specified license does not exists');

    define('_AM_RMDP_DELOK', 'License deleted succesfully');

    define('_AM_RMDP_CONFIRM', '¿Do you really wanto to delete this license?');
} elseif ('plataformas' == $location) {
    define('_AM_RMDP_OSEXISTS', 'Existing Platforms');

    define('_AM_RMDP_NEWOS', 'New Platform');

    define('_AM_RMDP_FNAME', 'Name:');

    define('_AM_RMDP_FIMG', 'Image URL:');

    define('_AM_RMDP_ERRNAME', 'The platform name is missing');

    define('_AM_RMDP_ERREXIST', 'A platform with the same name already exists');

    define('_AM_RMDP_OSOK', 'Platform creted successfully');

    define('_AM_RMDP_CONFIRM', '¿Do you really want to delete this platform?');

    define('_AM_RMDP_DELOK', 'Platform deleted successfully');
} elseif ('sponsor' == $location) {
    define('_AM_RMDP_SPONSORLIST', 'Sponsored List');

    define('_AM_RMDP_SNAME', 'Name');

    define('_AM_RMDP_SOPTIONS', 'options');

    define('_AM_RMDP_NEWSPONSOR', 'New Sponsored Download');

    define('_AM_RMDP_FDOWN', 'Select a download:');

    define('_AM_RMDP_FTEXT', 'Text:');

    define('_AM_RMDP_ERRDOWN', 'Error: Download is missing');

    define('_AM_RMDP_ERRTEXT', 'Error: The sponsored download text is missing');

    define('_AM_RMDPO_SPONNOEXIST', 'The specified download does not exists');

    define('_AM_RMDP_CONFIRM', '¿Do you really want to delete this sponsored download?');
} elseif ('sended' == $location) {
    define('_RMDP_SENDED_TITLE', 'Downloads sent by Users');

    define('_RMDP_NAME', 'Name');

    define('_RMDP_SENDBY', 'Sent by');

    define('_RMDP_DATE', 'Date');

    define('_AM_RMDP_ERRNOEXIST', 'The download specifies does not exists');

    define('_AM_RMDP_FNAME', 'Name:');

    define('_AM_RMDP_SENDBY', 'Sent by:');

    define('_AM_RMDP_FVERSION', 'Version:');

    define('_AM_RMDP_FLICENSE', 'License:');

    define('_AM_RMDP_FFILE', 'File:');

    define('_AM_RMDP_RATING', 'Rate:');

    define('_AM_RMDP_FIMG', 'Image:');

    define('_AM_RMDP_FCATEGO', 'Category:');

    define('_AM_RMDP_SELECT', 'Select...');

    define('_AM_RMDP_FLONG', 'Description:');

    define('_AM_RMDP_FSIZE', 'Size (in bytes):');

    define('_AM_RMDP_FFAVS', 'Add to Favorites:');

    define('_AM_RMDP_FALLOWANONIM', 'Allow anonymous downloads:');

    define('_AM_RMDP_FRESALTE', 'Stand out:');

    define('_AM_RMDP_FURLTITLE', 'Submitter Homepage Title:');

    define('_AM_RMDP_FURL', 'Submitter Homepage URL:');

    define('_AM_RMDP_SAVE', 'Save');

    define('_AM_RMDP_ACEPT', 'Approve Download');

    define('_AM_RMDP_ERRNAME', 'The download name is missing');

    define('_AM_RMDP_ERREXIST', 'A download with the same name already exists in the same category');

    define('_AM_RMDP_ERRVERSION', 'Please, specify the file version');

    define('_AM_RMDP_ERRVFILE', 'Please, specify the download file');

    define('_AM_RMDP_ERRCATEGO', 'Please, select a acategory for this download');

    define('_AM_RMDP_SENDOK', 'Download approved successfully');

    define('_RMDP_MAIL_SUBJECT', 'Your download has been approved');

    define('_AM_RMDP_OSS', 'Platforms:');

    // Mensajes y redirecciones

    define('_AM_RMDP_DELCONFIRM', '¿do you really want to delete this element?');

    define('_AM_RMDP_DELOK', 'Element deleted successfully');

    // Nuevo en la version 1.3 //

    define('_AM_RMDP_FFILEURL', 'File (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'It is not needed if a file has been specified');

    define('_AM_RMDP_FIMGURL', 'Image (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'It is not needed if an image file has been specified');

    define('_AM_RMDP_MAXSIZE', 'Max Size: <strong>%s</strong>');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Title %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'File URL %s:');

    define('_AM_RMDP_FSIZE_DESC', 'If a local file has been indicated it calculates automatically.');

    define('_AM_RMDP_MIRRORS_TITLE', 'Mirrors (optional)');
}


