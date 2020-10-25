<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: shots.php,v 1.5 23/11/2005 13:43:08 BitC3R0 Exp $                   //
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
 * Este archivo es solo para inclusión.
 * Comprobamos que el archivo no se haya llamado
 * directamente, si es asi enviamos a la página de
 * descargas.
 */
if (eregi('shots.php', $_SERVER['PHP_SELF'])) {
    header('location: downs.php');

    die();
}

$ids = $_GET['ids'] ?? 0;
if ($ids <= 0) {
    $ids = $_POST['ids'];
}
if ($ids <= 0) {
    ShowDowns();

    die();
}

function ShowShots()
{
    global $xoopsDB, $ids, $xoopsModuleConfig;

    require __DIR__ . '/functions.php';

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$ids' ORDER BY fecha DESC");

    $num = $xoopsDB->getRowsNum($result);

    xoops_cp_header();

    DP_ShowNav();

    if ($num < $xoopsModuleConfig['shotlimit']) {
        echo "<a href='downs.php?op=shots&amp;ids=" . $ids . "&amp;action=new'>" . _AM_RMDP_SHOTNEW . '</a><br>';
    }

    echo "<table width='100%' class='outer'>
			<tr><th colspan='3'>" . sprintf(_AM_RMDP_SHOTLIST, DP_DownloadName($ids)) . '</th></tr>';

    $class = 'odd';

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if ('even' == $class) {
            $class = 'odd';
        } else {
            $class = 'even';
        }

        echo "<tr class='$class'><td align='center' valign='middle'>
			<a href='downs.php?op=shots&amp;ids=" . $ids . "&amp;action=view&amp;idp=$row[id_shot]'>";

        if (1 == $row['type']) {
            echo "<img src='../uploads/shots/ths/$row[small]' width='$xoopsModuleConfig[imgshotsw]' border='0'>";
        } else {
            echo "<img src='$row[small]' width='$xoopsModuleConfig[imgshotsw]' border='0'>";
        }

        echo "</a></td>
			<td align='left' valign='top'>$row[text]</td>
			<td align='center'><a href='downs.php?op=shots&amp;ids=" . $ids . "&amp;action=mod&amp;shot=$row[id_shot]'>" . _AM_RMDP_MODIFY . "</a>
			&nbsp; | &nbsp; <a href='downs.php?op=shots&amp;ids=" . $ids . "&amp;action=del&amp;shot=$row[id_shot]'>
			" . _AM_RMDP_DELETE . '</a></td></tr>';
    }

    echo '</table>';

    xoops_cp_footer();
}

function NewShot()
{
    global $xoopsDB, $ids, $xoopsModuleConfig;

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='60%' align='center' class='outer'>
		<tr><th colspan='2'>" . _AM_RMDP_SHOTNEW . "</th></tr>
		<form name='frmNew' method='post' action='downs.php' enctype='multipart/form-data'>
		<tr align='left'><td class='even'>" . _AM_RMDP_SHOTDOWN . "</td>
		<td class='odd'><strong>" . DP_DownloadName($ids) . "</strong>
		<input type='hidden' name='ids' value='$ids'></td></tr>";

    if (1 == $xoopsModuleConfig['imagesend']) {
        echo "<tr align='left'><td class='even'>" . _AM_RMDP_SHOT . "</td>
			<td class='odd'><input type='file' name='shot' size='30'></td></tr>";
    } else {
        echo "<tr align='left'><td class='even'>" . _AM_RMDP_SHOTSMALL . "</td>
			<td class='odd'><input type='text' name='small' size='30'></td></tr>
			<tr align='left'><td class='even'>" . _AM_RMDP_SHOTBIG . "</td>
			<td class='odd'><input type='text' name='big' size='30' maxlength='255'></td></tr>";
    }

    echo "<tr align='left'><td class='even'>" . _AM_RMDP_SHOTDESC . "</td>
		<td class='odd'><input type='text' name='text' size='50' maxlength='255'></td></tr>
		<tr><td class='even'>&nbsp;</td>
		<td class='odd' align='left'>
		<input type='submit' name='sbt' value='" . _AM_RMDP_SEND . "'>
		<input type='button' name='cancel' value='" . _AM_RMDP_CANCEL . "' onClick='history.go(-1);'>
		<input type='hidden' name='action' value='save'>
		<input type='hidden' name='op' value='shots'>
	    </td></tr></form>
		</table>";

    xoops_cp_footer();
}

