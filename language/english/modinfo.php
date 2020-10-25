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
define('_MI_RMDP_NAME', 'RMSOFT Downloads Plus 1.5');
define('_MI_RMDP_DESC', 'Module for the advanced administration of downloads');

/**
 * Menus del administrador
 */
define('_MI_RMDP_AM1', 'Existing Categories');
define('_MI_RMDP_AM2', 'New Category');
define('_MI_RMDP_AM3', 'Existing Downloads');
define('_MI_RMDP_AM4', 'New Download');
define('_MI_RMDP_AM5', 'Sponsored Downloads');
define('_MI_RMDP_AM8', 'Platforms');
define('_MI_RMDP_AM9', 'Licenses');
define('_MI_RMDP_AM10', 'Received Downloads');
define('_MI_RMDP_AM11', 'Updated');

/**
 * SubMenu
 */
define('_MI_SEND_DOWNLOAD', 'Submit');
define('_MI_SENDED_DOWNS', 'My Downloads');

/**
 * Opciones de Configuraci&oacute;n
 */
define('_MI_RMDP_MODTITLE', 'Module Title:');
define('_MI_RMDP_CATGOIMGW', 'Width of the categories images:');
define('_MI_RMDP_SHOWCATIMG', 'Show Categories Images');
define('_MI_RMDP_DOWNIMGW', 'Width of the downloads images:');
define('_MI_RMDP_SHOTIMGW', 'Width of the downloads screenshots thumbnails:');
define('_MI_RMDP_SHOTIMGBIGW', 'Width of the downloads screenshots normal images:');
define('_MI_RMDP_SHOTIMGBIGD', 'Useful only when "Link directly to images" is deactivated');
define('_MI_RMDP_SHOTLINK', 'Link directly to images:');
define('_MI_RMDP_CATEGODAYSNEW', 'Days to consider a category as new:');
define('_MI_RMDP_CARACTDAYSNEW', 'Days to consider a characteritic as new:');
define('_MI_RMDP_SHOTDAYSNEW', 'Days to consider a screenshot as new:');
define('_MI_RMDP_SENDDOWN', 'Activate de downloads sent:');
define('_MI_RMDP_SENDANONIMO', 'Anonymous users can send downloads:');
define('_MI_RMDP_CATWITHNEWS', 'Nomber of categories with news in the homepage of the module:');
define('_MI_RMDP_SPONSORNUM', 'Number of sponsored downloads to show:');
define('_MI_RMDP_FAVORITESNUM', 'Number of Favorite Downloads:');
define('_MI_RMDP_POPULARNUM', 'Number of Popular Downloads:');
define('_MI_RMDP_LENDESC', 'Length of description of sponsored downloads:');
define('_MI_RMDP_SHOTLIMIT', 'Number of screenshots per download:');
define('_MI_RMDP_SUBCATLIMIT', 'Number of subcategories to show:');
define('_MI_RMDP_RESALTEBG', 'Background color of outstanding downloads (HEX):');
define('_MI_RMDP_LIMITRESULT', 'Results per page:');
define('_MI_RMDP_UPDATEDAYS', 'Days to consider a element as updated:');
define('_MI_RMDP_DOWNNEW', 'Days to consider a download as new:');
define('_MI_RMDP_DATEFORMAT', 'Date Format:');
define('_MI_RMDP_POPULARNEEDS', 'Number of downloads to consider a element as popular:');
define('_MI_RMDP_USERVOTE', 'Allow anonymous votes');
define('_MI_RMDP_OPENWINDOW', 'Downloads Behaviours:');
define('_MI_RMDP_OPENSAME', 'Open in same window');
define('_MI_RMDP_OPENNEW', 'Open in a new window');
define('_MI_RMDP_SHOTCOLS', 'Number of columns for screenshots:');
define('_MI_RMDP_TOPPOP', 'Number of popular downloads');
define('_MI_RMDP_TOPFAV', 'Number of favorite downloads');
define('_MI_RMDP_TOPRATE', 'Number of best rated downloads');
define('_MI_RMDP_SENDMAIL', 'Notify by email when a new download is submitted');
define('_MI_RMDP_BODYMAIL', 'Email body for approved downloads:');
define('_MI_RMDP_BORKENINFO', 'Informative text for borken downloads report');

// Bloques
define('_MI_RMDP_RECENT_TITLE', 'New Downloads');
define('_MI_RMDP_POPULARTITLE', 'Top Downloads');
define('_MI_RMDP_UPDATETITLE', 'Updated Downloads');
define('_MI_RMDP_RATEDTITLE', 'Best Rated');
define('_MI_RMDP_LASTDOWN', 'New Download');

////////////////////////////////////////////
// NUEVOS O MODIFICADOS EN LA VERSIÓN 1.3 //
////////////////////////////////////////////
define('_MI_RMDP_BANNERS', 'Activate banners in module:');
define('_MI_RMDP_BANNERS_CODE', 'Code for banners:');
define('_MI_RMDP_CONFIGCAT_IMGS', 'Images Configuration');
define('_MI_RMDP_CONFIGCAT_DOWNS', 'Downloads Configuration');
define('_MI_RMDP_SENDFILES', 'Allow uploads:');
define('_MI_RMDP_SENDFILE_DESC', '<span style="font-size: 10px;">Activating this option, users can to upload files directly on the server</span>');
define('_MI_RMDP_SENDIMG', 'Allow images upload:');
define('_MI_RMDP_SENDIMG_DESC', 'Activating this option, users can to upload images directly on the server');
define('_MI_RMDP_SHOTLINK_DESC', '<span style="font-size: 10px;">Activating this, users will be sent directly to the image file, in other case, users will be sent to a module page for viewing the image.</span>');
define('_MI_RMDP_SOFTDIR', 'Uploads directory:');
define('_MI_RMDP_SOFTDIR_DESC', '<span style="font-size: 10px;">This is the path where the files sent by users will be stored.<br>Useful Tags:<br>{XOOPS_PATH} = Xoops path<br>{RMDP_PATH} = RMSOFT Downloads Plus Path</span>');
define('_MI_RMDP_MIRRORSNUM', 'Max number of mirrors:');
define('_MI_RMDP_MIRRORSNUM_DESC', '<span style="font-size: 10px;">Number of mirror sites for a download.</span>');
define('_MI_RMDP_FILESIZE', 'Max size of file:');
define('_MI_RMDP_SIZEUNIT', 'Unit for the file size:');
define('_AM_RMDP_EDITOR', 'Editor type for descriptions:');
define('_MI_RMDP_FORM_COMPACT', 'Compact');
define('_MI_RMDP_FORM_DHTML', 'DHTML');
define('_MI_RMDP_FORM_SPAW', 'spaw Editor');
define('_MI_RMDP_FORM_HTMLAREA', 'HtmlArea Editor');
define('_MI_RMDP_FORM_FCK', 'FCK Editor');
define('_MI_RMDP_FORM_KOIVI', 'Koivi Editor');
define('_MI_RMDP_FILETYPES', 'Allowed file types:');
define('_MI_RMDP_FILETYPES_DESC', "Separate with '|' tehe extensions (.zip|.tar|etc)");
define('_MI_RMDP_RETARDO', 'Delay for download start:');
define('_MI_RMDP_RETARDO_DESC', 'in seconds.');
define('_MI_RMDP_BODYMAIL_DESC', '<span style="font-size: 10px;">Useful Tags:<br>{USER} = User display name.<br>{DOWN} = Download Name.<br>{LINK} = Download Link.<br>{URL} = XOOPS URL.</span>');


