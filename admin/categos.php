<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: categos.php,v 1.5 23/11/2005 13:42:52 BitC3R0 Exp $                 //
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

$location = 'categorias';

require dirname(__DIR__, 3) . '/include/cp_header.php';
if (!file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/spanish/admin.php';
}

function ShowCategos()
{
    global $xoopsDB;

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . ' ORDER BY nombre'));

    if ($num <= 0) {
        header('location: categos.php?op=new');

        die();
    }

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<a href='categos.php?op=new'>" . _AM_RMDP_NEWCATEGO . "</a><br>
		  <table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='3' align='left'>" . _AM_RMDP_CATEGOLIST . "</th></tr>
			<tr align='center'><td class='head'>" . _AM_RMDP_LNAME . "</td>
			<td class='head'>" . _AM_RMDP_LACCESS . "</td>
			<td class='head'>" . _AM_RMDP_OPTIONS . '</td></tr>';

    DP_ChildCatego();

    echo '</table>';

    xoops_cp_footer();
}

function NewForm()
{
    global $xoopsDB, $xoopsModuleConfig;

    require __DIR__ . '/functions.php';

    xoops_cp_header();

    DP_ShowNav();

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $cform = new XoopsThemeForm(_AM_RMDP_NEWCATEGO, 'newCat', 'categos.php?op=save');

    $cform->setExtra('enctype="multipart/form-data"');

    $cform->addElement(new XoopsFormText(_AM_RMDP_FNAME, 'nombre', 50, 200), true);

    $element = "<select name='parent' id='parent'>
      		<option value='0' selected='selected'>" . _AM_RMDP_SELECT . '</option>' . DP_ChildCategoOption() . '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FPARENT, $element, false));

    $element = "<input name='acceso' type='radio' value='0' checked> 
      		" . _AM_RMDP_EVERYBODY . " &nbsp;&nbsp;
      		<input name='acceso' type='radio' value='1'> 
      		" . _AM_RMDP_REGISTERED;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FACCESS, $element, false));

    if (1 == $xoopsModuleConfig['imagesend']) {
        $cform->addElement(new XoopsFormLabel(_AM_RMDP_FIMG, "<input name='img' type='file' id='img' size='50' >", false));
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FIMGURL, 'img_url', 50, 200), false);

    $element = "<input name='shownews' type='radio' value='1'> " . _AM_RMDP_YES . " &nbsp;
			<input name='shownews' type='radio' value='0' checked> " . _AM_RMDP_NO;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_SHOWNEWS, $element, false));

    $cform->addElement(new XoopsFormButton('', 'sbt', _AM_RMDP_SUBMIT, 'submit'));

    $cform->display();

    xoops_cp_footer();
}

function ModForm()
{
    global $xoopsDB, $xoopsModuleConfig;

    $idc = $_GET['idc'];

    $table = $xoopsDB->prefix('rmdp_categos');

    if ($idc <= 0) {
        header('location: categos.php');

        die();
    }

    $result = $xoopsDB->query("SELECT * FROM $table WHERE id_cat='$idc'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('categos.php', 1, _AM_NOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    require __DIR__ . '/functions.php';

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    xoops_cp_header();

    DP_ShowNav();

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $cform = new XoopsThemeForm(_AM_RMDP_MODCATEGO, 'newCat', 'categos.php?op=savemod');

    $cform->setExtra('enctype="multipart/form-data"');

    $cform->addElement(new XoopsFormText(_AM_RMDP_FNAME, 'nombre', 50, 200, $row['nombre']), true);

    $element = "<select name='parent' id='parent'>
      		<option value='0' ";

    if (0 == $row['parent']) {
        $element .= "selected='selected'";
    }

    $element .= '>' . _AM_RMDP_SELECT . '</option>' . DP_ChildCategoOption(0, 0, $row['parent']) . '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FPARENT, $element, false));

    $element = "<input name='acceso' type='radio' value='0' ";

    if (0 == $row['acceso']) {
        $element .= 'checked';
    }

    $element .= '> ' . _AM_RMDP_EVERYBODY . " &nbsp;&nbsp;
      		<input name='acceso' type='radio' value='1' ";

    if (1 == $row['acceso']) {
        $element .= 'checked ';
    }

    $element .= '> ' . _AM_RMDP_REGISTERED;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FACCESS, $element, false));

    if (1 == $xoopsModuleConfig['imagesend']) {
        $element = (1 == $row['imgtype']) ? '<br>' . sprintf(_AM_RMDP_ACTUAL, "<br><img src='../uploads/$row[img]' border='0'>") : '';

        $cform->addElement(new XoopsFormLabel(_AM_RMDP_FIMG, "<input name='img' type='file' id='img' size='50' > $element", false));
    }

    $element = (0 == $row['imgtype']) ? $row['img'] : '';

    $cform->addElement(new XoopsFormText(_AM_RMDP_FIMGURL, 'img_url', 50, 200, $element), false);

    if ('' != $row['img'] && 0 == $row['imgtype']) {
        $element = sprintf(_AM_RMDP_ACTUAL, "<br><img src='$row[img]' border='0'>");

        $cform->addElement(new XoopsFormLabel('', $element, false));
    }

    $element = "<input name='shownews' type='radio' value='1' ";

    if (1 == $row['shownews']) {
        $element .= 'checked';
    }

    $element .= '> ' . _AM_RMDP_YES . " &nbsp;<input name='shownews' type='radio' value='0' ";

    if (0 == $row['shownews']) {
        $element .= 'checked';
    }

    $element .= '> ' . _AM_RMDP_NO;

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_SHOWNEWS, $element, false));

    $element = "<input type='hidden' name='idc' value='$idc'>";

    $element .= "<input type='submit' name='sbt' value='" . _AM_RMDP_MODIFY . "'>
			<input type='button' name='cancel' value='" . _AM_RMDP_CANCEL . "' onClick='history.go(-1);'>";

    $cform->addElement(new XoopsFormLabel('', $element, false));

    $cform->display();

    xoops_cp_footer();
}

