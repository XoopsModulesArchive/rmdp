<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: sended.php,v 1.5 23/11/2005 13:43:06 BitC3R0 Exp $                  //
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

$location = 'sended';
require dirname(__DIR__, 3) . '/include/cp_header.php';
if (!file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/spanish/admin.php';
}
$myts = MyTextSanitizer::getInstance();

function ShowSended()
{
    global $xoopsDB, $myts, $xoopsUser;

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='4'>" . _RMDP_SENDED_TITLE . "</th></tr>
			<tr align='center' class='head'><td>" . _RMDP_NAME . '</td>
			<td>' . _RMDP_SENDBY . '</td>
			<td>' . _RMDP_DATE . '</td>
			<td>' . _AM_RMDP_OPTIONS . '</td></tr>';

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_sended') . " WHERE modify='0'");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        echo "<tr class='even'><td align='left'>
			<strong>$row[nombre]</strong><br>
			<span style='font-size: 10px;'>" . $myts->displayTarea(mb_substr($row['longdesc'], 0, 80)) . "</span></td>
			<td align='center'><a href='" . XOOPS_URL . "/userinfo.php?uid=$row[submitter]'>" . $xoopsUser->getUnameFromId($row['submitter']) . "</a></td>
			<td align='center'>" . date('d/m/Y h:i:s', $row['fecha']) . "</td>
			<td align='center'><a href='sended.php?op=del&amp;ids=$row[id_soft]'>Eliminar</a>
			| <a href='sended.php?op=acept&amp;ids=$row[id_soft]'>Aceptar</a></td></tr>";
    }

    echo '</table>';

    xoops_cp_footer();
}

