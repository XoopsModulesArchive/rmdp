<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: modinfo.php,v 1.5 23/11/2005 13:48:15 BitC3R0 Exp $                 //
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
define('_MI_RMDP_NAME', 'RMSoft Downloads Plus 1.5');
define('_MI_RMDP_DESC', 'Modulo para la administraci&oacute;n avanzada de software');

/**
 * Menus del administrador
 */
define('_MI_RMDP_AM1', 'Categor&iacute;as Existentes');
define('_MI_RMDP_AM2', 'Nueva Categor&iacute;a');
define('_MI_RMDP_AM3', 'Descargas Existentes');
define('_MI_RMDP_AM4', 'Nueva Descarga');
define('_MI_RMDP_AM5', 'Descargas Patrocinadas');
define('_MI_RMDP_AM6', 'Nueva Compa&ntilde;&iacute;a');
define('_MI_RMDP_AM8', 'Plataformas');
define('_MI_RMDP_AM9', 'Licencias');
define('_MI_RMDP_AM10', 'Descargas Enviadas');
define('_MI_RMDP_AM11', 'Modificaciones');

/**
 * SubMenu
 */
define('_MI_SEND_DOWNLOAD', 'Enviar');
define('_MI_SENDED_DOWNS', 'Mis Descargas');

/**
 * Opciones de Configuraci&oacute;n
 */
define('_MI_RMDP_MODTITLE', 'T&iacute;tulo del M&oacute;dulo:');
define('_MI_RMDP_CATGOIMGW', 'Tama&ntilde;o de las im&aacute;genes de categor&iacute;as:');
define('_MI_RMDP_SHOWCATIMG', 'Mostrar imágenes de las categorías');
define('_MI_RMDP_DOWNIMGW', 'Tama&ntilde;o de las im&aacute;genes de descargas:');
define('_MI_RMDP_SHOTIMGW', 'Tama&ntilde;o de las im&aacute;genes peque&ntilde;as de pantallas:');
define('_MI_RMDP_SHOTIMGBIGW', 'Tama&ntilde;o de las im&aacute;genes grandes de pantallas:');
define('_MI_RMDP_SHOTIMGBIGD', '&Uacute;til solo cuando no se vincula directamente a las im&aacute;genes');
define('_MI_RMDP_SHOTLINK', 'Vincular pantallas directamente a las im&aacute;genes:');
define('_MI_RMDP_CATEGODAYSNEW', 'D&iacute;as para mostrar una categor&iacute;a como nueva:');
define('_MI_RMDP_CARACTDAYSNEW', 'D&iacute;as para mostrar una carcter&iacute;stica como nueva:');
define('_MI_RMDP_SHOTDAYSNEW', 'D&iacute;as para mostrar una pantalla como nueva:');
define('_MI_RMDP_SENDDOWN', 'Activar el env&iacute;o de descargas:');
define('_MI_RMDP_SENDANONIMO', 'Usuarios an&oacute;nimos pueden enviar descargas:');
define('_MI_RMDP_CATWITHNEWS', 'Número de Categor&iacute;as con novedades en la p&aacute;gina principal:');
define('_MI_RMDP_SPONSORNUM', 'Número de descargas patrocinadas a mostrar:');
define('_MI_RMDP_FAVORITESNUM', 'Número de descargas a mostrar en Favoritos:');
define('_MI_RMDP_POPULARNUM', 'Número de descargas a mostrar en Populares:');
define('_MI_RMDP_LENDESC', 'Longitud en car&aacute;cteres de la descripci&oacute;n<br>de descargas patrocinadas:');
define('_MI_RMDP_SHOTLIMIT', 'Limite de pantallas por descarga:');
define('_MI_RMDP_SUBCATLIMIT', 'Número de subcategor&iacute;as para mostrar:');
define('_MI_RMDP_RESALTEBG', 'Color de Fondo para descargas resaltadas (HEX):');
define('_MI_RMDP_LIMITRESULT', 'L&iacute;mite de resultados por p&aacute;gina:');
define('_MI_RMDP_UPDATEDAYS', 'D&iacute;as para considerar un elemento como actualizado:');
define('_MI_RMDP_DOWNNEW', 'D&iacute;as para considerar una descarga como nueva:');
define('_MI_RMDP_DATEFORMAT', 'Formato de Fecha:');
define('_MI_RMDP_POPULARNEEDS', 'Descargas para considerar como popular<br>un elemento:');
define('_MI_RMDP_USERVOTE', 'Permitir votos de usuarios an&oacute;nimos');
define('_MI_RMDP_OPENWINDOW', 'Comportamiento de descargas:');
define('_MI_RMDP_OPENSAME', 'Abrir en la misma ventana');
define('_MI_RMDP_OPENNEW', 'Abrir en otra ventana');
define('_MI_RMDP_SHOTCOLS', 'Número de columnas para tablas de pantallas:');
define('_MI_RMDP_TOPPOP', 'Número de descargas populares a mostrar');
define('_MI_RMDP_TOPFAV', 'Número de descargas favoritas a mostrar');
define('_MI_RMDP_TOPRATE', 'Número de descargas mejor valoradas a mostrar');
define('_MI_RMDP_SENDMAIL', 'Notificar por email cuando se envia una descarga');
define('_MI_RMDP_BODYMAIL', 'Contenido del email de aceptación de descargas:');
define('_MI_RMDP_BORKENINFO', 'Texto informativo para usuarios que desean reportar una descarga errónea');