function SaveCatego()
{
    global $xoopsDB;

    $nombre = $_POST['nombre'];

    $parent = $_POST['parent'];

    $acceso = $_POST['acceso'];

    $img = $_POST['img'];

    $shownews = $_POST['shownews'];

    $fecha = time();

    if ('' == $nombre) {
        redirect_header('categos.php?op=new', 2, _AM_RMDP_ERRNAME);

        die();
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE nombre='$nombre'"));

    if ($num > 0) {
        redirect_header('categos.php?op=new', 2, _AM_RMDP_ERREXIST);

        die();
    }

    if (is_uploaded_file($_FILES['img']['tmp_name']) && 1 == $xoopsModuleConfig['imagesend']) {
        $imgtype = 1;

        $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/';

        $ext = mb_strrchr($_FILES['img']['name'], '.');

        do {
            $img_name = rmdpRandomWord('13', date('My_')) . $ext;

            if (!file_exists($dir_imgs . $img_name)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $dir_imgs . $img_name)) {
            unlink($directorio . $file_name);

            redirect_header('categos.php?op=new', 2, sprintf(_AM_RMDP_ERRMOVEFILE, $dir_imgs));

            die();
        }

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgcategow']);
    } else {
        $imgtype = 0;

        $img_name = $img_url;
    }

    $xoopsDB->query(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_categos') . " (`nombre`,`parent`,`acceso`,`img`,`imgtype`,`fecha`,`shownews`) VALUES
			('$nombre','$parent','$acceso','$img_name','$imgtype','$fecha','$shownews')"
    );

    $err = $xoopsDB->error();

    if ('' == $err) {
        redirect_header('categos.php', 2, _AM_RMDP_CATEGOOK);

        die();
    }

    redirect_header('categos.php?op=new', 2, _AM_RMDP_CATEGOFAIL);

    die();
}

function SaveMod()
{
    global $xoopsDB, $xoopsModuleConfig;

    foreach ($_POST as $k => $v) {
        $$k = $v;
    }

    $fecha = time();

    if ($idc <= 0) {
        header('location: categos.php');

        die();
    }

    if ('' == $nombre) {
        redirect_header('categos.php?op=new', 2, _AM_RMDP_ERRNAME);

        die();
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$idc'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('categos.php', 2, _AM_RMDP_ERRNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    if (is_uploaded_file($_FILES['img']['tmp_name']) && 1 == $xoopsModuleConfig['imagesend']) {
        $imgtype = 1;

        $imgmod = true;

        $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/';

        // eliminamos la imagen anterior

        if (1 == $row['imgtype']) {
            unlink($dir_imgs . $row['img']);
        }

        $ext = mb_strrchr($_FILES['img']['name'], '.');

        do {
            $img_name = rmdpRandomWord('13', date('My_')) . $ext;

            if (!file_exists($dir_imgs . $img_name)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $dir_imgs . $img_name)) {
            unlink($directorio . $file_name);

            redirect_header('categos.php?op=mod&amp;idc=' . $idc, 2, sprintf(_AM_RMDP_ERRMOVEFILE, $dir_imgs));

            die();
        }

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgcategow']);
    } elseif ('' != $img_url) {
        $imgtype = 0;

        $img_name = $img_url;

        $imgmod = true;
    } else {
        $imgmod = false;
    }

    if ($imgmod) {
        $xoopsDB->query(
            'UPDATE ' . $xoopsDB->prefix('rmdp_categos') . " SET `nombre`='$nombre',`parent`='$parent',
			`acceso`='$acceso',`img`='$img_name',`imgtype`='$imgtype',`fecha`='$fecha',`shownews`='$shownews' WHERE id_cat='$idc'"
        );
    } else {
        $xoopsDB->query(
            'UPDATE ' . $xoopsDB->prefix('rmdp_categos') . " SET `nombre`='$nombre',`parent`='$parent',
			`acceso`='$acceso',`fecha`='$fecha',`shownews`='$shownews' WHERE id_cat='$idc'"
        );
    }

    $err = $xoopsDB->error();

    if ('' == $err) {
        redirect_header('categos.php', 2, _AM_RMDP_CATEGOMODOK);

        die();
    }

    redirect_header('categos.php', 2, _AM_RMDP_CATEGOFAIL . $err);

    die();
}

function Delete()
{
    global $xoopsDB;

    $ok = $_POST['ok'];

    $idc = $_POST['idc'];

    if ('' == $idc) {
        $idc = $_GET['idc'];
    }

    if ($idc <= 0) {
        header('location: categos.php');

        die();
    }

    if ($ok) {
        $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('rmdp_categos') . " SET parent='0' WHERE parent='$idc'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$idc'");

        redirect_header('categos.php', 2, _AM_RMDP_DELOK);
    } else {
        xoops_cp_header();

        require __DIR__ . '/functions.php';

        DP_ShowNav();

        echo "<table width='60%' align='center' cellspacing='1' class='outer'>
				<tr><td align='center' class='even'>
				<form name='frmDel' method='post' action='categos.php'>
				<br><br>" . _AM_RMDP_CONFIRM . "<br><br>
				<input type='submit' name='sbt' value='" . _AM_RMDP_DELETE . "'>
				<input type='button' value='" . _AM_RMDP_CANCEL . "' name='cancel' onClick='history.go(-1);'>
				<input type='hidden' name='op' value='del'>
				<input type='hidden' name='idc' value='$idc'>
				<input type='hidden' name='ok' value='1'>
				</td></tr></table>";

        xoops_cp_footer();
    }
}

