<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_xoops_search.php,v 1.5 23/11/2005 13:46:32 BitC3R0 Exp $       //
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

function rmdp_xoops_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = 'SELECT id_soft,nombre,submitter,fecha,longdesc,urltitle FROM ' . $xoopsDB->prefix('rmdp_software') . ' ';

    if (0 != $userid) {
        $sql .= ' WHERE submitter=' . $userid . ' AND ';
    } else {
        $sql .= ' WHERE ';
    }

    // because count() returns 1 even if a supplied variable

    // is not an array, we must check if $querryarray is really an array

    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " ((nombre LIKE '%$queryarray[0]%' OR urltitle LIKE '%queryarray[0]%' OR longdesc LIKE '%$queryarray[0]%')";

        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";

            $sql .= "(nombre LIKE '%$queryarray[$i]%' OR urltitle LIKE '%queryarray[$i]%' OR longdesc LIKE '%$queryarray[$i]%')";
        }

        $sql .= ') ';
    }

    $sql .= 'ORDER BY fecha DESC';

    $result = $xoopsDB->query($sql, $limit, $offset);

    $ret = [];

    $i = 0;

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'images/down_search.gif';

        $ret[$i]['link'] = 'down.php?id=' . $myrow['id_soft'];

        $ret[$i]['title'] = $myrow['nombre'];

        $ret[$i]['time'] = $myrow['fecha'];

        $ret[$i]['uid'] = $myrow['submitter'];

        $i++;
    }

    return $ret;
}
