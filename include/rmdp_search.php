<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_search.php,v 1.5 23/11/2005 13:46:24 BitC3R0 Exp $             //
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

/**
 * Realiza una busqueda básica en la base de datos
 * Parametros
 *
 * @where  = Clausula SQL para busqueda
 * @param mixed $where
 * @param mixed $goto
 * @param mixed $order
 * @param mixed $title
 * @return int = Array escrito directamente a $xoopsTpl
 */
function rmdp_basic_search($where, $goto, $order = 'nombre', $title = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $myts;

    $tblsoft = $xoopsDB->prefix('rmdp_software');

    $limit = $xoopsModuleConfig['limit_result'];

    $upddays = $xoopsModuleConfig['update_days'];

    $newdays = $xoopsModuleConfig['downnew'];

    // Paginamos los productos Existentes

    $pag = $_GET['pag'] ?? 0;

    if ($pag > 0) {
        $pag -= 1;
    }

    $start = $pag * $limit;

    if ('' == $where) {
        $where_next = '';
    } else {
        $where_next = 'WHERE ' . $where;
    }

    $result = $xoopsDB->query("SELECT COUNT(*) FROM $tblsoft $where_next");

    [$num] = $xoopsDB->fetchRow($result);

    $rtotal = $num; // Numero total de resultados

    $tpages = (int)($num / $limit);

    $pactual = $pag + 1;

    if ($pactual > $tpages) {
        $rest = $pactual - $tpages;

        $pactual = $pactual - $rest + 1;

        $start = ($pactual - 1) * $limit;
    }

    if ('' == $order) {
        $order = 'nombre';
    }

    $sql = "SELECT * FROM $tblsoft $where_next ORDER BY $order LIMIT $start, $limit";

    $result = $xoopsDB->query($sql);

    $num2 = $xoopsDB->getRowsNum($result); // Configurar el total dse resultados
    $rate = rmdp_set_rating(); // Establecemos los votos para ganar un punto de rating

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $isnew = rmdp_element_isnew($row['fecha'], $newdays);

        $isupdate = rmdp_element_isnew($row['update'], $upddays);

        $desc = '';

        $date = date($xoopsModuleConfig['dateformat'], $row['fecha']);

        $update = date($xoopsModuleConfig['dateformat'], $row['update']);

        $issponsor = rmdp_element_issponsor($row['id_soft']);

        if (1 == $row['imgtype']) {
            $img = "uploads/$row[img]";
        } else {
            $img = $row['img'];

            if ('' == $img) {
                $img = 'images/no_image.gif';
            }
        }

        if (rmdp_get_shotsnum($row['id_soft']) > 0) {
            $haveshots = true;
        } else {
            $haveshots = false;
        }

        $xoopsTpl->append(
            'downloads',
            [
                'id' => $row['id_soft'],
'nombre' => $row['nombre'],
'desc' => $desc,
'version' => $row['version'],
'licence' => rmdp_get_licencename($row['licencia']),
'size' => rmdp_convert_size($row['size']),
'descargas' => $row['descargas'],
'rating' => rmdp_calculate_rating($row['rating'], $rate),
'calificacion' => $row['calificacion'],
'resaltar' => $row['resaltar'],
'fecha' => $date,
'isnew' => $isnew,
'update' => $update,
'isupdate' => $isupdate,
'issponsor' => $issponsor,
'votos' => sprintf(_RMDP_VOTES, $row['votos']),
'submitter' => $row['submitter'],
'uname' => rmdp_get_username($row['submitter']),
'os' => rmdp_get_downos($row['id_soft']),
'shots' => $haveshots,
'img' => $img,
            ]
        );
    }

    if (($num % $limit) > 0) {
        $tpages += 1;
    }

    $xoopsTpl->assign('lng_total_results', sprintf(_RMDP_TOTAL_RESULTS, $start + 1, (($pactual - 1) * $limit) + $num2, $num));

    $nav = _RMDP_RESULT_PAGES;

    for ($i = 1; $i <= $tpages; $i++) {
        $nav .= "<a href='$goto&amp;pag=$i&amp;sort=$order'>$i</a>&nbsp;";
    }

    $xoopsTpl->assign('nav_pages', $nav);

    $xoopsTpl->assign('resalte_bg', $xoopsModuleConfig['bgresalte']);

    $xoopsTpl->assign('results_title', $title);

    $xoopsTpl->assign('lng_resort_by', _RMDP_RESORT_BY);

    $xoopsTpl->assign('lng_nombre', _RMDP_ORDER_NAME);

    $xoopsTpl->assign('lng_fecha', _RMDP_ORDER_DATE);

    $xoopsTpl->assign('lng_rating', _RMDP_ORDER_RATING);

    $xoopsTpl->assign('lng_ourrating', _RMDP_ORDER_OURRATING);

    $xoopsTpl->assign('lng_downloads', _RMDP_ORDER_DOWNLOADS);

    $xoopsTpl->assign('lng_sendby', _RMDP_ORDER_SUBMITTER);

    $xoopsTpl->assign('lng_os', _RMDP_OS);

    $xoopsTpl->assign('lng_version', _RMDP_VERSION);

    $xoopsTpl->assign('lng_filesize', _RMDP_FILE_SIZE);

    $xoopsTpl->assign('lng_licence', _RMDP_LICENCE);

    $xoopsTpl->assign('lng_new', _RMDP_NEW_DOWN);

    $xoopsTpl->assign('lng_update', _RMDP_UPDATE_DOWN);

    $xoopsTpl->assign('lang_sponsored', _RMDP_SPONSORED);

    if ($num > 0) {
        return 1;
    }

    return 0;
}

