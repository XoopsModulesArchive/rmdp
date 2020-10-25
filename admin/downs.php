<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: downs.php,v 1.5 23/11/2005 13:42:53 BitC3R0 Exp $                   //
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

$location = 'descargas';
require dirname(__DIR__, 3) . '/include/cp_header.php';
if (!file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/spanish/admin.php';
}

function ShowDowns()
{
    global $xoopsDB, $xoopsModuleConfig;

    $limit = 20;

    $pag = $_GET['pag'] ?? 0;

    if ($pag > 0) {
        $pag -= 1;
    }

    $start = $pag * $limit;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " ORDER BY nombre LIMIT $start,$limit");

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software')));

    $rtotal = $num; // Numero total de resultados

    $tpages = (int)($num / $limit);

    if (($num % $limit) > 0) {
        $tpages++;
    }

    $pactual = $pag + 1;

    if ($pactual > $tpages) {
        $rest = $pactual - $tpages;

        $pactual = $pactual - $rest + 1;

        $start = ($pactual - 1) * $limit;
    }

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    DP_ShowNav();

    $idc = $_GET['idc'] ?? 0;

    $catego = DP_CategoName($idc);

    $order = '';

    echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>
		  <tr><td><a href='downs.php?op=new'>" . _AM_RMDP_NEWDOWN . "</a></td>
		  <td align='right'>";

    echo _AM_RMDP_GOPAGE;

    for ($i = 1; $i <= $tpages; $i++) {
        echo "<a href='downs.php?pag=$i&amp;sort=$order'>$i</a>&nbsp;";
    }

    echo "</td></tr></table>
		 <table width='100%' class='outer' cellspacing='1'>
			<tr><th colspan='3'>" . _AM_RMDP_DOWNSLIST . "</th></tr>
			<tr align='center' class='head'><td>" . _AM_RMDP_LISTNAME . '</td>
			<td>' . _AM_RMDP_LISTACCESS . '</td>
			<td>' . _AM_RMDP_OPTIONS . '</td></tr>';

    $class = 'odd';

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if ('even' == $class) {
            $class = 'odd';
        } else {
            $class = 'even';
        }

        echo "<tr class='$class'><td align='left'>
			<a href='../down.php?id=$row[id_soft]'>$row[nombre]</a><br>
			</td>
			<td align='center'>";

        if ($row['anonimo']) {
            echo _AM_RMDP_EVERYBODY;
        } else {
            echo _AM_RMDP_REGISTERED;
        }

        echo "</td><td align='center' style='font-size: 10px;'>
			<a href='downs.php?op=shots&amp;ids=$row[id_soft]'>" . _AM_RMDP_SOFTSHOTS . "</a> |
			<a href='downs.php?op=mod&amp;ids=$row[id_soft]'>" . _AM_RMDP_MODIFY . "</a> |
			<a href='downs.php?op=del&amp;ids=$row[id_soft]'>" . _AM_RMDP_DELETE . '</a>
			</td></tr>';
    }

    echo '</table>';

    xoops_cp_footer();
}

