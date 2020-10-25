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

define('_AM_RMDP_SEND', 'Enviar');
define('_AM_RMDP_CANCEL', 'Cancelar');
define('_AM_RMDP_MODIFY', 'Modificar');
define('_AM_RMDP_DELETE', 'Eliminar');
define('_AM_RMDP_NEWCATEGO', 'Nueva Categor&iacute;a');
define('_AM_RMDP_YES', 'S&iacute;');
define('_AM_RMDP_NO', 'No');
define('_AM_RMDP_CATEGOFAIL', 'Ocurrio el siguiente error:<br>');

/**
 * Declaraciones para la barra de navegación
 */
define('_AM_RMDP_CATEGOS', 'Categor&iacute;as');
define('_AM_RMDP_DOWNLOADS', 'Descargas');
define('_AM_RMDP_CARACTS', 'Caracter&iacute;sticas');
define('_AM_RMDP_DSPONSOR', 'Patrocinadas');
define('_AM_RMDP_OS', 'Plataformas');
define('_AM_RMDP_OPTIONS', 'Opciones');
define('_AM_RMDP_SLICS', 'Licencias');
define('_AM_RMDP_SNSENDED', 'Enviadas');
define('_AM_RMDP_SMODIFIED', 'Modificadas');
define('_AM_RMDP_GOPAGE', 'Página: ');
define('_AM_RMDP_HELP', 'Ayuda');

// NUEVO EN VERSION 1.3
define('_AM_RMDP_ACTUAL', '<span style="font-size: 10px;">Actual: <strong>%s</strong></span>');
define('_AM_RMDP_ERRMOVEFILE', 'Ocurrió un error al intentar cargar el archivo. Por favor verifica que el directorio "%s" tenga permisos de escritura');

if ('indice' == $location) {
    define('_AM_RMDP_ACTUALSTATUS', 'Estado Actual del M&oacute;dulo');

    define('_AM_RMDP_CATEGOS', 'N&uacute;mero de Categor&iacute;as:');

    define('_AM_RMDP_SEE', 'Ver');

    define('_AM_RMDP_DOWNS', 'N&uacute;mero de Descargas:');

    define('_AM_RMDP_SPONSOR', 'Descargas Patrocinadas:');

    define('_AM_RMDP_CARS', 'Caracter&iacute;sticas:');

    define('_AM_RMDP_LICS', 'N&uacute;mero de Licencias:');

    define('_AM_RMDP_OSNUM', 'N&uacute;mero de Plataformas:');

    define('_AM_RMDP_DSEND', 'Descargas Enviadas:');

    define('_AM_RMDP_NSHOTS', 'Capturas de Pantallas:');
} elseif ('categorias' == $location) {
    define('_AM_RMDP_FNAME', 'Nombre:');

    define('_AM_RMDP_FACCESS', 'Acceso:');

    define('_AM_RMDP_REGISTERED', 'Solo Registrados');

    define('_AM_RMDP_EVERYBODY', 'Todos');

    define('_AM_RMDP_FPARENT', 'Categor&iacute;a Padre:');

    define('_AM_RMDP_FIMG', 'Im&aacute;gen:');

    define('_AM_RMDP_FIMGURL', 'Im&aacute;gen (URL):<br><span style="font-size: 10px;">No se necesita si se ha especificado un archivo de imágen.</span>');

    define('_AM_RMDP_SELECT', 'Seleccionar...');

    define('_AM_RMDP_ERRNAME', 'Error: No especificaste el nombre de la categor&iacute;a.');

    define('_AM_RMDP_ERREXIST', 'Error: Ya existe una categoría con el mismo nombre.');

    define('_AM_RMDP_ERRNOEXIST', 'Error: No existe la categoría especificada.');

    define('_AM_RMDP_CATEGOOK', 'Categor&iacute;a creada correctamente');

    define('_AM_RMDP_CATEGOMODOK', 'Categor&iacute;a modificada correctamente');

    define('_AM_RMDP_CATEGOLIST', 'Lista de Categor&iacute;as');

    define('_AM_RMDP_LNAME', 'Nombre');

    define('_AM_RMDP_LACCESS', 'Acceso');

    define('_AM_RMDP_MODCATEGO', 'Modificar Categor&iacute;a');

    define('_AM_RMDP_DELOK', 'Categor&iacute;a eliminada correctamente');

    define('_AM_RMDP_CONFIRM', '¿Realmente deseas eliminar esta categor&iacute;a?');

    define('_AM_RMDP_DOWNSLIST', 'Lista de Descargas en "%s"');

    define('_AM_RMDP_SOFTCARS', 'Caracter&iacute;sticas');

    define('_AM_RMDP_SOFTOS', 'Plataformas');

    define('_AM_RMDP_SOFTSHOTS', 'Pantallas');

    define('_AM_RMDP_NEWDOWN', 'Nueva Descarga');

    define('_AM_RMDP_SHOWNEWS', 'Mostrar novedades en la página principal:');
} elseif ('descargas' == $location) {
    // SIN CAMBIO //

    define('_AM_RMDP_DOWNSLIST', 'Lista de Descargas');

    define('_AM_RMDP_SOFTCARS', 'Caracter&iacute;sticas');

    define('_AM_RMDP_SOFTOS', 'Plataformas');

    define('_AM_RMDP_SOFTSHOTS', 'Pantallas');

    define('_AM_RMDP_NEWDOWN', 'Nueva Descarga');

    define('_AM_RMDP_MODDOWN', 'Modificar Descarga');

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

    // NEW IN VERSION 1.3 //

    define('_AM_RMDP_MIRRORS_TITLE', 'Sitios R&eacute;plica (opcionales)');

    define('_AM_RMDP_FFILEURL', 'Archivo (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'No es necesario si se indica el campo "Archivo"');

    define('_AM_RMDP_FIMGURL', 'Im&aacute;gen (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'No es necesario si se indica el campo "Imágen"');

    define('_AM_RMDP_FSIZE_DESC', 'Si se ha indicado un archivo local se calcula automáticamente.');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Título %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'URL de Archivo %s:');

    define('_AM_RMDP_ERRSIZE', 'El tamaño del archivo es mayor al tamaño permitido');

    define('_AM_RMDP_MAXSIZE', 'Tamaño máximo: <strong>%s</strong>');

    define('_AM_RMDP_OSS', 'Plataformas:');

    // SIN CAMBIOS //

    define('_AM_RMDP_ERRNAME', 'No especificaste el nombre de la descarga');

    define('_AM_RMDP_ERRNAMECAR', 'No especificaste el nombre de la caracter&iacute;stica');

    define('_AM_RMDP_ERRVERSION', 'Por favor indica la versión del archivo');

    define('_AM_RMDP_ERRVFILE', 'Indica el archivo a descargar');

    define('_AM_RMDP_ERRCATEGO', 'Selecciona una categoría para esta descarga');

    define('_AM_RMDP_ERRDESC', 'Debes proporcionar al menos una descripción corta para esta descarga');

    define('_AM_RMDP_ERREXIST', 'Ya existe una descarga con el mismo nombre');

    define('_AM_RMDP_ERRCAREXIST', 'Ya existe una caracter&iacute;stica con el mismo nombre');

    define('_AM_RMDP_DOWNOK', 'Descarga creada correctamente');

    define('_AM_RMDP_CAROK', 'Caracter&iacute;stica creada correctamente');

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


