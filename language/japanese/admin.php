<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: admin.php,v 1.1 2006/03/27 14:28:43 mikhail Exp $                   //
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
define('_AM_RMDP_MODIFY', 'Modify');
define('_AM_RMDP_DELETE', 'Deleter');
define('_AM_RMDP_NEWCATEGO', 'New Category');
define('_AM_RMDP_YES', 'Yes');
define('_AM_RMDP_NO', 'No');
define('_AM_RMDP_CATEGOFAIL', 'There was an error:<br>');

/**
 * Declaraciones para la barra de navegación
 */
define('_AM_RMDP_CATEGOS', 'Categories');
define('_AM_RMDP_DOWNLOADS', 'Downloads');
define('_AM_RMDP_CARACTS', 'Characteristics');
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

    define('_AM_RMDP_FPARENT', 'Parant Category:');

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

    define('_AM_RMDP_NEWDOWN', 'New Downloads');

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

    define('_AM_RMDP_FSECURE', 'This file is a Secure Download:');

    define('_AM_RMDP_FSECURE_DESC', 'Activating this option users can not to know the true path of file.');

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

    define('_AM_RMDP_CAROK', 'characteristic created succesfully');

    define('_AM_RMDP_CARMODOK', 'Caracter&iacute;stica modificada correctamente');

    define('_AM_RMDP_DOWNMODOK', 'Descarga Modificada Correctamente');

    define('_AM_RMDP_ERRNOEXIST', 'No existe la descarga especificada');

    define('_AM_RMDP_ERRCARNOEXIST', 'No existe la caracter&iacute;stica especificada');

    define('_AM_RMDP_CONFIRM', '¿Realmente deseas eliminar esta descarga?<br><br>Serán eliminadas todas las pantallas de esta descarga.');

    define('_AM_RMDP_CONFIRMCAR', '¿Realmente deseas eliminar esta caracter&iacute;stica?');

    define('_AM_RMDP_DELOK', 'Descarga eliminada correctamente');

    define('_AM_RMDP_DELCAROK', 'Caracter&iacute;stica eliminada correctamente');

    define('_AM_RMDP_ALLCARS', 'Todas las Caracter&iacute;sticas');

    define('_AM_RMDP_ASSIGNEDCARS', 'Caracter&iacute;sticas asignadas a "%s"');

    define('_AM_RMDP_ADD', 'Asignar');

    define('_AM_RMDP_NEWCAR', 'Nueva Caracter&iacute;stica');

    define('_AM_RMDP_MODCAR', 'Modificar Caracter&iacute;stica');

    define('_AM_RMDP_CARINFO', 'Las im&aacute;genes deben estar localizadas en "modules/rmdp/images/caracts"');

    define('_AM_RMDP_OSALL', 'Plataformas Existentes');

    define('_AM_RMDP_OSASSIGN', 'Plataformas Asignadas');

    define('_AM_RMDP_OSEXIST', 'Esta Plataforma ya ha sido asignada previamente');

    define('_AM_RMDP_LISTNAME', 'Nombre');

    define('_AM_RMDP_LISTACCESS', 'Acceso');

    define('_AM_RMDP_REGISTERED', 'Solo Registrados');

    define('_AM_RMDP_EVERYBODY', 'Todos');

    // Sección para las capturas de pantalla

    define('_AM_RMDP_SHOTLIST', 'Pantallas existentes para "%s"');

    define('_AM_RMDP_SHOTNEW', 'Nueva Pantalla');

    define('_AM_RMDP_SHOTMOD', 'Modificar Pantalla');

    define('_AM_RMDP_SHOTDOWN', 'Descarga:');

    define('_AM_RMDP_SHOTSMALL', 'Im&aacute;gen Peque&ntilde;a:');

    define('_AM_RMDP_SHOTBIG', 'Im&aacute;gen Grande:');

    define('_AM_RMDP_SHOT', 'Im&aacute;gen:');

    define('_AM_RMDP_SHOTDESC', 'Descripci&oacute;n:');

    define('_AM_RMDP_SHOTERRSB', 'Error: Especifica la imágen pequeña y la imágen grande');

    define('_AM_RMDP_SHOTNOEXIST', 'No existe la pantalla especificada');

    define('_AM_RMDP_SHOTCONFIRM', '¿Relamente deseas eliminar esta pantalla?');

    define('_AM_RMDP_SHOTDEL', 'Pantalla eliminada correctamente');

    // Sección de Reviews

    define('_AM_RMDP_REVIEWTITLE', 'Comentarios del Editor');

    define('_AM_RMDP_REVIEW', 'Comentario:');

    define('_AM_RMDP_REVIEWOK', 'Tu comentario ha sido agregado correctamente');
} elseif ('licencias' == $location) {
    define('_AM_RMDP_LICEXISTS', 'Licencias Existentes');

    define('_AM_RMDP_NEWLIC', 'Nueva Licencia');

    define('_AM_RMDP_MODLIC', 'Modificar Licencia');

    define('_AM_RMDP_FNAME', 'Nombre:');

    define('_AM_RMDP_FURL', 'URL para Consulta:');

    define('_AM_RMDP_ERRNAME', 'No has especificado el nombre para esta licencia');

    define('_AM_RMDP_ERREXIST', 'Ya existe una licencia con el mismo nombre');

    define('_AM_RMDP_LICOK', 'Licencia creada correctamente');

    define('_AM_RMDP_LICMODOK', 'Licencia modificada correctamente');

    define('_AM_RMDP_ERRNOEXIST', 'No existe la licencia especificada');

    define('_AM_RMDP_DELOK', 'Licencia eliminada correctamente');

    define('_AM_RMDP_CONFIRM', '¿Realmente deseas eliminar esta licencia?');
} elseif ('plataformas' == $location) {
    define('_AM_RMDP_OSEXISTS', 'Plataformas Existentes');

    define('_AM_RMDP_NEWOS', 'Nueva Plataforma');

    define('_AM_RMDP_FNAME', 'Nombre:');

    define('_AM_RMDP_FIMG', 'URL de la Imágen:');

    define('_AM_RMDP_ERRNAME', 'No especificaste el nombre de la plataforma');

    define('_AM_RMDP_ERREXIST', 'Ya existe una plataforma con el mismo nombre');

    define('_AM_RMDP_OSOK', 'Plataforma creada correctamente');

    define('_AM_RMDP_CONFIRM', '¿Realmente deseas eliminar esta plataforma?');

    define('_AM_RMDP_DELOK', 'Plataforma eliminada correctamente');
} elseif ('sponsor' == $location) {
    define('_AM_RMDP_SPONSORLIST', 'Lista de Descargas Patrocinadas');

    define('_AM_RMDP_SNAME', 'Nombre');

    define('_AM_RMDP_SOPTIONS', 'Opciones');

    define('_AM_RMDP_NEWSPONSOR', 'Nueva Descarga Patrocinada');

    define('_AM_RMDP_FDOWN', 'Seleccionar Descarga:');

    define('_AM_RMDP_FTEXT', 'Texto:');

    define('_AM_RMDP_ERRDOWN', 'Error: No especificaste una descarga');

    define('_AM_RMDP_ERRTEXT', 'Error: No especificaste el texto para esta descarga patrocinada');

    define('_AM_RMDPO_SPONNOEXIST', 'No existe la descarga especificada');

    define('_AM_RMDP_CONFIRM', '¿Realmente deseas eliminar esta descarga patrocinada?');
} elseif ('sended' == $location) {
    define('_RMDP_SENDED_TITLE', 'Descargas Enviadas por Usuarios');

    define('_RMDP_NAME', 'Nombre');

    define('_RMDP_SENDBY', 'Envió');

    define('_RMDP_DATE', 'Fecha');

    define('_AM_RMDP_ERRNOEXIST', 'No existe la descarga especificada');

    define('_AM_RMDP_FNAME', 'Nombre:');

    define('_AM_RMDP_SENDBY', 'Enviado por:');

    define('_AM_RMDP_FVERSION', 'Versi&oacute;n:');

    define('_AM_RMDP_FLICENSE', 'Licencia:');

    define('_AM_RMDP_FFILE', 'Archivo:');

    define('_AM_RMDP_RATING', 'Calificaci&oacute;n:');

    define('_AM_RMDP_FIMG', 'Im&aacute;gen:');

    define('_AM_RMDP_FCATEGO', 'Categor&iacute;a:');

    define('_AM_RMDP_SELECT', 'Seleccionar...');

    define('_AM_RMDP_FLONG', 'Descripci&oacute;n:');

    define('_AM_RMDP_FSIZE', 'Tama&ntilde;o (en bytes):');

    define('_AM_RMDP_FFAVS', 'Agregar a Favoritos:');

    define('_AM_RMDP_FALLOWANONIM', 'Permitir descargas an&oacute;nimas:');

    define('_AM_RMDP_FRESALTE', 'Resaltar:');

    define('_AM_RMDP_FURLTITLE', 'T&iacute;tulo del Web del autor:');

    define('_AM_RMDP_FURL', 'URL del Autor:');

    define('_AM_RMDP_SAVE', 'Guardar');

    define('_AM_RMDP_ACEPT', 'Aceptar Descarga');

    define('_AM_RMDP_ERRNAME', 'No especificaste el nombre de la descarga');

    define('_AM_RMDP_ERREXIST', 'Ya existe una descarga con el mismo nombre');

    define('_AM_RMDP_ERRVERSION', 'Por favor indica la versión del archivo');

    define('_AM_RMDP_ERRVFILE', 'Indica el archivo a descargar');

    define('_AM_RMDP_ERRCATEGO', 'Selecciona una categoría para esta descarga');

    define('_AM_RMDP_SENDOK', 'Descarga aceptada correctamente');

    define('_RMDP_MAIL_SUBJECT', 'Tu descarga ha sido aceptada');

    define('_AM_RMDP_OSS', 'Plataformas:');

    // Mensajes y redirecciones

    define('_AM_RMDP_DELCONFIRM', '¿Realmente deseas eliminar este elemento?');

    define('_AM_RMDP_DELOK', 'Elemento eliminado correctamente');

    // Nuevo en la version 1.3 //

    define('_AM_RMDP_FFILEURL', 'Archivo (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'No es necesario si se indica el campo "Archivo"');

    define('_AM_RMDP_FIMGURL', 'Im&aacute;gen (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'No es necesario si se indica el campo "Imágen"');

    define('_AM_RMDP_MAXSIZE', 'Tamaño máximo: <strong>%s</strong>');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Título %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'URL de Archivo %s:');

    define('_AM_RMDP_FSIZE_DESC', 'Si se ha indicado un archivo local se calcula automáticamente.');

    define('_AM_RMDP_MIRRORS_TITLE', 'Sitios R&eacute;plica (opcionales)');
}