// Bloques
define('_MI_RMDP_RECENT_TITLE', 'Descargas Recientes');
define('_MI_RMDP_POPULARTITLE', 'Top Descargas');
define('_MI_RMDP_UPDATETITLE', 'Descargas Actualizadas');
define('_MI_RMDP_RATEDTITLE', 'Mejor Valoradas');
define('_MI_RMDP_LASTDOWN', 'Nueva Descarga');

////////////////////////////////////////////
// NUEVOS O MODIFICADOS EN LA VERSIÓN 1.3 //
////////////////////////////////////////////
define('_MI_RMDP_BANNERS', 'Activar banners en el módulo:');
define('_MI_RMDP_BANNERS_CODE', 'Código para mostrar banners:');
define('_MI_RMDP_CONFIGCAT_IMGS', 'Configuración de Im&aacute;genes');
define('_MI_RMDP_CONFIGCAT_DOWNS', 'Configuración de Descargas');
define('_MI_RMDP_SENDFILES', 'Activar carga de archivos:');
define('_MI_RMDP_SENDFILE_DESC', '<span style="font-size: 10px;">Al activar esta opción los usuarios podrán subir los archivos directamente al servidor</span>');
define('_MI_RMDP_SENDIMG', 'Activar carga de imágenes:');
define('_MI_RMDP_SENDIMG_DESC', 'Al activar esta opción los usuarios podrán subir sus imágenes directamente al servidor');
define('_MI_RMDP_SHOTLINK_DESC', '<span style="font-size: 10px;">Si se activa los usuarios serán enviados directamente al archivo de imágen cuando den click en una pantalla. De lo contrario las imágenes se cargan en una página del módulo.</span>');
define('_MI_RMDP_SOFTDIR', 'Directorio para carga de Software:');
define('_MI_RMDP_SOFTDIR_DESC', '<span style="font-size: 10px;">Indica la ruta del directorio donde se almacenarán los archivos enviados por los usuarios. Este directorio debe existir en el servidor.<br>Tags útiles:<br>{XOOPS_PATH} = Ruta de XOOPS<br>{RMDP_PATH} = Ruta del módulo</span>');
define('_MI_RMDP_MIRRORSNUM', 'Número máximo de sitios réplica:');
define('_MI_RMDP_MIRRORSNUM_DESC', '<span style="font-size: 10px;">Número de sitios réplica para una descarga o bien, número de formatos diferentes de archivos para una descarga.</span>');
define('_MI_RMDP_FILESIZE', 'Tama&ntilde;o máximo del archivo a subir:');
define('_MI_RMDP_SIZEUNIT', 'Unidad de conversión para el tam&ntilde;o de Archivo:');
define('_AM_RMDP_EDITOR', 'Tipo de Editor para las descripciones:');
define('_MI_RMDP_FORM_COMPACT', 'Compacto');
define('_MI_RMDP_FORM_DHTML', 'DHTML');
define('_MI_RMDP_FORM_SPAW', 'Editor Spaw');
define('_MI_RMDP_FORM_HTMLAREA', 'Editor HtmlArea');
define('_MI_RMDP_FORM_FCK', 'Editor FCK');
define('_MI_RMDP_FORM_KOIVI', 'Editor Koivi');
define('_MI_RMDP_FILETYPES', 'Tipos de archivo aceptados:');
define('_MI_RMDP_FILETYPES_DESC', "Separar con '|' las extensiones (.zip|.tar|etc)");
define('_MI_RMDP_RETARDO', 'Tiempo de retardo para inciar una descarga:');
define('_MI_RMDP_RETARDO_DESC', 'Especificar en segundos.');
define('_MI_RMDP_BODYMAIL_DESC', '<span style="font-size: 10px;">Etiquetas útiles:<br>{USER} = Nombre del Usuario.<br>{DOWN} = Nombre de la descarga.<br>{LINK} = Vínculo a la descarga.<br>{URL} = URL del sitio.</span>');