/**
 * Mostramos una lista de las descargas que
 * pertenecen a esta categoría
 */
function View()
{
    global $xoopsDB;

    $idc = $_GET['idc'];

    if ($idc <= 0) {
        header('location: categos.php');

        die();
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_cat='$idc' ORDER BY nombre");

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    DP_ShowNav();

    $catego = DP_CategoName($idc);

    echo "<a href='downs.php?op=new'>" . _AM_RMDP_NEWDOWN . "</a><br>
		 <table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='2'>" . sprintf(_AM_RMDP_DOWNSLIST, $catego) . '</th></tr>';

    $class = 'odd';

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if ('even' == $class) {
            $class = 'odd';
        } else {
            $class = 'even';
        }

        echo "<tr class='$class'><td align='left'>
			<a href='../down.php?id=$row[id_soft]'>$row[nombre]</a>
			</td>
			<td align='center' style='font-size: 10px;'>
			<a href='downs.php?op=shots&amp;ids=$row[id_soft]'>" . _AM_RMDP_SOFTSHOTS . "</a> |
			<a href='downs.php?op=mod&amp;ids=$row[id_soft]'>" . _AM_RMDP_MODIFY . "</a> |
			<a href='downs.php?op=del&amp;ids=$row[id_soft]'>" . _AM_RMDP_DELETE . '</a>
			</td></tr>';
    }

    echo '</table>';

    xoops_cp_footer();
}

/**
 * Seleccionamos las opciones para ejecutar
 */
$op = $_GET['op'] ?? ($_POST['op'] ?? '');

switch ($op) {
    case 'new':
        NewForm();
        break;
    case 'save':
        SaveCatego();
        break;
    case 'mod':
        ModForm();
        break;
    case 'savemod':
        SaveMod();
        break;
    case 'del':
        Delete();
        break;
    case 'view':
        View();
        break;
    default:
        ShowCategos();
        break;
}




