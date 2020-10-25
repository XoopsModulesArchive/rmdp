<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: shots.php,v 1.5 23/11/2005 13:40:25 BitC3R0 Exp $                   //
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

$rmdp_location = 'shots';

/**
 * Comprobamos que se haya especificado el id de descarga
 **/
$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    header('location: index.php');

    die();
}
$op = $_GET['op'] ?? '';

require __DIR__ . '/header.php';
require __DIR__ . '/include/rmdp_functions.php';
rmdp_make_searchnav();

if ('view' == $op) {
    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_shots_view.html';

    /**
     * Obtenemos el Id de la imagen a mostrar
     **/

    $shot = $_GET['shot'] ?? 0;

    if ($shot <= 0) {
        header('shots.php?id=' . $id);

        die();
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$shot'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('shots.php?id=' . $id, 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('rmdp_shots') . " SET `hits`=`hits`+1 WHERE id_shot='$shot'");

    if (1 == $row['type']) {
        $img = 'uploads/shots/' . $row['big'];
    } else {
        $img = $row['big'];
    }

    $xoopsTpl->assign(
        'shot',
        [
            'id' => $row['id_shot'],
'img' => $img,
'desc' => $row['text'],
'isnew' => rmdp_element_isnew($row['fecha'], $xoopsModuleConfig['shotnew']),
'views' => $row['hits'],
        ]
    );

    $xoopsTpl->assign('img_width', $xoopsModuleConfig['imgshotbw']);

    $xoopsTpl->assign('lang_back', _RMDP_BACK);

    $xoopsTpl->assign('soft_id', $id);
} else {
    function rmdp_shot_link($shot, $img, $local = 0)
    {
        global $xoopsModuleConfig, $id;

        if ($xoopsModuleConfig['shotlink']) {
            if (1 == $local) {
                return 'uploads/shots/' . $img . '" target="_blank';
            }

            return $img . '" target="_blank';
        }

        return 'shots.php?id=' . $id . '&amp;shot=' . $shot . '&amp;op=view';
    }

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_shots.html';

    /**
     * Obtenemos las pantallas de una descarga
     **/

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$id'");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $fecha = date($xoopsModuleConfig['dateformat'], $row['fecha']);

        $isnew = rmdp_element_isnew($row['fecha'], $xoopsModuleConfig['shotnew']);

        if (1 == $row['type']) {
            $small = 'uploads/shots/ths/';

            $big = 'uploads/shots/';
        } else {
            $small = '';

            $big = '';
        }

        $xoopsTpl->append(
            'shots',
            [
                'id' => $row['id_shot'],
'small' => $small . $row['small'],
'link' => rmdp_shot_link($row['id_shot'], $row['big'], $row['type']),
'desc' => $row['text'],
'fecha' => $fecha,
'isnew' => $isnew,
'hits' => $row['hits'],
            ]
        );
    }

    $xoopsTpl->assign('img_width', $xoopsModuleConfig['imgshotsw']);
}

// Obtenemos las descargas patrocinadas
rmdp_get_sponsor();

rmdp_get_favorites(0);
rmdp_get_popular(0);

// Creamos la barra de localización
$location_bar = "<a href='" . XOOPS_URL . "/modules/rmdp/'>" . $xoopsModuleConfig['rmdptitle'] . '</a> &gt; ';
[$idc, $nombre] = $xoopsDB->fetchRow($xoopsDB->query('SELECT id_cat, nombre FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id'"));
$location_bar .= rmdp_get_location($idc);
$location_bar .= '<a href="down.php?id=' . $id . '">' . $nombre . '</a> &gt; ';
$location_bar .= '<a href="shots.php?id=' . $id . '">' . _RMDP_LOCATION_SHOT . '</a>';

$xoopsTpl->assign('location_bar', $location_bar);

// Opciones de lenguaje
$xoopsTpl->assign('lng_shotsof', sprintf(_RMDP_DOWN_SHOTS, rmdp_download_name($id)));
$xoopsTpl->assign('total_cols', $xoopsModuleConfig['shotcols']);
$xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);
$xoopsTpl->assign('lang_our_favorites', _RMDP_OUR_FAVORITES);
$xoopsTpl->assign('lang_popular_soft', _RMDP_POPULAR_SOFT);
$xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));

require __DIR__ . '/footer.php';