function NewDown()
{
    global $xoopsDB, $xoopsModuleConfig;

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    DP_ShowNav();

    $cform = new XoopsThemeForm(_AM_RMDP_NEWDOWN, 'frmNew', 'downs.php?op=save');

    $cform->setExtra('enctype="multipart/form-data"');

    $cform->addElement(new XoopsFormText(_AM_RMDP_FNAME, 'nombre', 50, 200), true);

    $cform->addElement(new XoopsFormText(_AM_RMDP_FVERSION, 'version', 15, 10), true);

    $select = "<select name='licencia' id='licencia'>
			<option value='0'>Ninguna</option>";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_licences') . ' ORDER BY nombre');

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$row[id_lic]'>$row[nombre]</option>";
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FLICENSE, $select, false));

    /** Archivos **/

    if (1 == $xoopsModuleConfig['filesend']) {
        $cform->addElement(
            new XoopsFormLabel(
                _AM_RMDP_FFILE . "<br><span style='font-size: 10px;'>" . sprintf(_AM_RMDP_MAXSIZE, (rmdp_convert_size($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']))) . '</span>',
                "<input type='hidden' name='MAX_FILE_SIZE' value='" . (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']) . "'>
			<input name='archivo' type='file' id='archivo' size='50'>",
                false
            )
        );
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FFILEURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FFILEURL_DESC . '</span>', 'archivo_url', 50, 255), false);

    if (1 == $xoopsModuleConfig['imagesend']) {
        $cform->addElement(new XoopsFormLabel(_AM_RMDP_FIMG, "<input name='img' type='file' id='img' size='50' >", false));
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FIMGURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FIMGURL_DESC . '</span>', 'img_url', 50, 255), false);

    $select = "<select name='idc' id='idc'><option value='0' selected>" . _AM_RMDP_SELECT . '</option>';

    $select .= DP_ChildCategoOption() . '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_FCATEGO, $select, false));

    $editor = rmdpGetEditor(_AM_RMDP_FLONG, 'longdesc', '', '100%', '150px', '');

    $cform->addElement($editor, true);

    if (1 == $xoopsModuleConfig['filesend']) {
        $editor = _AM_RMDP_FSIZE . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FSIZE_DESC . '</span>';
    } else {
        $editor = _AM_RMDP_FSIZE;
    }

    $cform->addElement(new XoopsFormText($editor, 'size', 20, 20), false);

    $cform->addElement(
        new XoopsFormLabel(
            _AM_RMDP_FFAVS,
            "<input name='favorito' type='radio' value='1'> 
      		" . _AM_RMDP_YES . "
        	<input name='favorito' type='radio' value='0' checked> 
      		" . _AM_RMDP_NO,
            false
        )
    );

    $cform->addElement(
        new XoopsFormLabel(
            _AM_RMDP_FALLOWANONIM,
            "<input name='anonimo' type='radio' value='1'>
  			" . _AM_RMDP_YES . "
  			<input name='anonimo' type='radio' value='0' checked>
  			" . _AM_RMDP_NO,
            false
        )
    );

    $cform->addElement(
        new XoopsFormLabel(
            _AM_RMDP_RATING,
            "<select name='rating'>
			<option value='0'>0</option>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
			</select>",
            false
        )
    );

    $cform->addElement(
        new XoopsFormLabel(
            _AM_RMDP_FRESALTE,
            "<input name='resaltar' type='radio' value='1'> " . _AM_RMDP_YES . "
			<input name='resaltar' type='radio' value='0' checked> " . _AM_RMDP_NO,
            false
        )
    );

    $cform->addElement(new XoopsFormText(_AM_RMDP_FURLTITLE, 'urltitle', 50, 255), false);

    $cform->addElement(new XoopsFormText(_AM_RMDP_FURL, 'url', 50, 255), false);

    $select = "<select name='os[]' multiple='multiple' size='5'>";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas') . ' ORDER BY nombre');

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$row[id_os]'>$row[nombre]</option>";
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_OSS, $select), false);

    $cform->insertBreak('<strong>' . _AM_RMDP_MIRRORS_TITLE . '</strong>', 'odd');

    if ($xoopsModuleConfig['mirrors'] > 0) {
        for ($i = 1; $i <= $xoopsModuleConfig['mirrors']; $i++) {
            $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_TITLE, $i), 'mirrortitle[]', 50, 100), false);

            $cform->addElement(new XoopsFormText(sprintf(_AM_RMDP_ITEMMIR_URL, $i), 'mirrorfile[]', 50, 255), false);
        }
    }

    $cform->addElement(new XoopsFormButton('', 'sbt', _AM_RMDP_SUBMIT, 'submit'));

    $cform->display();

    xoops_cp_footer();
}