function SaveShot()
{
    global $xoopsDB, $ids, $xoopsModuleConfig;

    $small = $_POST['small'];

    $big = $_POST['big'];

    $text = $_POST['text'];

    $fecha = time();

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    if (is_uploaded_file($_FILES['shot']['tmp_name'])) {
        $imgtype = 1;

        $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/shots/';

        $ext = mb_strrchr($_FILES['shot']['name'], '.');

        do {
            $img_name = rmdpRandomWord('13', date('My_')) . $ext;

            if (!file_exists($dir_imgs . $img_name)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['shot']['tmp_name'], $dir_imgs . $img_name)) {
            unlink($directorio . $img_name);

            redirect_header('downs.php?op=shots&amp;ids=' . $ids, 2, sprintf(_AM_RMDP_ERRMOVEFILE, $dir_imgs));

            die();
        }

        $small = $img_name;

        $big = $img_name;

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgshotbw']);

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . 'ths/' . $img_name, $xoopsModuleConfig['imgshotsw']);
    } else {
        $imgtype = 0;

        if ('' == $small || '' == $big) {
            redirect_header('downs.php?op=shots&amp;ids=' . $ids, 2, _AM_RMDP_SHOTERRSB);

            die();
        }
    }

    $xoopsDB->query(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_shots') . " (`id_soft`,`small`,`big`,`text`,`fecha`,`type`)
			VALUES ('$ids','$small','$big','$text','$fecha','$imgtype')"
    );

    $err = $xoopsDB->error();

    if ('' == $err) {
        redirect_header('downs.php?op=shots&amp;ids=' . $ids, 1, '');

        die();
    }

    redirect_header('downs.php?op=shots&amp;ids=' . $ids . '&amp;action=new', 1, _AM_RMDP_CATEGOFAIL . $err);

    die();
}

