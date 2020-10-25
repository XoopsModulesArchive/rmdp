<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_update_downs.php,v 1.5 23/11/2005 13:44:28 BitC3R0 Exp $       //
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

function rmdp_b_show_updated($options)
{
    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT id_soft, nombre, descargas FROM ' . $xoopsDB->prefix('rmdp_software') . " ORDER BY `update` DESC LIMIT 0, $options[0]");

    $block = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $rtn = [];

        $rtn['id'] = $row['id_soft'];

        $rtn['nombre'] = mb_substr($row['nombre'], 0, $options[1]);

        $rtn['descargas'] = $row['descargas'];

        $block['updatedowns'][] = $rtn;
    }

    return $block;
}

function rmdp_b_show_update_edit($options)
{
    $form = _BK_RMDP_UPDATENUM . "<br><input type='text' name='options[]' value='$options[0]'><br>";

    $form .= _BK_RMDP_NAMELENGHT . "<br><input type='text' name='options[]' value='$options[1]'>";

    return $form;
}





