<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: os.php,v 1.5 23/11/2005 13:43:53 BitC3R0 Exp $                      //
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

$location = 'plataformas';
require dirname(__DIR__, 3) . '/include/cp_header.php';
if (!file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/spanish/admin.php';
}

function Main()
{
    global $xoopsDB;

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    DP_ShowNav();

    $tbl = $xoopsDB->prefix('rmdp_plataformas');

    echo "<table width='100%' class='outer' cellspacing='1'>
		<tr><th align='center' colspan='2'>" . _AM_RMDP_OSEXISTS . "</th></tr>
		<form name='frmE' method='post' action='os.php'>
		<tr><td class='even' align='center' colspan='2'>
		<select name='ido'>";

    $result = $xoopsDB->query("SELECT * FROM $tbl ORDER BY nombre");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        echo "<option value='$row[id_os]'>$row[nombre]</option>";
    }

    echo "</select><br>
		<input type='button' name='sbtdel' value='" . _AM_RMDP_DELETE . "' onClick=\"frmE.op.value='del'; frmE.submit();\">
		</td></tr>
		<input type='hidden' name='op' value='mod'></form>
		<tr><th colspan='2' align='left'>" . _AM_RMDP_NEWOS . "</th></tr>
		<form name='frmNew' action='os.php' method='post'>
		<tr><td class='even' align='left'>" . _AM_RMDP_FNAME . "</td>
		<td class='odd' align='left'><input type='text' size='30' name='nombre'></td></tr>
		<tr><td class='even' align='left'>" . _AM_RMDP_FIMG . "</td>
		<td class='odd' align='left'><input type='text' size='30' name='img'></td></tr>
		<tr><td class='even' align='left'>&nbsp;</td>
		<td class='odd' align='left'><input type='submit' name='sbt' value='" . _AM_RMDP_SEND . "'></td></tr>
		<input type='hidden' name='op' value='save'>
		</form></table>";

    xoops_cp_footer();
}

function Save()
{
    global $xoopsDB;

    $tbl = $xoopsDB->prefix('rmdp_plataformas');

    $nombre = $_POST['nombre'];

    $img = $_POST['img'];

    if ('' == $nombre) {
        redirect_header('os.php', 2, _AM_RMDP_ERRNAME);

        die();
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM $tbl WHERE nombre='$nombre'"));

    if ($num > 0) {
        redirect_header('os.php', 1, _AM_RMDP_ERREXIST);

        die();
    }

    $xoopsDB->query("INSERT INTO $tbl (`nombre`,`img`) VALUES ('$nombre','$img')");

    $err = $xoopsDB->error();

    if ('' == $err) {
        redirect_header('os.php', 2, _AM_RMDP_OSOK);
    } else {
        redirect_header('os.php', 2, _AM_RMDP_CATEGOFAIL . $err);
    }
}

function Delete()
{
    global $xoopsDB;

    $ok = $_POST['ok'];

    $ido = $_POST['ido'];

    if ($ido <= 0) {
        header('location: os.php');

        die();
    }

    if ($ok) {
        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_softos') . " WHERE id_os='$ido'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_plataformas') . " WHERE id_os='$ido'");

        redirect_header('os.php', 2, _AM_RMDP_DELOK);
    } else {
        xoops_cp_header();

        require __DIR__ . '/functions.php';

        DP_ShowNav();

        echo "<table width='60%' align='center' cellspacing='1' class='outer'>
				<tr><td align='center' class='even'>
				<form name='frmDel' method='post' action='os.php'>
				<br><br>" . _AM_RMDP_CONFIRM . "<br><br>
				<input type='submit' name='sbt' value='" . _AM_RMDP_DELETE . "'>
				<input type='button' value='" . _AM_RMDP_CANCEL . "' name='cancel' onClick='history.go(-1);'>
				<input type='hidden' name='op' value='del'>
				<input type='hidden' name='ido' value='$ido'>
				<input type='hidden' name='ok' value='1'>
				</td></tr></table>";

        xoops_cp_footer();
    }
}

/**
 * Que accion tomar
 */
$op = $_GET['op'];
if ($op <= 0) {
    $op = $_POST['op'];
}

switch ($op) {
    case 'save':
        Save();
        break;
    case 'mod':
        Modify();
        break;
    case 'savemod':
        SaveMod();
        break;
    case 'del':
        Delete();
        break;
    default:
        Main();
        break;
}
