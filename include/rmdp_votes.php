<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_votes.php,v 1.5 23/11/2005 13:46:28 BitC3R0 Exp $              //
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
 * Determina si un usuario anonimo ha votado
 * el día de hoy un recurso
 *
 * @ids    = Id del recurso
 * @param mixed $ids
 * @return bool = true o false
 */
function rmdp_vote_today($ids)
{
    global $xoopsDB;

    if ($ids <= 0) {
        return false;
    }

    $ip = getenv('REMOTE_ADDR');

    // Obtenemos el tiempo de hace 24 horas

    $yest = time() - 86400;

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_votes') . " WHERE id_soft='$ids' AND user_ip='$ip' AND fecha > $yest"));

    if ($num <= 0) {
        return false;
    }

    return true;
}

/**
 * Almacena el voto del usuario anónimo e incrementa las estadísticas
 * @param mixed $ids
 * @param mixed $rate
 *
 * @return bool
 * @return bool
 */
function rmdp_set_anonym_vote($ids, $rate)
{
    global $xoopsDB;

    $ip = getenv('REMOTE_ADDR');

    $fecha = time();

    $xoopsDB->queryF(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_votes') . " (`id_soft`,`uid`,`user_ip`,`fecha`)
			VALUES ('$ids','0','$ip','$fecha') ;"
    );

    if ('' != $xoopsDB->error()) {
        return false;
    }

    $xoopsDB->queryF(
        'UPDATE ' . $xoopsDB->prefix('rmdp_software') . " SET `votos`=votos+1, `rating`=rating+$rate
		WHERE id_soft='$ids'"
    );

    if ('' != $xoopsDB->error()) {
        return false;
    }

    return true;
}

/**
 * Almacena el voto de un usuario registrado
 * @param mixed $ids
 * @param mixed $uid
 * @param mixed $rate
 *
 * @return bool
 * @return bool
 */
function rmdp_set_vote($ids, $uid, $rate)
{
    global $xoopsDB;

    $ip = getenv('REMOTE_ADDR');

    $fecha = time();

    $xoopsDB->queryF(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_votes') . " (`id_soft`,`uid`,`user_ip`,`fecha`)
			VALUES ('$ids','$uid','$ip','$fecha') ;"
    );

    if ('' != $xoopsDB->error()) {
        return false;
    }

    $xoopsDB->queryF(
        'UPDATE ' . $xoopsDB->prefix('rmdp_software') . " SET `votos`=votos+1, `rating`=rating+$rate
		WHERE id_soft='$ids'"
    );

    if ('' != $xoopsDB->error()) {
        return false;
    }

    return true;
}

/**
 * Comprueba si un usuario ha votado por un recurso
 * @param mixed $ids
 * @param mixed $uid
 *
 * @return bool
 * @return bool
 */
function rmdp_user_voted($ids, $uid)
{
    global $xoopsDB;

    if ($ids <= 0 || $uid <= 0) {
        return false;
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_votes') . " WHERE id_soft='$ids' AND uid='$uid'"));

    if ($num <= 0) {
        return false;
    }

    return true;
}