function ViewImage()
{
    global $xoopsDB, $ids, $xoopsModuleConfig;

    $idp = $_GET['idp'];

    if ($idp <= 0) {
        header('downs.php?op=shots&amp;ids=' . $ids);

        die();
    }

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    $result = $xoopsDB->query('SELECT big, text FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$idp'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('downs.php?op=shots&amp;ids=' . $ids, 1, _AM_RMDP_SHOTNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    echo "<table class='outer' align='center'>
		<tr class='even' align='center'><td>";

    if (1 == $row['type']) {
        echo "<img src='../uploads/shots/$row[big]' width='$xoopsModuleConfig[imgshotbw]'>";
    } else {
        echo "<img src='$row[big]' width='$xoopsModuleConfig[imgshotbw]'>";
    }

    echo "<br><br>
		$row[text]<br><br>
		<a href='downs.php?op=shots&amp;ids=" . $ids . "'>Volver</a><br></td></tr></table>";

    xoops_cp_footer();
}

function ShotDelete()
{
    global $xoopsDB, $ids;

    $ok = $_POST['ok'] ?? 0;

    if ($ok) {
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$_POST[shot]'");

        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            if (1 == $row['type']) {
                if (file_exists(XOOPS_ROOT_PATH . "/modules/rmdp/uploads/shots/$row[big]")) {
                    unlink(XOOPS_ROOT_PATH . "/modules/rmdp/uploads/shots/$row[big]");
                }

                if (file_exists(XOOPS_ROOT_PATH . "/modules/rmdp/uploads/shots/ths/$row[small]")) {
                    unlink(XOOPS_ROOT_PATH . "/modules/rmdp/uploads/shots/ths/$row[small]");
                }
            }
        }

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$_POST[shot]'");

        redirect_header('downs.php?op=shots&amp;ids=' . $ids, 1, _AM_RMDP_SHOTDEL);

        die();
    }

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='60%' class='outer' cellspacing='1' align='center'>\n
				<tr class='even'><td align='center'>\n
				<form name='frm' method='post' action='downs.php'>
				" . _AM_RMDP_SHOTCONFIRM . "<br><br>\n
				<input type='button' name='sbt' value='" . _AM_RMDP_CANCEL . "' onClick='javascript: history.go(-1);'>\n
				<input type='submit' name='sbt' value='" . _AM_RMDP_DELETE . "'>\n
				<input type='hidden' name='op' value='shots'>\n
				<input type='hidden' name='ok' value='1'>\n
				<input type='hidden' name='ids' value='$_GET[ids]'>\n
				<input type='hidden' name='shot' value='$_GET[shot]'>\n
				<input type='hidden' name='action' value='del'>\n
				</form></td></tr></table>";

    xoops_cp_footer();
}

function ModifyShot()
{
    global $xoopsDB, $ids;

    $shot = $_GET['shot'];

    if ($shot <= 0) {
        header('location: downs.php');

        die();
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$shot'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('downs.php?op=shots&ids=' . $ids, 1, _AM_RMDP_SHOTNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='60%' align='center' class='outer'>
		<tr><th colspan='2'>" . _AM_RMDP_SHOTMOD . "</th></tr>
		<form name='frmNew' method='post' action='downs.php'>
		<tr align='left'><td class='even'>" . _AM_RMDP_SHOTDOWN . "</td>
		<td class='odd'><strong>" . DP_DownloadName($row['id_soft']) . "</strong>
		<input type='hidden' name='ids' value='$row[id_soft]'></td></tr>
		<tr align='left'><td class='even'>" . _AM_RMDP_SHOTSMALL . "</td>
		<td class='odd'><input type='text' value='$row[small]' name='small' size='30' maxlength='255'></td></tr>
		<tr align='left'><td class='even'>" . _AM_RMDP_SHOTBIG . "</td>
		<td class='odd'><input type='text' value='$row[big]' name='big' size='30' maxlength='255'></td></tr>
		<tr align='left'><td class='even'>" . _AM_RMDP_SHOTDESC . "</td>
		<td class='odd'><input type='text' value='$row[text]' name='text' size='50' maxlength='255'></td></tr>
		<tr><td class='even'>&nbsp;</td>
		<td class='odd' align='left'>
		<input type='submit' name='sbt' value='" . _AM_RMDP_MODIFY . "'>
		<input type='button' name='cancel' value='" . _AM_RMDP_CANCEL . "' onClick='history.go(-1);'>
		<input type='hidden' name='action' value='savemod'>
		<input type='hidden' name='op' value='shots'>
		<input type='hidden' name='shot' value='$shot'>
	    </td></tr></form>
		</table>";

    xoops_cp_footer();
}

function SaveModShot()
{
    global $xoopsDB, $ids;

    $shot = $_POST['shot'];

    if ($shot <= 0) {
        header('location: downs.php');

        die();
    }

    $small = $_POST['small'];

    $big = $_POST['big'];

    $text = $_POST['text'];

    $fecha = time();

    if ('' == $small || '' == $big) {
        redirect_header('downs.php?op=shots&amp;ids=' . $ids, 2, _AM_RMDP_SHOTERRSB);

        die();
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$shot'"));

    if ($num <= 0) {
        redirect_header('downs.php?op=shots&ids=' . $ids, 1, _AM_RMDP_SHOTNOEXIST);

        die();
    }

    $xoopsDB->query(
        'UPDATE ' . $xoopsDB->prefix('rmdp_shots') . " SET `id_soft`='$ids',
		`small`='$small',`big`='$big',`text`='$text',`fecha`='$fecha' WHERE id_shot='$shot'"
    );

    $err = $xoopsDB->error();

    if ('' == $err) {
        redirect_header('downs.php?op=shots&amp;ids=' . $ids, 1, '');

        die();
    }

    redirect_header('downs.php?op=shots&amp;ids=' . $ids . '&amp;action=new', 1, _AM_RMDP_CATEGOFAIL . $err);

    die();
}

$action = $_GET['action'] ?? ($_POST['action'] ?? '');

switch ($action) {
    case 'new':
        NewShot();
        break;
    case 'save':
        SaveShot();
        break;
    case 'view':
        ViewImage();
        break;
    case 'del':
        ShotDelete();
        break;
    case 'mod':
        ModifyShot();
        break;
    case 'savemod':
        SaveModShot();
        break;
    default:
        ShowShots();
        break;
}



