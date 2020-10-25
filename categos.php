<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: categos.php,v 1.5 23/11/2005 13:34:13 BitC3R0 Exp $                 //
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
$rmdp_location = 'categos';

$id = $_GET['id'];
if ($id <= 0) {
    header('location: index.php');

    die();
}

require __DIR__ . '/header.php';

$xoopsTpl->assign('rss_catego', $id);

// Comprobamos el acceso a la categoría
require __DIR__ . '/include/rmdp_access.php';
if ('' == $xoopsUser && rmdp_check_access($id)) {
    redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_ERR_ACCESS);

    die();
}

$GLOBALS['xoopsOption']['template_main'] = 'rmdp_categos.html';

require __DIR__ . '/include/rmdp_functions.php';
require __DIR__ . '/include/rmdp_downs.php';

// Obtenemos las descargas patrocinadas
rmdp_get_sponsor();

// Obtenemos la lista de categorías
$xoopsTpl->assign('show_catego_table', get_categos_list($id));

// Creamos las opciones para la búsqueda
rmdp_make_searchnav();

// Creamos la barra de localización
$location_bar = "<a href='" . XOOPS_URL . "/modules/rmdp/'>" . $xoopsModuleConfig['rmdptitle'] . "</a> <img src='images/arrow.gif' align='absmiddle'> ";
$location_bar .= rmdp_get_location($id);
//$location_bar = substr($location_bar, 0, strlen($location_bar) - 6);

$xoopsTpl->assign('location_bar', $location_bar);

// Buscamos las descargas en esta categoría
require __DIR__ . '/include/rmdp_search.php';
$categoname = rmdp_get_categoname($id);
/**
 * Identificamos el orden de los resultados
 */
$sort = $_GET['sort'] ?? 0;
$asdes = $_GET['ad'] ?? 0;
if ($asdes <= 0) {
    $asdes = 1;

    $ad = 'ASC';
} else {
    $asdes = '0';

    $ad = 'DESC';
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
        $order = 'nombre';
        break;
}

$have_results = rmdp_basic_search("id_cat='$id'", 'categos.php?id=' . $id, $order . ' ' . $ad, sprintf(_RMDP_DOWNS_INCATEGO, $categoname));
$xoopsTpl->assign('have_results', $have_results);

rmdp_get_favorites(0);
rmdp_get_popular(0);

$xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));

// Cargamos la información de la categoría
$result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$id'");
if ($result) {
    $row = $xoopsDB->fetchArray($result);

    $fecha = date($xoopsModuleConfig['dateformat'], $row['fecha']);

    $xoopsTpl->assign(
        'catego',
        [
            'id' => $row['id_cat'],
'nombre' => $row['nombre'],
'img' => $row['img'],
'fecha' => $fecha,
'isnew' => rmdp_element_isnew($row['fecha'], $xoopsModuleConfig['categonew']),
        ]
    );
}

// Lenguaje
$xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);
$xoopsTpl->assign('lang_subcategos_in', sprintf(_RMDP_SUBCATEGOS_IN, $categoname));
$xoopsTpl->assign('lang_our_favorites', _RMDP_OUR_FAVORITES);
$xoopsTpl->assign('lang_popular_soft', _RMDP_POPULAR_SOFT);
$xoopsTpl->assign('view_shots', _RMDP_VIEW_SHOT);

$xoopsTpl->assign('element_id', $id);
$xoopsTpl->assign('element_ad', $asdes);

include 'footer.php';