function SaveDown()
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;

    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    if ('' == $nombre) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRNAME);

        die();
    }

    if ('' == $version) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRVERSION);

        die();
    }

    if (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        if ('' == $archivo_url) {
            redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRVFILE);

            die();
        }

        $filetype = 0;
    } else {
        if (filesize($_FILES['archivo']['tmp_name']) > (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit'])) {
            redirect_header('downs.php?op=new', 1, _AM_RMDP_ERRSIZE);

            die();
        }

        $size = filesize($_FILES['archivo']['tmp_name']);

        $filetype = 1;
    }

    if ($idc <= 0) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRCATEGO);

        die();
    }

    if ('' == $longdesc) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRDESC);

        die();
    }

    if ($size <= 0) {
        $size = 0;
    }

    $tbl = $xoopsDB->prefix('rmdp_software');

    [$num] = $xoopsDB->query("SELECT COUNT(*) FROM $tbl WHERE nombre='$nombre' AND id_cat='$idc'");

    if ($num > 0) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERREXIST);

        die();
    }

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    /**
     * Guardamos el archivo
     */

    if (1 == $filetype) {
        // Comprobamos si existe un archivo con el mismo nombre

        $ok = false;

        $directorio = str_replace('{XOOPS_PATH}', XOOPS_ROOT_PATH, $xoopsModuleConfig['softdir']);

        $directorio = str_replace('{RMDP_PATH}', XOOPS_ROOT_PATH . '/modules/rmdp', $directorio);

        do {
            $file_name = rmdpRandomWord('8', date('My')) . '_' . $_FILES['archivo']['name'];

            if (!file_exists($directorio . "/$file_name")) {
                $ok = true;
            }
        } while (false === $ok);

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $directorio . "/$file_name")) {
            redirect_header('downs.php?op=new', 2, sprintf(_AM_RMDP_ERRMOVEFILE, $directorio));

            die();
        }
    } else {
        $file_name = $archivo_url;
    }

    /**
     * Guardamos la imágen
     */

    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        $imgtype = 1;

        $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/';

        $ext = mb_strrchr($_FILES['img']['name'], '.');

        do {
            $img_name = rmdpRandomWord('15', date('My_')) . $ext;

            if (!file_exists($dir_imgs . $img_name)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $dir_imgs . $img_name)) {
            unlink($directorio . $file_name);

            redirect_header('downs.php?op=new', 2, sprintf(_AM_RMDP_ERRMOVEFILE, $dir_imgs));

            die();
        }

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgdownw']);
    } else {
        $imgtype = 0;

        $img_name = $img_url;
    }

    $xoopsDB->query(
        "INSERT INTO $tbl (`nombre`,`version`,`licencia`,`archivo`,`filetype`,`img`,
			`imgtype`,`id_cat`,`longdesc`,`size`,`favorito`,`calificacion`,`anonimo`,`resaltar`,
			`fecha`,`update`,`url`,`submitter`,`urltitle`) VALUES ('$nombre','$version','$licencia',
			'$file_name','$filetype','$img_name','$imgtype','$idc','$longdesc','$size','$favorito','$rating',
			'$anonimo','$resaltar','" . time() . "','" . time() . "','$url','" . $xoopsUser->getvar('uid') . "','$urltitle')"
    );

    $err = $xoopsDB->error();

    if ('' != $err) {
        if (1 == $filetype) {
            unlink($directorio . $file_name);
        }

        if (1 == $img_type) {
            unlink($dir_imgs . $img_name);
        }

        redirect_header('downs.php?op=new', 2, _AM_RMDP_CATEGOFAIL . $err);
    }

    $id = $xoopsDB->getInsertId();

    /**
     * Guardamos las replicas
     */

    $i = 0;

    foreach ($mirrortitle as $k) {
        if ('' != $k) {
            $xoopsDB->query(
                'INSERT INTO ' . $xoopsDB->prefix('rmdp_mirrors') . " (`id_soft`,`titulo`,`url`)
				VALUES('$id','$k','" . $mirrorfile[$i] . "');"
            );
        }

        $i++;
    }

    /**
     * Guardamos las plataformas
     */

    foreach ($os as $key) {
        $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('rmdp_softos') . " (`id_soft`,`id_os`) VALUES ('$id','$key');");
    }

    redirect_header('categos.php?op=view&amp;idc=' . $idc, 2, _AM_RMDP_DOWNOK);
}

