<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: broken.php,v 1.5 23/11/2005 13:37:45 BitC3R0 Exp $                  //
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

$rmdp_location = 'broken';
include '../../mainfile.php';

$id = $_GET['id'] ?? ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('location: index.php');

    die();
}

if ('' == $xoopsUser) {
    redirect_header('down.php?id=' . $id, 1, _RMDP_NO_USER);

    die();
}

$ok = $_POST['ok'] ?? 0;

if ($ok) {
    $reporte = $_POST['reporte'] ?? '';

    if ('' == $reporte) {
        redirect_header('broken.php?id=' . $id, 1, _RMDP_BROKEN_NOREPORT);

        die();
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('index.php', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    $user = $memberHandler->getUser($row['submitter']);

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($user->getVar('email'));

    $xoopsMailer->setFromEmail($xoopsConfig['from']);

    $xoopsMailer->setFromName($xoopsConfig['sitename'] . ' - ' . $xoopsModuleConfig['rmdptitle']);

    $xoopsMailer->setSubject(_RMDP_BROKEN_SUBJECT);

    $xoopsMailer->setBody(sprintf(_RMDP_BROKEN_BODY, $user->getVar('uname'), XOOPS_URL . "/modules/rmdp/down.php?id=$id", $reporte));

    $xoopsMailer->send();

    $xoopsMailer->setToEmails($xoopsConfig['adminmail']);

    $xoopsMailer->setFromEmail($xoopsConfig['from']);

    $xoopsMailer->setFromName($xoopsConfig['sitename'] . ' - ' . $xoopsModuleConfig['rmdptitle']);

    $xoopsMailer->setSubject(_RMDP_BROKEN_SUBJECT);

    $xoopsMailer->setBody(sprintf(_RMDP_BROKEN_BODYADMIN, $xoopsUser->getVar('uname'), XOOPS_URL . "/modules/rmdp/admin/downs.php?op=mod&ids=$id", XOOPS_URL . "/modules/rmdp/down.php?id=$id", $reporte));

    $xoopsMailer->send();

    redirect_header('down.php?id=' . $id, 1, _RMDP_BROKEN_SEND);
} else {
    /**
     * Mostramos le formulario para reportar un enlace roto
     * @Creado: 19/Ago/2005
     * @Author: BitC3R0
     **/

    require __DIR__ . '/header.php';

    echo "<br><br><table width='80%' class='outer' cellspacing='0' align='center'>
			<form name='frmBrok' method='post' action='broken.php'>
			<tr><td class='even' align='left'>" . $xoopsModuleConfig['brokentext'] . "</td></tr>
			<tr><td class='even'><textarea name='reporte' cols='30' rows='5'></textarea><br><br>
			<input type='button' value='" . _RMDP_CANCEL_BUTTON . "' onclick='history.go(-1);'>
			<input type='submit' name='sbt' value='" . _RMDP_SEND_BUTTON . "'></td></tr>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='ok' value='1'>
			</form></table>";

    require __DIR__ . '/footer.php';
}



