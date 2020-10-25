<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_lastdown.php,v 1.5 23/11/2005 13:44:23 BitC3R0 Exp $           //
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
 * Muestra la última descarga creada junto con su
 * información y descripción
 * @param [0] $options - Mostrar imágenes (1,0)
 * @return array|void
 * @return array|void
 */
function rmdp_b_show_lastdown($options)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " ORDER BY fecha DESC LIMIT 0,$options[1]");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        return;
    }

    $rtn = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $block = [];

        if (1 == $options[0]) {
            if (1 == $row['imgtype']) {
                $img = XOOPS_URL . '/modules/rmdp/uploads/' . $row['img'];
            } else {
                $img = $row['img'];
            }
        }

        $block['id'] = $row['id_soft'];

        $block['titulo'] = $row['nombre'];

        $block['version'] = _BK_RMDP_VERSION . ' <strong>' . $row['version'] . '</strong>';

        $block['img'] = $img;

        [$cat_id, $cat_name] = $xoopsDB->fetchRow($xoopsDB->query('SELECT id_cat, nombre FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$row[id_cat]'"));

        $block['cat_id'] = $cat_id;

        $block['cat_name'] = $cat_name;

        if ($row['size'] > 1024) {
            if ($row['size'] > (1024 * 1024)) {
                $size = (int)($row['size'] / (1024 * 1024)) . ' MB';
            } else {
                $size = (int)($row['size'] / 1024) . ' KB';
            }
        } else {
            $size = $row['size'] . ' Bytes';
        }

        $user = new XoopsUser($row['submitter']);

        $block['size'] = _BK_RMDP_SIZE . " <strong>$size</strong>";

        $block['fecha'] = _BK_RMDP_SINCE . ' <strong>' . date($options[2], $row['fecha']) . '</strong>';

        $block['autor'] = _BK_RMDP_SUBMITTER . " <a href='" . XOOPS_URL . '/user.php?uid0' . $user->getVar('uid') . "'>" . $user->getVar('uname') . '</a>';

        $rtn['lastdown'][] = $block;
    }

    return $rtn;
}

function rmdp_b_edit_lastdown($options)
{
    // Mostrar Imágen

    $form = _BK_RMDP_SHOWIMG . "<br><select name='options[]'>
			<option value='1' ";

    if (1 == $options[0]) {
        $form .= "selected='selected'";
    }

    $form .= '>' . _BK_RMDP_YES . "</option>
			<option value='0' ";

    if (1 != $options[0]) {
        $form .= "selected='selected'";
    }

    $form .= '>' . _BK_RMDP_NO . '</option></select><br>';

    //Mostrar descripción

    $form .= _BK_RMDP_LASTNUM . "<br><input type='text' size='10' name='options[]' value='$options[1]'><br>";

    // Formato de fechas

    if ('' == $options[2]) {
        'd/m/Y' == $options[2];
    }

    $form .= _BK_RMDP_DATE . "<br>
			<input type='text' name='options[]' value='$options[2]' size='20'><br>";

    return $form;
}
