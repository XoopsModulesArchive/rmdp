<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: search.php,v 1.5 23/11/2005 13:40:17 BitC3R0 Exp $                  //
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

$rmdp_location = 'search';
require __DIR__ . '/header.php';

$key = $_GET['key'];
if ('' == $key) {
    $key = $_POST['key'];
}
$cat = $_GET['cat'] ?? ($_POST['cat'] ?? 0);

if ('' == $key) {
    redirect_header('index.php', 1, _RMDP_NOSEARCH_KEY);

    die();
}

$GLOBALS['xoopsOption']['template_main'] = 'rmdp_search_result.html';

// Realizamos la busqueda
require __DIR__ . '/include/rmdp_functions.php';
require __DIR__ . '/include/rmdp_downs.php';
require __DIR__ . '/include/rmdp_search.php';

// Obtenemos las descargas patrocinadas
rmdp_get_sponsor();
// Creamos las opciones para la búsqueda
rmdp_make_searchnav();

$xoopsTpl->assign('lang_our_favorites', _RMDP_OUR_FAVORITES);
$xoopsTpl->assign('lang_popular_soft', _RMDP_POPULAR_SOFT);
$xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));
$xoopsTpl->assign('lang_toppop', sprintf(_RMDP_SEARCH_RESULTS, $key));
$xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);

// Cargamos favoritos y populares
rmdp_get_favorites(0);
rmdp_get_popular(0);

/**
 * Identificamos el orden de los resultados
 */
$sort = $_GET['sort'] ?? 4;
$asdes = $_GET['ad'] ?? 0;
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

rmdp_search_keyword($key, $cat, $order . ' ' . $ad);
$xoopsTpl->assign('rmdp_ad', $asdes);
$xoopsTpl->assign('rmdp_cat', $cat);
$pag = $_GET['pag'] ?? 1;
$xoopsTpl->assign('element_id', "0&amp;key=$key&amp;pag=$pag");
$xoopsTpl->assign('element_ad', $asdes);

require __DIR__ . '/footer.php';


