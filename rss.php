<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rss.php,v 1.5 23/11/2005 13:50:04 BitC3R0 Exp $                     //
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
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
header('Content-Type:text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
require dirname(__DIR__, 2) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(0);

$db = XoopsDatabaseFactory::getDatabaseConnection();
$myts = MyTextSanitizer::getInstance();
$catego = $_GET['cat'] ?? 0;

if ($catego <= 0) {
    $result = $db->query('SELECT * FROM ' . $db->prefix('rmdp_software') . ' ORDER BY `update` DESC LIMIT 0,50');
} else {
    $result = $db->query('SELECT * FROM ' . $db->prefix('rmdp_software') . " WHERE id_cat='$catego' ORDER BY `update` DESC LIMIT 0,50");

    $info = $db->fetchArray($db->query('SELECT * FROM ' . $db->prefix('rmdp_categos') . " WHERE id_cat='$catego'"));
}

if ($catego > 0) {
    $tpl->assign('channel_title', htmlspecialchars($xoopsModuleConfig['rmdptitle'] . ' - ' . sprintf(_RMDP_DOWNS_INCATS, $info['nombre']), ENT_QUOTES, 'ISO-8859-1'));

    $tpl->assign('channel_link', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/categos.php?id=' . $catego);

    $tpl->assign('channel_desc', sprintf(_RMDP_DOWNS_INCATS_DESC, $info['nombre'], $xoopsConfig['sitename']));

    $tpl->assign('channel_lastbuild', formatTimestamp($info['fecha'], 'rss'));

    $tpl->assign('channel_generator', 'RMSOFT Downloads Plus 1.5');

    $tpl->assign('channel_category', 'Categorías');

    $tpl->assign('channel_editor', $xoopsConfig['adminmail']);

    $tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);

    $tpl->assign('channel_language', _LANGCODE);

    $tpl->assign('image_url', XOOPS_URL . '/modules/rmdp/images/categos_rss.gif');

    $dimention = getimagesize(XOOPS_ROOT_PATH . '/modules/rmdp/images/categos_rss.gif');

    if (empty($dimention[0])) {
        $width = 128;
    } else {
        $width = ($dimention[0] > 128) ? 128 : $dimention[0];
    }

    if (empty($dimention[1])) {
        $height = 128;
    } else {
        $height = ($dimention[1] > 128) ? 128 : $dimention[1];
    }

    $tpl->assign('image_width', $width);

    $tpl->assign('image_height', $height);
} else {
    $tpl->assign('channel_title', htmlspecialchars($xoopsModuleConfig['rmdptitle'] . ' - ' . sprintf(_RMDP_DOWNS_INCATS, $xoopsConfig['sitename']), ENT_QUOTES, 'ISO-8859-1'));

    $tpl->assign('channel_link', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname'));

    $tpl->assign('channel_desc', _RMDP_DOWNS_LASTDESC);

    $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));

    $tpl->assign('channel_generator', 'RMSOFT Downloads Plus 1.5');

    $tpl->assign('channel_category', 'Descargas');

    $tpl->assign('channel_editor', $xoopsConfig['adminmail']);

    $tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);

    $tpl->assign('channel_language', _LANGCODE);

    $tpl->assign('image_url', XOOPS_URL . '/modules/rmdp/images/down_rss.gif');

    $dimention = getimagesize(XOOPS_ROOT_PATH . '/modules/rmdp/images/down_rss.gif');

    if (empty($dimention[0])) {
        $width = 128;
    } else {
        $width = ($dimention[0] > 128) ? 128 : $dimention[0];
    }

    if (empty($dimention[1])) {
        $height = 128;
    } else {
        $height = ($dimention[1] > 128) ? 128 : $dimention[1];
    }

    $tpl->assign('image_width', $width);

    $tpl->assign('image_height', $height);
}
while (false !== ($row = $db->fetchArray($result))) {
    $tpl->append(
        'items',
        [
            'title' => htmlspecialchars($row['nombre'], ENT_QUOTES, 'ISO-8859-1'),
'link' => XOOPS_URL . '/modules/rmdp/down.php?id=' . $row['id_soft'],
'guid' => XOOPS_URL . '/modules/rmdp/down.php?id=' . $row['id_soft'],
'pubdate' => date($xoopsModuleConfig['dateformat'], $row['fecha']),
'description' => htmlspecialchars($myts->displayTarea($row['longdesc']), ENT_QUOTES),
        ]
    );
}

$tpl->display(XOOPS_ROOT_PATH . '/modules/rmdp/templates/rmdp_downloads_rss.xml');