function Modify()
{
    global $xoopsDB, $xoopsModuleConfig;

    $ids = $_GET['ids'];

    if ($ids <= 0) {
        header('location: downs.php?op=new');

        die();
    }

    $tbl = $xoopsDB->prefix('rmdp_software');

    $result = $xoopsDB->query("SELECT * FROM $tbl WHERE id_soft='$ids'");

    $num = $xoopsDB->getRowsNum($result);

    /**
     * Si no encontramos la descarga redirigimos a otro lugar
     */

    if ($num <= 0) {
        redirect_header('downs.php', 2, _AM_RMDP_ERRNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    xoops_cp_header();

    require __DIR__ . '/functions.php';

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    DP_ShowNav();

    $cform = new XoopsThemeForm(_AM_RMDP_MODDOWN, 'frmMod', 'downs.php?op=savemod');

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

    if (1 == $xoopsModuleConfig['filesend']) {
        if (1 == $row['filetype']) {
            $actual = '<br>' . sprintf(_AM_RMDP_ACTUAL, $row['archivo']);
        } else {
            $actual = '';
        }

        $cform->addElement(
            new XoopsFormLabel(
                _AM_RMDP_FFILE . "<br><span style='font-size: 10px;'>" . sprintf(_AM_RMDP_MAXSIZE, (rmdp_convert_size($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']))) . '</span>',
                "<input type='hidden' name='MAX_FILE_SIZE' value='" . (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']) . "'>
			<input name='archivo' type='file' id='archivo' size='50'>$actual",
                false
            )
        );
    }

    if (0 == $row['filetype']) {
        $actual = $row['archivo'];
    } else {
        $actual = '';
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FFILEURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FFILEURL_DESC . '</span>', 'archivo_url', 50, 255, $actual), false);

    if (1 == $xoopsModuleConfig['imagesend']) {
        if (1 == $row['imgtype']) {
            $actual = '<br>' . sprintf(_AM_RMDP_ACTUAL, "<br><img src='../uploads/$row[img]' border='1'>");
        } else {
            $actual = '';
        }

        $cform->addElement(new XoopsFormLabel(_AM_RMDP_FIMG, "<input name='img' type='file' id='img' size='50' > $actual", false));
    }

    if (0 == $row['imgtype'] && '' != $row['img']) {
        $actual = (string)$row[img];
    } else {
        $actual = '';
    }

    $cform->addElement(new XoopsFormText(_AM_RMDP_FIMGURL . "<br><span style='font-size: 10px;'>" . _AM_RMDP_FIMGURL_DESC . '</span>', 'img_url', 50, 255, $actual), false);

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

    $actual = "<input name='favorito' type='radio' value='1' ";

    if ($row['favorito']) {
        $actual .= 'checked';
    }

    $actual .= '> ' . _AM_RMDP_YES . "<input name='favorito' type='radio' value='0' ";

    if (0 == $row['favorito']) {
        $actual .= 'checked';
    }

    $actual .= '> ' . _AM_RMDP_NO;

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
        if ($i == $row['calificacion']) {
            $select .= "<option value='$i' selected>$i</option>";
        } else {
            $select .= "<option value='$i'>$i</option>";
        }
    }

    $select .= '</select>';

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_RATING, $select, false));

    $actual = "<input name='resaltar' type='radio' value='1' ";

    if ($row['resaltar']) {
        $actual .= 'checked';
    }

    $actual .= '> ' . _AM_RMDP_YES . " <input name='resaltar' type='radio' value='0' ";

    if (0 == $row['resaltar']) {
        $actual .= 'checked';
    }

    $actual .= '> ' . _AM_RMDP_NO;

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

    $select .= "</select><input type='hidden' name='ids' value='$ids'>";

    $cform->addElement(new XoopsFormLabel(_AM_RMDP_SENDBY, $select, true));

    $select = "<select name='os[]' multiple='multiple' size='5'>";

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_softos') . " WHERE id_soft='$ids'");

    $plats = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $plats[] = $row['id_os'];
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas') . ' ORDER BY nombre');

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

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$ids' AND status='0'");

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

function SaveMod()
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;

    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    if ($ids <= 0) {
        header('location: downs.php');

        die();
    }

    if ('' == $nombre) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRNAME);

        die();
    }

    if ('' == $version) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRVERSION);

        die();
    }

    if ($idc <= 0) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRCATEGO);

        die();
    }

    if ('' == $longdesc) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRDESC);

        die();
    }

    $tbl = $xoopsDB->prefix('rmdp_software');

    $result = $xoopsDB->query("SELECT * FROM $tbl WHERE id_soft='$ids'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('downs.php?op=new', 2, _AM_RMDP_ERRNOEXIST);

        die();
    }

    $row = $xoopsDB->fetchArray($result);

    $directorio = str_replace('{XOOPS_PATH}', XOOPS_ROOT_PATH, $xoopsModuleConfig['softdir']);

    $directorio = str_replace('{RMDP_PATH}', XOOPS_ROOT_PATH . '/modules/rmdp', $directorio);

    /**
     * Comprobamos el archivo
     */

    require dirname(__DIR__) . '/include/rmdp_functions.php';

    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        $ok = false;

        $filetype = 1;

        $filemod = true;

        $size = filesize($_FILES['archivo']['tmp_name']);

        // Eliminamos el archivo anterior

        if (1 == $row['filetype']) {
            unlink($directorio . '/' . $row['archivo']);
        }

        do {
            $file_name = rmdpRandomWord('8', date('My')) . '_' . $_FILES['archivo']['name'];

            if (!file_exists($directorio . "/$file_name")) {
                $ok = true;
            }
        } while (false === $ok);

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $directorio . "/$file_name")) {
            redirect_header('downs.php?op=new', 2, sprintf(_AM_RMDP_ERRMOVEFILE, $directorio));

            die();
        }
    } elseif ('' != $archivo_url) {
        if (1 == $row['filetype']) {
            unlink($directorio . '/' . $row['archivo']);
        }

        $size = ($size > 0) ? $size : 0;

        $file_name = $archivo_url;

        $filetype = 0;

        $filemod = true;
    } else {
        $file_name = $row['archivo'];

        $size = $row['size'];

        $filemod = false;

        $filetype = $row['filetype'];
    }

    /**
     * Comprobamos la imágen
     */

    /**
     * Guardamos la imágen
     */

    $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/';

    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        $imgtype = 1;

        $ext = mb_strrchr($_FILES['img']['name'], '.');

        // eliminamos la imágen anterior

        if (1 == $row['imgtype']) {
            unlink($dir_imgs . $row['img']);
        }

        do {
            $img_name = rmdpRandomWord('15', date('My_')) . $ext;

            if (!file_exists($dir_imgs . $img_name)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $dir_imgs . $img_name)) {
            unlink($directorio . $file_name);

            redirect_header('downs.php?op=new', 2, sprintf(_AM_RMDP_ERRMOVEFILE, $dir_imgs));

            die();
        }

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgdownw']);
    } elseif ('' != $img_url) {
        if (1 == $row['imgtype']) {
            unlink($dir_imgs . $row['img']);
        }

        $imgtype = 0;

        $img_name = $img_url;
    } else {
        $img_name = $row['img'];

        $imgtype = $row['imgtype'];
    }

    if ($filemod) {
        $xoopsDB->query(
            "UPDATE $tbl SET `nombre`='$nombre',`version`='$version',
			`licencia`='$licencia',`archivo`='$file_name',`filetype`='$filetype',
			`img`='$img_name',`imgtype`='$imgtype',`id_cat`='$idc',
			`longdesc`='$longdesc',`size`='$size',`favorito`='$favorito',`calificacion`='$rating',
			`anonimo`='$anonimo',`resaltar`='$resaltar',`update`='" . time() . "',
			`url`='$url',`submitter`='$idu',
			`urltitle`='$urltitle' WHERE id_soft='$ids'"
        );
    } else {
        $xoopsDB->query(
            "UPDATE $tbl SET `nombre`='$nombre',`version`='$version',
			`licencia`='$licencia',`img`='$img_name',`imgtype`='$imgtype',`id_cat`='$idc',
			`longdesc`='$longdesc',`favorito`='$favorito',`calificacion`='$rating',
			`anonimo`='$anonimo',`resaltar`='$resaltar',`update`='" . time() . "',
			`url`='$url',`submitter`='$idu',
			`urltitle`='$urltitle' WHERE id_soft='$ids'"
        );
    }

    $err = $xoopsDB->error();

    if ('' != $err) {
        redirect_header('categos.php?op=view&amp;idc=' . $idc, 2, _AM_RMDP_CATEGOFAIL . $err);
    }

    /**
     * Guardamos las replicas
     */

    $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$ids'");

    $i = 0;

    foreach ($mirrortitle as $k) {
        if ('' != $k) {
            $xoopsDB->query(
                'INSERT INTO ' . $xoopsDB->prefix('rmdp_mirrors') . " (`id_soft`,`titulo`,`url`)
				VALUES('$ids','$k','" . $mirrorfile[$i] . "');"
            );
        }

        $i++;
    }

    /**
     * Guardamos las plataformas
     */

    $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_softos') . " WHERE id_soft='$ids'");

    foreach ($os as $key) {
        $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('rmdp_softos') . " (`id_soft`,`id_os`) VALUES ('$ids','$key');");
    }

    redirect_header('categos.php?op=view&amp;idc=' . $idc, 2, _AM_RMDP_DOWNMODOK);
}