function Aceptar()
{
    global $xoopsDB, $xoopsModuleConfig;

    $ids = $_GET['ids'] ?? 0;

    if ($ids <= 0) {
        header('location: sended.php');

        die();
    }

    $tbl = $xoopsDB->prefix('rmdp_sended');

    $result = $xoopsDB->query("SELECT * FROM $tbl WHERE id_soft='$ids' AND modify='0'");

    $num = $xoopsDB->getRowsNum($result);

    /**
     * Si no encontramos la descarga redirigimos a otro lugar
     */

    if ($num <= 0) {
        redirect_header('sended.php', 2, _AM_RMDP_ERRNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    DP_ShowNav();

    $cform = new XoopsThemeForm(_AM_RMDP_ACEPT, 'frmMod', 'sended.php?op=save');

    $cform->setExtra('enctype="multipart/form-data"');

    $cform->addElement(new XoopsFormText(_AM_RMDP_FNAME, 'nombre', 50, 200, $row['nombre']), true);

    $cform->addElement(new XoopsFormText(_AM_RMDP_FVERSION, 'version', 15, 10, $row['version']), true);

    $select = "<select name='licencia' id='licencia'>
			<option value='0'>Ninguna</option>";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_licences') . ' ORDER BY nombre');

    while (false !== ($rw = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$rw[id_lic]'";

        if ($rw['id_lic'] == $row['licencia']) {
            $select .= 'selected';
        }

        $select .= ">$rw[nombre]</option>";
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FLICENSE, $select, false));

    /** Archivos **/

    $cform->addElement(new XoopsFormText(_AM_RMDP_FFILEURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FFILEURL_DESC . '</span>', 'archivo_url', 50, 255, $row['archivo']), false);

    if (1 == $xoopsModuleConfig['imagesend']) {
        if (1 == $row['imgtype']) {
            $actual = '<br>' . sprintf(_AM_RMDP_ACTUAL, "<br><img src='../uploads/$row[img]' border='1'>");
        } else {
            $actual = '';
        }
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FIMGURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FIMGURL_DESC . '</span>', 'img_url', 50, 255, $row['img']), false);

    $select = "<select name='idc' id='idc'><option value='0' selected>" . _AM_RMDP_SELECT . '</option>';

    $select .= DP_ChildCategoOption(0, 0, $row['id_cat']) . '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FCATEGO, $select, false));

    $editor = rmdpGetEditor(_AM_RMDP_FLONG, 'longdesc', $row['longdesc'], '100%', '150px', '');

    $cform->addElement($editor, true);

    if (1 == $xoopsModuleConfig['filesend']) {
        $editor = _AM_RMDP_FSIZE . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FSIZE_DESC . '</span>';
    } else {
        $editor = _AM_RMDP_FSIZE;
    }

    $cform->addElement(new XoopsFormText($editor, 'size', 20, 20, $row['size']), false);

    $actual = "<input name='favorito' type='radio' value='1'> " . _AM_RMDP_YES . "
			<input name='favorito' type='radio' value='0' checked> " . _AM_RMDP_NO;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FFAVS, $actual, false));

    $actual = "<input name='anonimo' type='radio' value='1' ";

    if ($row['anonimo']) {
        $actual .= 'checked';
    }

    $actual .= '>	' . _AM_RMDP_YES . " <input name='anonimo' type='radio' value='0' ";

    if (0 == $row['anonimo']) {
        $actual .= 'checked';
    }

    $actual .= '>	' . _AM_RMDP_NO;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FALLOWANONIM, $actual, false));

    $select = "<select name='rating'>";

    for ($i = 0; $i <= 5; $i++) {
        if (0 == $i) {
            $select .= "<option value='$i' selected>$i</option>";
        } else {
            $select .= "<option value='$i'>$i</option>";
        }
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_RATING, $select, false));

    $actual = "<input name='resaltar' type='radio' value='1'> " . _AM_RMDP_YES . " 
			<input name='resaltar' type='radio' value='0' checked>" . _AM_RMDP_NO;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FRESALTE, $actual, false));

    $cform->addElement(new XoopsFormText(_AM_RMDP_FURLTITLE, 'urltitle', 50, 255, $row['urltitle']), false);

    $cform->addElement(new XoopsFormText(_AM_RMDP_FURL, 'url', 50, 255, $row['url']), false);

    $select = "<select name='idu'>";

    $result = $xoopsDB->query('SELECT uid, uname FROM ' . $xoopsDB->prefix('users') . ' ORDER BY uname');

    while (false !== ($rw = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$rw[uid]' ";

        if ($rw['uid'] == $row['submitter']) {
            $select .= 'selected';
        }

        $select .= ">$rw[uname]</option>";
    }

    $select .= "</select><input type='hidden' name='ids' value='$ids'>
				<input type='hidden' name='filetype' value='$row[filetype]'>
				<input type='hidden' name='imgtype' value='$row[imgtype]'>";

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_SENDBY, $select, true));

    $plats = [];

    $plats = explode('|', $row['plataformas']);

    $select = "<select name='os[]' size='5' multiple='multiple'>";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas'));

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if (in_array($row['id_os'], $plats, true)) {
            $select .= "<option value='$row[id_os]' selected='selected'>$row[nombre]</option>";
        } else {
            $select .= "<option value='$row[id_os]'>$row[nombre]</option>";
        }
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_OSS, $select), false);

    $cform->insertBreak('<strong>' . _AM_RMDP_MIRRORS_TITLE . '</strong>', 'odd');

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$ids' AND status='1'");

    $num = $xoopsDB->getRowsNum($result);

    $i = 0;

    if ($xoopsModuleConfig['mirrors'] > 0) {
        $i++;

        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_TITLE, $i), 'mirrortitle[]', 50, 100, $row['titulo']), false);

            $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_URL, $i), 'mirrorfile[]', 50, 255, $row['url']), false);

            $i++;
        }

        if ($xoopsModuleConfig['mirrors'] > $num) {
            for ($i = $i; $i <= $xoopsModuleConfig['mirrors']; $i++) {
                $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_TITLE, $i), 'mirrortitle[]', 50, 100, ''), false);

                $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_URL, $i), 'mirrorfile[]', 50, 255, ''), false);
            }
        }
    }

    $cform->addElement(new XoopsFormButton('', 'sbt', _AM_RMDP_SUBMIT, 'submit'));

    $cform->display();

    xoops_cp_footer();
}

