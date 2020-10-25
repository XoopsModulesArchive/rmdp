<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: down.php,v 1.5 23/11/2005 13:38:17 BitC3R0 Exp $                    //
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

$rmdp_location = 'downloads';
$id = $_GET['id'];
if ($id <= 0) {
    header('location: index.php');

    die();
}

require __DIR__ . '/header.php';

require __DIR__ . '/include/rmdp_functions.php';
// Creamos la barra de localización
$location_bar = "<a href='" . XOOPS_URL . "/modules/rmdp/'>" . $xoopsModuleConfig['rmdptitle'] . "</a> <img src='images/arrow.gif' align='absmiddle' border='0'> ";
[$idc, $nombre] = $xoopsDB->fetchRow($xoopsDB->query('SELECT id_cat, nombre FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id'"));
$location_bar .= rmdp_get_location($idc);
$location_bar .= '<a href="down.php?id=' . $id . '">' . $nombre . '</a>';
$xoopsTpl->assign('location_bar', $location_bar);

/**
 * Creamos la barra de busqueda
 **/
rmdp_make_searchnav();
/**
 * Código de Banners
 */
$xoopsTpl->assign('rmdp_showbanner', $xoopsModuleConfig['banners']);
if (1 == $xoopsModuleConfig['banners']) {
    $xoopsTpl->assign('code_banner', $xoopsModuleConfig['banncode']);
}
/**
 * Detectamos que acción realizar
 * @sw = now; Decargar ahora mismo
 * @sw != now; Mostramos los datos
 */
$sw = $_GET['sw'] ?? 'show';

if ('now' == $sw) {
    /**
     * Comprobamos el acceso a la categoría
     **/

    require __DIR__ . '/include/rmdp_access.php';

    require_once __DIR__ . '/include/rmdp_downs.php';

    if ('' == $xoopsUser && rmdp_check_access($idc)) {
        redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_ERR_ACCESS);

        die();
    }

    /**
     * Transferimos la descarga
     */

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_download_now.html';

    /**
     * Cargamos los datos
     **/

    $result = $xoopsDB->query('SELECT nombre, archivo, descargas, anonimo,filetype FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        /**
         * Si no existe la descarga enviamos a index.php
         **/

        redirect_header('index.php', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    $nombre = $row['nombre'];

    if (0 == $row['filetype']) {
        $file = $row['archivo'];
    } else {
        $file = str_replace('{XOOPS_PATH}', XOOPS_URL, $xoopsModuleConfig['softdir'] . '/' . $row['archivo']);

        $file = str_replace('{RMDP_PATH}', XOOPS_URL . '/modules/rmdp/', $file);
    }

    $anonimo = $row['anonimo'];

    $descargas = $row['descargas'];

    $xoopsTpl->assign('download_name', $nombre);

    if ('' == $xoopsUser) {
        if (!$anonimo) {
            redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_ERR_NOACCESS);

            die();
        }
    }

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('rmdp_software') . ' SET `descargas`=' . ($descargas + 1) . " WHERE id_soft='$id'");

    /**
     * Agregamos el script para iniciar automáticamente la descarga
     **/

    $auto = $_GET['auto'] ?? 1;

    $xoopsTpl->assign('rmdp_autorun', $auto);

    if (1 == $auto) {
        $idm = $_GET['mir'] ?? 0;

        $url = ($idm <= 0) ? $file : rmdpGetMirror($idm, $file);

        if ($xoopsModuleConfig['newwindow']) {
            $xoops_module_header .= "\n<script type='text/javascript'><!--
			function startDownload(){
				document.download.submit();
			}";

            $xoopsTpl->assign('form_download', "<form action='" . $url . "' method='get' name='download' target='_blank' id='download'></form>");
        } else {
            $xoops_module_header .= "\n<script language='javascript' type='text/javascript'><!--
			function startDownload(){
				 window.location = \"" . $url . '";
			}';
        }

        $xoops_module_header .= "function Temporizador(){
				setTimeout('startDownload()'," . ($xoopsModuleConfig['retardo'] * 1000) . ');
			}
			window.onLoad=Temporizador();
			-->
			</script>';
    }

    /**
     * Establecemos las variables Smarty
     **/

    $xoopsTpl->assign('lng_inprogress', _DOWNLOAD_IN_PROGRESS);

    $xoopsTpl->assign('lng_ifnostart', sprintf(_RMDP_CLICK_HERE, $file));

    $xoopsTpl->assign('lng_while_down', _RMDP_WHILE_DOWN);

    $xoopsTpl->assign('lang_our_favorites', _RMDP_OUR_FAVORITES);

    $xoopsTpl->assign('lang_popular_soft', _RMDP_POPULAR_SOFT);

    $xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));

    $xoopsTpl->assign('lang_try', _RMDP_TRY_ANOTHER);

    $xoopsTpl->assign('lang_thanks', _RMDP_THANKS_DOWN);

    /**
     * Obtenemos los enlaces alternativos
     */

    rmdpGetMirrors($id);

    $xoopsTpl->assign('download_id', $id);

    //Obtenemos los favoritos

    rmdp_get_favorites(0);

    //Obtenemos las descargas recientes

    rmdp_get_popular(0);
} else {
    /**
     * MOstramos los datos de la descarga
     **/

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_download_data.html';

    // Cargamos los datos de la descarga

    require __DIR__ . '/include/rmdp_downs.php';

    rmdpGetMirrors($id, true);

    rmdp_load_downdata($id);

    require XOOPS_ROOT_PATH . '/include/comment_view.php';

    $xoopsTpl->assign('alternate_links', _RMDP_OTHER_MIRRORS);

    $xoopsTpl->assign('lang_popular', _RMDP_POPULAR);

    $xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);
}

require __DIR__ . '/footer.php';