function Delete()
{
    global $xoopsDB;

    $ok = $_POST['ok'];

    $ids = $_GET['ids'];

    if ($ids <= 0) {
        $ids = $_POST['ids'];
    }

    if ($ids <= 0) {
        header('location: downs.php');

        die();
    }

    if ($ok) {
        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_softos') . " WHERE id_soft='$ids'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$ids'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_partners') . " WHERE id_soft='$ids'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$ids'");

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$ids'");

        redirect_header('downs.php', 2, _AM_RMDP_DELOK);
    } else {
        xoops_cp_header();

        require __DIR__ . '/functions.php';

        DP_ShowNav();

        echo "<table width='60%' align='center' cellspacing='1' class='outer'>
				<tr><td align='center' class='even'>
				<form name='frmDel' method='post' action='downs.php'>
				<br><br>" . _AM_RMDP_CONFIRM . "<br><br>
				<input type='submit' name='sbt' value='" . _AM_RMDP_DELETE . "'>
				<input type='button' value='" . _AM_RMDP_CANCEL . "' name='cancel' onClick='history.go(-1);'>
				<input type='hidden' name='op' value='del'>
				<input type='hidden' name='ids' value='$ids'>
				<input type='hidden' name='ok' value='1'>
				</td></tr></table>";

        xoops_cp_footer();
    }
}

