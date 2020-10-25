<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: vote.php,v 1.5 23/11/2005 13:40:30 BitC3R0 Exp $                    //
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
$rmdp_location = 'votos';
require __DIR__ . '/header.php';

/**
 * Comprobamos que se haya especificado el id de la descarga
 **/
$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    header('location: index.php');

    die();
}

/**
 * Comprobamos que se haya especificado un voto
 **/
$rate = $_GET['rate'] ?? 0;
if ($rate <= 0) {
    header('location: down.php?id=' . $id);

    die();
}

/**
 * Comprobamos si el usuario tiene permisos para votar
 **/
if ('' == $xoopsUser && !$xoopsModuleConfig['uservote']) {
    redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_NO_ACCESS);

    die();
}

if ('' == $xoopsUser) {
    $vote_user = 0;
} else {
    $vote_user = $xoopsUser->getVar('uid');
}

/**
 * Comprobamos que el usuario actual no sea el publicador
 * de la descarga
 **/
require __DIR__ . '/include/rmdp_functions.php';
if (rmdp_is_publisher($vote_user, $id)) {
    redirect_header('down.php?id=' . $id, 1, _RMDP_IS_PUBLISHER);

    die();
}

/**
 * Comprobamos que un usuario no vote dos veces
 * por la misma descarga
 **/
require __DIR__ . '/include/rmdp_votes.php';
if (0 == $vote_user) {
    /**
     * Si es un usuario anónimo comprobamos que haya transcurrido
     * un dia desde su último voto
     **/

    if (rmdp_vote_today($id)) {
        redirect_header('down.php?id=' . $id, 1, _RMDP_VOTE_ONEDAY);

        die();
    }

    /**
     * Asignamos el voto a la descarga seleccionada
     **/

    if (rmdp_set_anonym_vote($id, $rate)) {
        redirect_header('down.php?id=' . $id, 1, _RMDP_VOTE_THX);

        die();
    }

    redirect_header('down.php?id=' . $id, 1, _RMDP_VOTE_ERR);

    die();
}
    /**
     * Si el usuario esta registrado impedimos que
     * vote dos veces por el mismo recurso
     **/
    if (rmdp_user_voted($id, $vote_user)) {
        redirect_header('down.php?id=' . $id, 1, _RMDP_NOVOTE_TWICE);

        die();
    }

    /**
     * Agregamos el voto a la descarga
     **/
    if (rmdp_set_vote($id, $vote_user, $rate)) {
        redirect_header('down.php?id=' . $id, 1, _RMDP_VOTE_THX);

        die();
    }
        redirect_header('down.php?id=' . $id, 1, _RMDP_VOTE_ERR);
        die();