function rmdp_search_top($item = 'descargas', $order = 'nombre')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $myts;

    $tblsoft = $xoopsDB->prefix('rmdp_software');

    switch ($item) {
        case 'descargas':
            $limit = $xoopsModuleConfig['toppop'];
            $sql_uno = "SELECT COUNT(*) FROM $tblsoft WHERE descargas > '0' ORDER BY descargas DESC LIMIT 0, $limit";
            $sql = "SELECT * FROM $tblsoft WHERE descargas > '0' ORDER BY $order LIMIT 0, $limit";
            $xoopsTpl->assign('rmdp_page', 'popular.php');
            break;
        case 'favorito':
            $limit = $xoopsModuleConfig['limit_result'];
            $sql_uno = "SELECT COUNT(*) FROM $tblsoft WHERE favorito='1'";
            $xoopsTpl->assign('rmdp_page', 'favorites.php');
            break;
        case 'rating':
            $limit = $xoopsModuleConfig['toprate'];
            $sql_uno = "SELECT COUNT(*) FROM $tblsoft WHERE rating > 0 ORDER BY rating DESC LIMIT 0, $limit";
            $sql = "SELECT * FROM $tblsoft WHERE rating > 0 ORDER BY $order LIMIT 0, $limit";
            $xoopsTpl->assign('rmdp_page', '');
            break;
    }

    $upddays = $xoopsModuleConfig['update_days'];

    $newdays = $xoopsModuleConfig['downnew'];

    // Paginamos los productos Existentes

    $pag = $_GET['pag'] ?? 0;

    if ($pag > 0) {
        $pag -= 1;
    }

    $start = $pag * $limit;

    $result = $xoopsDB->query($sql_uno);

    [$num] = $xoopsDB->fetchRow($result);

    $rtotal = $num; // Numero total de resultados

    $tpages = (int)($num / $limit);

    $pactual = $pag + 1;

    if ($pactual > $tpages) {
        $rest = $pactual - $tpages;

        $pactual = $pactual - $rest + 1;

        $start = ($pactual - 1) * $limit;
    }

    if ('favorito' == $item) {
        $sql = "SELECT * FROM $tblsoft WHERE favorito = '1' ORDER BY $order LIMIT $start, $limit";
    }

    $result = $xoopsDB->query($sql);

    $num2 = $xoopsDB->getRowsNum($result); // Configurar el total dse resultados
    $rate = rmdp_set_rating(); // Establecemos los votos para ganar un punto de rating
    $i = 1;

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $isnew = rmdp_element_isnew($row['fecha'], $newdays);

        $isupdate = rmdp_element_isnew($row['update'], $upddays);

        $desc = '';

        $date = date($xoopsModuleConfig['dateformat'], $row['fecha']);

        $update = date($xoopsModuleConfig['dateformat'], $row['update']);

        $issponsor = rmdp_element_issponsor($row['id_soft']);

        if ('favorito' == $order) {
            $nombre = $row['nombre'];
        } else {
            $nombre = $i . '. ' . $row['nombre'];
        }

        if (rmdp_get_shotsnum($row['id_soft']) > 0) {
            $haveshots = true;
        } else {
            $haveshots = false;
        }

        $xoopsTpl->append(
            'downloads',
            [
                'id' => $row['id_soft'],
'nombre' => $nombre,
'desc' => $desc,
'version' => $row['version'],
'licence' => rmdp_get_licencename($row['licencia']),
'size' => rmdp_convert_size($row['size']),
'descargas' => $row['descargas'],
'rating' => rmdp_calculate_rating($row['rating'], $rate),
'calificacion' => $row['calificacion'],
'resaltar' => $row['resaltar'],
'fecha' => $date,
'isnew' => $isnew,
'update' => $update,
'isupdate' => $isupdate,
'issponsor' => $issponsor,
'votos' => sprintf(_RMDP_VOTES, $row['votos']),
'submitter' => $row['submitter'],
'uname' => rmdp_get_username($row['submitter']),
'os' => rmdp_get_downos($row['id_soft']),
'shots' => $haveshots,
            ]
        );

        $i++;
    }

    if (($num % $limit) > 0) {
        $tpages += 1;
    }

    $xoopsTpl->assign('lng_total_results', sprintf(_RMDP_TOTAL_RESULTS, $start + 1, (($pactual - 1) * $limit) + $num2, $num));

    if ('favorito' == $item) {
        $nav = _RMDP_RESULT_PAGES;

        for ($i = 1; $i <= $tpages; $i++) {
            $nav .= "<a href='$goto&amp;pag=$i&amp;sort=$order'>$i</a>&nbsp;";
        }

        $xoopsTpl->assign('nav_pages', $nav);
    }

    $xoopsTpl->assign('resalte_bg', $xoopsModuleConfig['bgresalte']);

    $xoopsTpl->assign('lng_resort_by', _RMDP_RESORT_BY);

    $xoopsTpl->assign('lng_nombre', _RMDP_ORDER_NAME);

    $xoopsTpl->assign('lng_fecha', _RMDP_ORDER_DATE);

    $xoopsTpl->assign('lng_rating', _RMDP_ORDER_RATING);

    $xoopsTpl->assign('lng_ourrating', _RMDP_ORDER_OURRATING);

    $xoopsTpl->assign('lng_downloads', _RMDP_ORDER_DOWNLOADS);

    $xoopsTpl->assign('lng_sendby', _RMDP_ORDER_SUBMITTER);

    $xoopsTpl->assign('lng_os', _RMDP_OS);

    $xoopsTpl->assign('lng_version', _RMDP_VERSION);

    $xoopsTpl->assign('lng_filesize', _RMDP_FILE_SIZE);

    $xoopsTpl->assign('lng_licence', _RMDP_LICENCE);

    $xoopsTpl->assign('lng_new', _RMDP_NEW_DOWN);

    $xoopsTpl->assign('lng_update', _RMDP_UPDATE_DOWN);

    $xoopsTpl->assign('lang_sponsored', _RMDP_SPONSORED);

    $xoopsTpl->assign('view_shots', _RMDP_VIEW_SHOT);

    if ($num > 0) {
        return 1;
    }

    return 0;
}