function reviews()
{
    global $xoopsDB;

    $ids = $_GET['ids'] ?? 0;

    if ($ids <= 0) {
        header('location: downs.php');

        die();
    }

    require __DIR__ . '/functions.php';

    require XOOPS_ROOT_PATH . '/include/xoopscodes.php';

    xoops_cp_header();

    DP_ShowNav();

    echo "<table width='100%' cellspacing='1' class='outer'>
			<tr><th colspan='2'>" . _AM_RMDP_REVIEWTITLE . "</th></tr>
			<form name='frmRev' method='post' action='downs.php'>
			<tr><td class='even' align='left'>" . _AM_RMDP_SHOTDOWN . "</td>
			<td class='odd' align='left'><strong>" . DP_DownloadName($ids) . "</strong></td>
			</tr><tr align='left'><td class='even'>" . _AM_RMDP_REVIEW . "</td>
			<td class='odd'>
			";

    [$text] = $xoopsDB->fetchRow($xoopsDB->query('SELECT text FROM ' . $xoopsDB->prefix('rmdp_editorcom') . " WHERE id_soft='$ids'"));

    $GLOBALS['text'] = $text;

    xoopsCodeTarea('text', 20, 15);

    xoopsSmilies('text');

    echo "</td></tr>
		  <tr align='left'><td class='even'>" . _AM_RMDP_RATING . "</td>
		  <td class='odd'><select name='rate'>";

    [$rate] = $xoopsDB->fetchRow($xoopsDB->query('SELECT calificacion FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$ids'"));

    for ($i = 1; $i <= 5; $i++) {
        if ($i == $rate) {
            echo "<option value='$i' selected>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }

    echo "</td></tr>
		  <tr align='left'><td class='even'>&nbsp;</td>
		  <td class='odd'><input type='submit' name='sbt' value='" . _AM_RMDP_MODIFY . "'>
		  <input type='hidden' name='op' value='savereview'>
		  <input type='hidden' name='ids' value='$ids'></td></tr></form></table>";

    xoops_cp_footer();
}

function savereview()
{
    global $xoopsDB;

    $ids = $_POST['ids'] ?? 0;

    $text = $_POST['text'] ?? '';

    $rate = $_POST['rate'] ?? 0;

    if ($ids <= 0) {
        header('downs.php');

        die();
    }

    if ('' == $text) {
        header('downs.php?op=review&ids=' . $ids);

        die();
    }

    $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_editorcom') . " WHERE id_soft='$ids'");

    $xoopsDB->query(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_editorcom') . " (`id_soft`,`text`,`fecha`)
			VALUES ('$ids','$text','" . time() . "')"
    );

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('rmdp_software') . " SET `calificacion`='$rate' WHERE id_soft='$ids'");

    redirect_header('downs.php?op=review&amp;ids=' . $ids, 1, _AM_RMDP_REVIEWOK);
}

/*
function View(){
    Funcion para ver todas las propiedades de las descargas
}
*/

/**
 * Seleccionamos el tipo de acción
 */
$op = $_GET['op'] ?? ($_POST['op'] ?? '');

switch ($op) {
    case 'new':
        NewDown();
        break;
    case 'save':
        SaveDown();
        break;
    case 'mod':
        Modify();
        break;
    case  'savemod':
        SaveMod();
        break;
    case 'del':
        Delete();
        break;
    case 'cars':
        Caracteristicas();
        break;
    case 'savecar':
        SaveCar();
        break;
    case 'modcar':
        ModifyCar();
        break;
    case 'savemodcar':
        SaveModCar();
        break;
    case 'delcar':
        DelCar();
        break;
    case 'os':
        Plataformas();
        break;
    case 'addos':
        AddOs();
        break;
    case 'delos':
        DelOs();
        break;
    case 'sended':
        Sended();
        break;
    case 'shots':
        require __DIR__ . '/shots.php';
        break;
    case 'review':
        reviews();
        break;
    case 'savereview':
        savereview();
        break;
    default:
        ShowDowns();
        break;
}