function Save()
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig, $xoopsConfig;

    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    if ($ids <= 0) {
        header('sended.php');

        die();
    }

    if ('' == $nombre) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_ERRNAME);

        die();
    }

    if ('' == $version) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_ERRVERSION);

        die();
    }

    if ($idc <= 0) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_ERRCATEGO);

        die();
    }

    if ('' == $longdesc) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_ERRDESC);

        die();
    }

    if ('' == $size) {
        $size = 0;
    }

    $tbl = $xoopsDB->prefix('rmdp_software');

    /**
     * Comprobamos que no exista una descarga con el mismo nombre
     **/

    require dirname(__DIR__) . '/include/rmdp_downs.php';

    if (rmdp_check_download_name($nombre, $idc, 'save')) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_ERREXIST);

        die();
    }

    $xoopsDB->query(
        "INSERT INTO $tbl (`nombre`,`version`,`licencia`,`archivo`,`filetype`,`img`,
			`imgtype`,`id_cat`,`longdesc`,`size`,`favorito`,`calificacion`,`anonimo`,`resaltar`,
			`fecha`,`update`,`url`,`submitter`,`urltitle`) VALUES ('$nombre','$version','$licencia',
			'$archivo_url','$filetype','$img_url','$imgtype','$idc','$longdesc','$size','$favorito','$rating',
			'$anonimo','$resaltar','" . time() . "','" . time() . "','$url','$idu','$urltitle')"
    );

    $err = $xoopsDB->error();

    if ('' != $err) {
        redirect_header('sended.php?op=acept&amp;ids=' . $ids, 2, _AM_RMDP_CATEGOFAIL . $err);
    }

    $id_soft = $xoopsDB->getInsertId();

    /**
     * Asignamos las plataformas
     **/

    foreach ($os as $value) {
        if ($value > 0) {
            $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('rmdp_softos') . " (`id_os`,`id_soft`) VALUES ('$value','$id_soft')");
        }
    }

    /**
     * Asignamos los sitios réplica
     */

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('rmdp_mirrors') . " SET `id_soft`='$id_soft', `status`='0' WHERE id_soft='$ids' AND status='1';");

    $user = new XoopsUser($idu);

    $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_sended') . " WHERE id_soft='$ids'");

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($user->getVar('email'));

    $xoopsMailer->setFromEmail($xoopsConfig['from']);

    $xoopsMailer->setFromName($xoopsConfig['sitename'] . ' - ' . $xoopsModuleConfig['rmdptitle']);

    $xoopsMailer->setSubject(_RMDP_MAIL_SUBJECT);

    $body = $xoopsModuleConfig['bodymail'];

    $body = str_replace('{USER}', $user->getVar('uname'), $body);

    $body = str_replace('{DOWN}', $nombre, $body);

    $body = str_replace('{LINK}', XOOPS_URL . "/modules/rmdp/down.php?id=$id_soft", $body);

    $body = str_replace('{URL}', XOOPS_URL, $body);

    $xoopsMailer->setBody($body);

    $xoopsMailer->send();

    redirect_header('sended.php', 2, _AM_RMDP_SENDOK);
}

function Delete()
{
    global $xoopsDB;

    $ok = $_POST['ok'] ?? 0;

    if ($ok) {
        $ids = $_POST['ids'] ?? 0;

        if ($ids <= 0) {
            header('location: sended.php');

            die();
        }

        $tbl = $xoopsDB->prefix('rmdp_sended');

        $xoopsDB->query("DELETE FROM $tbl WHERE id_soft='$ids' AND modify='0'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$ids' AND status='1'");

        redirect_header('sended.php', 1, _AM_RMDP_DELOK);

        die();
    }

    require __DIR__ . '/functions.php';

    $ids = $_GET['ids'] ?? 0;

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='60%' align='center' class='outer' cellspacing='1'>
				<tr><td align='center' class='even'><form name='frmDel' action='sended.php' method='post'>
				<br>" . _AM_RMDP_DELCONFIRM . "<br><br>
				<input type='submit' value='" . _AM_RMDP_DELETE . "' name='sbt'> 
				<input type='button' value='" . _AM_RMDP_CANCEL . "' name='cancel' onclick='history.go(-1);'>
				<input type='hidden' name='op' value='del'>
				<input type='hidden' name='ok' value='1'>
				<input type='hidden' name='ids' value='$ids'>
				</form></td></tr></table>";

    xoops_cp_footer();
}

/**
 * Seleccionamos la opcion
 **/
$op = $_GET['op'] ?? ($_POST['op'] ?? '');
switch ($op) {
    case 'acept':
        Aceptar();
        break;
    case 'save':
        Save();
        break;
    case 'del':
        Delete();
        break;
    default:
        ShowSended();
        break;
}



