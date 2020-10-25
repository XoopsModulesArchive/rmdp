<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: brated.php,v 1.5 23/11/2005 13:37:58 BitC3R0 Exp $                  //
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

$rmdp_location = 'mejorval';
require __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = 'rmdp_view_popular.html';

require __DIR__ . '/include/rmdp_functions.php';
require __DIR__ . '/include/rmdp_downs.php';
require __DIR__ . '/include/rmdp_search.php';
// Obtenemos las descargas patrocinadas
rmdp_get_sponsor();
// Creamos las opciones para la búsqueda
rmdp_make_searchnav();

$xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));
$xoopsTpl->assign('lang_toppop', sprintf(_RMDP_TOP_RATE, $xoopsModuleConfig['toprate']));

/**
 * Identificamos el orden de los resultados
 */
$sort = $_GET['sort'] ?? 2;
$asdes = $_GET['ad'] ?? 1;
if ($asdes <= 0) {
    $asdes = 1;

    $ad = 'DESC';
} else {
    $asdes = '0';

    $ad = 'ASC';
}
switch ($sort) {
    case 0:
        $order = 'nombre';
        break;
    case 1:
        $order = 'fecha';
        break;
    case 2:
        $order = 'rating';
        break;
    case 3:
        $order = 'calificacion';
        break;
    case 4:
        $order = 'descargas';
        break;
    case 5:
        $order = 'submitter';
        break;
    default:
        $order = 'descargas';
        break;
}
/**
 * Cargamos las descargas populares
 **/
rmdp_search_top('rating', $order . ' ' . $ad);
$xoopsTpl->assign('rmdp_ad', $asdes);

$location = '<a href="' . XOOPS_URL . '/modules/rmdp/">' . $xoopsModuleConfig['rmdptitle'] . '</a> &gt;
	<a href="brated.php">' . _RMDP_RATED_TITLE . '</a>';
$xoopsTpl->assign('location_bar', $location);

$xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);
$xoopsTpl->assign('element_id', 0);
$xoopsTpl->assign('element_ad', $asdes);
require __DIR__ . '/footer.php';