/**
 * Realiza una búsqueda en la bse de datos
 * @param mixed $key
 * @param mixed $cat
 * @param mixed $order
 *
 * @return int
 * @return int
 */
function rmdp_search_keyword($key, $cat = 0, $order = 'nombre')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $myts;

    $tblsoft = $xoopsDB->prefix('rmdp_software');

    $limit = $xoopsModuleConfig['limit_result'];

    $upddays = $xoopsModuleConfig['update_days'];

    $newdays = $xoopsModuleConfig['downnew'];

    // Paginamos los productos Existentes

    $pag = $_GET['pag'] ?? 0;

    if ($pag > 0) {
        $pag -= 1;
    }

    $start = $pag * $limit;

    if ($cat > 0) {
        $sql = "SELECT COUNT(*) FROM $tblsoft WHERE (nombre LIKE '%$key%' OR longdesc LIKE '%$key%'
					OR archivo LIKE '%$key%'OR urltitle LIKE '%$key%') AND id_cat='$cat'";
    } else {
        $sql = "SELECT COUNT(*) FROM $tblsoft WHERE nombre LIKE '%$key%' OR longdesc LIKE '%$key%'
					OR archivo LIKE '%$key%' OR urltitle LIKE '%$key%'";
    }

    $result = $xoopsDB->query($sql);

    [$num] = $xoopsDB->fetchRow($result);

    $rtotal = $num; // Numero total de resultados

    $tpages = (int)($num / $limit);

    $pactual = $pag + 1;

    if ($pactual > $tpages) {
        $rest = $pactual - $tpages;

        $pactual = $pactual - $rest + 1;

        $start = ($pactual - 1) * $limit;
    }

    if ('' == $order) {
        $order = 'nombre';
    }

    if ($cat > 0) {
        $sql = "SELECT * FROM $tblsoft WHERE (nombre LIKE '%$key%' OR longdesc LIKE '%$key%'
				OR archivo LIKE '%$key%' OR urltitle LIKE '%$key%') AND id_cat='$cat' ORDER BY $order LIMIT $start, $limit";
    } else {
        $sql = "SELECT * FROM $tblsoft WHERE nombre LIKE '%$key%' OR longdesc LIKE '%$key%'
				OR archivo LIKE '%$key%' OR urltitle LIKE '%$key%' ORDER BY $order LIMIT $start, $limit";
    }

    $result = $xoopsDB->query($sql);

    $num2 = $xoopsDB->getRowsNum($result); // Configurar el total dse resultados
    $rate = rmdp_set_rating(); // Establecemos los votos para ganar un punto de rating
    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $isnew = rmdp_element_isnew($row['fecha'], $newdays);

        $isupdate = rmdp_element_isnew($row['update'], $upddays);

        $desc = '';

        $date = date($xoopsModuleConfig['dateformat'], $row['fecha']);

        $update = date($xoopsModuleConfig['dateformat'], $row['update']);

        $issponsor = rmdp_element_issponsor($row['id_soft']);

        if (rmdp_get_shotsnum($row['id_soft']) > 0) {
            $haveshots = true;
        } else {
            $haveshots = false;
        }

        $xoopsTpl->append(
            'downloads',
            [
                'id' => $row['id_soft'],
'nombre' => $row['nombre'],
'desc' => $desc,
'version' => $row['version'],
'licence' => rmdp_get_licencename($row['licencia']),
'size' => rmdp_convert_size($row['size']),
'descargas' => $row['descargas'],
'rating' => rmdp_calculate_rating($row['rating'], $rate),
'calificacion' => $row['calificacion'],
'resaltar' => $row['resaltar'],
'fecha' => $date,
'isnew' => $isnew,
'update' => $update,
'isupdate' => $isupdate,
'issponsor' => $issponsor,
'votos' => sprintf(_RMDP_VOTES, $row['votos']),
'submitter' => $row['submitter'],
'uname' => rmdp_get_username($row['submitter']),
'os' => rmdp_get_downos($row['id_soft']),
'shots' => $haveshots,
            ]
        );
    }

    if (($num % $limit) > 0) {
        $tpages += 1;
    }

    $xoopsTpl->assign('lng_total_results', sprintf(_RMDP_TOTAL_RESULTS, $start + 1, (($pactual - 1) * $limit) + $num2, $num));

    $nav = _RMDP_RESULT_PAGES;

    for ($i = 1; $i <= $tpages; $i++) {
        $nav .= "<a href='search.php?cat=$cat&amp;key=$key&amp;pag=$i&amp;sort=$order'>$i</a>&nbsp;";
    }

    $xoopsTpl->assign('nav_pages', $nav);

    $xoopsTpl->assign('resalte_bg', $xoopsModuleConfig['bgresalte']);

    $xoopsTpl->assign('lng_resort_by', _RMDP_RESORT_BY);

    $xoopsTpl->assign('lng_nombre', _RMDP_ORDER_NAME);

    $xoopsTpl->assign('lng_fecha', _RMDP_ORDER_DATE);

    $xoopsTpl->assign('lng_rating', _RMDP_ORDER_RATING);

    $xoopsTpl->assign('lng_ourrating', _RMDP_ORDER_OURRATING);

    $xoopsTpl->assign('lng_downloads', _RMDP_ORDER_DOWNLOADS);

    $xoopsTpl->assign('lng_sendby', _RMDP_ORDER_SUBMITTER);

    $xoopsTpl->assign('lng_os', _RMDP_OS);

    $xoopsTpl->assign('lng_version', _RMDP_VERSION);

    $xoopsTpl->assign('lng_filesize', _RMDP_FILE_SIZE);

    $xoopsTpl->assign('lng_licence', _RMDP_LICENCE);

    $xoopsTpl->assign('lng_new', _RMDP_NEW_DOWN);

    $xoopsTpl->assign('lng_update', _RMDP_UPDATE_DOWN);

    $xoopsTpl->assign('lang_sponsored', _RMDP_SPONSORED);

    $xoopsTpl->assign('view_shots', _RMDP_VIEW_SHOT);

    $xoopsTpl->assign('rmdp_page', 'search.php?cat=$cat&amp;key=$key');

    if ($num > 0) {
        return 1;
    }

    return 0;
}



