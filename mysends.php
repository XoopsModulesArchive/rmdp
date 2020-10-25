<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: mysends.php,v 1.5 23/11/2005 13:39:23 BitC3R0 Exp $                 //
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

$rmdp_location = 'mysends';
require __DIR__ . '/header.php';

if ('' == $xoopsUser) {
    redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_FIRST_LOGIN);

    die();
}

/**
 * Seleccionamos la opcion
 **/
$op = $_GET['op'] ?? '';
if ('' == $op) {
    $op = $_POST['op'] ?? '';
}

require __DIR__ . '/include/rmdp_functions.php';
require __DIR__ . '/include/rmdp_downs.php'; // Archivo para manejo de descargas

if ('' == $op) {
    /**
     * Seleccionamos las descargas del usuario actual
     **/

    if ($xoopsUserIsAdmin) {
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE submitter='" . $xoopsUser->getVar('uid') . "' OR submitter='0' ORDER BY nombre");
    } else {
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE submitter='" . $xoopsUser->getVar('uid') . "' ORDER BY nombre");
    }

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        redirect_header('index.php', 1, _RMDP_NOHAVE_DOWNS);

        die();
    }

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_show_sends.html';

    // Ubicación

    $location_bar = '<a href="index.php">' . $xoopsModuleConfig['rmdptitle'] . '</a> &gt;
		<a href="mysends.php">' . _RMDP_MY_SENDS . '</a>';

    $xoopsTpl->assign('location_bar', $location_bar);

    rmdp_make_searchnav();

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append(
            'downloads',
            [
                'id' => $row['id_soft'],
'nombre' => $row['nombre'],
'fecha' => date($xoopsModuleConfig['dateformat'], $row['fecha']),
'descargas' => $row['descargas'],
            ]
        );
    }

    $xoopsTpl->assign('lang_mydowns', _RMDP_MY_SENDS);

    $xoopsTpl->assign('lang_modify', _RMDP_MODIFY_DOWN);

    $xoopsTpl->assign('lang_name', _RMDP_NAME_DOWN);

    $xoopsTpl->assign('lang_date', _RMDP_DATE_DOWN);

    $xoopsTpl->assign('lang_downs', _RMDP_DOWNS_DOWN);

    $xoopsTpl->assign('lang_options', _RMDP_OPTIONS_DOWN);

    $xoopsTpl->assign('lang_shots', _RMDP_SEND_SHOTS);
} elseif ('modify' == $op) {
    /**
     * Comprobamos que se haya especificado un id de descarga
     * de lo contarios regresamos
     **/

    $id = $_GET['id'] ?? 0;

    if ($id <= 0) {
        header('location: mysends.php');

        die();
    }

    $soft = rmdp_get_download_data($id);

    if (!$soft) {
        redirect_header('mysends.php', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    /**
     * Comprobamos que el usuario actual sea el publicador
     * del archivo seleccionado
     **/

    if ($soft['submitter'] != $xoopsUser->getVar('uid')) {
        redirect_header('mysends.php', 1, _RMDP_NOT_OWNER);

        die();
    }

    /**
     * Si todas las comprobaciones son correctas asignamos variables
     **/

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_modify_submit.html';

    foreach ($soft as $key => $value) {
        $xoopsTpl->assign('param_' . $key, $value);
    }

    /**
     * Comprobamos is el archivo de la descarga es
     * local o si es una URL
     */

    if (1 == $soft['filetype']) {
        $xoopsTpl->assign('rmdp_actualfile', $soft['archivo']);

        $xoopsTpl->assign('param_archivo', '');
    } else {
        $xoopsTpl->assign('rmdp_actualfile', '');
    }

    $xoopsTpl->assign('rmdp_filetype', '<input type="hidden" name="filetype" value="' . $soft['filetype'] . '">');

    /**
     * Comprobamos si el archivo de la imágen es un archivo
     * local o si es una URL
     */

    if (1 == $soft['imgtype']) {
        $xoopsTpl->assign('rmdp_actualimg', '<img src="uploads/' . $soft['img'] . '" border="1" alt="">');

        $xoopsTpl->assign('param_img', '');
    } else {
        $xoopsTpl->assign('rmdp_actualimg', '');
    }

    rmdp_make_searchnav();

    // Cargmos las licencias

    rmdp_licence_list();

    /**
     * Seleccionamos las plataformas para las que
     * esta descarga ha sido activada
     */

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_softos') . " WHERE id_soft='$id'");

    $plats = [];

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $plats[] = $row['id_os'];
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas') . ' ORDER BY nombre');

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if (in_array($row['id_os'], $plats, true)) {
            $xoopsTpl->append('plataformas', ['id' => $row['id_os'], 'nombre' => $row['nombre'], 'select' => true]);
        } else {
            $xoopsTpl->append('plataformas', ['id' => $row['id_os'], 'nombre' => $row['nombre'], 'select' => false]);
        }
    }

    /**
     * Cargamos los sitios réplica
     */

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$id' AND status='0'");

    $num = $xoopsDB->getRowsNum($result);

    $i = 1;

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append('mirrors', ['id' => $row['id_mir'], 'url' => $row['url'], 'titulo' => $row['titulo']]);

        $i++;
    }

    if ($xoopsModuleConfig['mirrors'] > $num) {
        for ($i = $i; $i <= $xoopsModuleConfig['mirrors']; $i++) {
            $xoopsTpl->append('mirrors', ['id' => $row['id_mir'], 'url' => '', 'titulo' => '']);
        }
    }

    require XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $xoopsTpl->assign('rmdp_editor', rmdpGetEditor('Editor', 'longdesc', $soft['longdesc'], '100%', '200px', '', false));

    $xoopsTpl->assign('modify_title', _RMDP_FORM_TITLE);

    $xoopsTpl->assign('lang_nombre', _RMDP_FNAME);

    $xoopsTpl->assign('lang_version', _RMDP_FVERSION);

    $xoopsTpl->assign('lang_licencia', _RMDP_FLIC);

    $xoopsTpl->assign('lang_archivo', _RMDP_FFILE);

    $xoopsTpl->assign('lang_archivo_url', _RMDP_FILE_URL);

    $xoopsTpl->assign('lang_max_size', sprintf(_RMDP_FFILE_DESC, (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit'])));

    $xoopsTpl->assign('lang_img', _RMDP_FIMAGE);

    $xoopsTpl->assign('lang_img_url', _RMDP_IMG_URL);

    $xoopsTpl->assign('lang_imgtip', sprintf(_RMDP_FIMAGETIP, $xoopsModuleConfig['imgdownw']));

    $xoopsTpl->assign('lang_catego', _RMDP_FCATEGO);

    $xoopsTpl->assign('lang_desc', _RMDP_FDESC);

    $xoopsTpl->assign('lang_desctip', _RMDP_FDESCTIP);

    $xoopsTpl->assign('lang_size', _RMDP_FSIZE);

    $xoopsTpl->assign('lang_anonimo', _RMDP_FANONIM);

    $xoopsTpl->assign('lang_web', _RMDP_FWEB);

    $xoopsTpl->assign('lang_url', _RMDP_FURL);

    $xoopsTpl->assign('lang_send', _RMDP_SEND);

    $xoopsTpl->assign('lang_yes', _RMDP_YES);

    $xoopsTpl->assign('lang_no', _RMDP_NO);

    $xoopsTpl->assign('lang_os', _RMDP_OSS);

    $xoopsTpl->assign('lang_info', _RMDP_SUBMIT_INFO);

    $xoopsTpl->assign('max_file_size', (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']));

    $xoopsTpl->assign('mirrors_title', _RMDP_MIRRORS_TITLE);

    $xoopsTpl->assign('lang_mirtitle', _RMDP_ITEMMIR_TITLE);

    $xoopsTpl->assign('lang_mirurl', _RMDP_ITEMMIR_URL);
} elseif ('send' == $op) {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    /**
     * Comprobamos que los datos sean correctos
     **/

    if ('' == $nombre || '' == $version || $licencia <= 0 || $idc <= 0 || '' == $longdesc) {
        redirect_header('submit.php?' . $urlparam, 1, _RMDP_PLEASE_FILL);

        die();
    }

    /**
     * Comprobamos que no exista una descarga con el mismo nombre
     **/

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id_soft'"));

    if ($num <= 0) {
        redirect_header('mysends.php?', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    $soft = rmdp_get_download_data($id_soft);

    /**
     * Obtenmos quien envía
     **/

    if ('' != $xoopsUser) {
        $submitter = $xoopsUser->getVar('uid');
    } else {
        $submitter = 0;
    }

    /**
     * guardamos los datos de la descarga
     **/

    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        // Comprobamos si existe un archivo con el mismo nombre

        $filetype = 1;

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

        $uploaded_file = true;

        $size = filesize($directorio . "/$file_name");
    } elseif ('' != $archivo_url) {
        $file_name = $archivo_url;

        $filetype = 0;
    } else {
        $file_name = $soft['archivo'];
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

        $uploaded_img = true;

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img_name, $dir_imgs . $img_name, $xoopsModuleConfig['imgdownw']);
    } elseif ('' != $img_url) {
        $imgtype = 0;

        $img_name = $img_url;
    } else {
        $img_name = $soft['img'];
    }

    if ($size <= 0) {
        $size = 0;
    }

    /**
     * Guardamos los sistemas operativos
     */

    $plats = '';

    foreach ($os as $k) {
        $plats .= $k . '|';
    }

    if ('' != $plats) {
        $plats = mb_substr($plats, 0, -1);
    }

    $xoopsDB->query(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_sended') . " (`nombre`,`version`,`licencia`,`archivo`,`filetype`,`img`,
			`imgtype`,`id_cat`,`longdesc`,`size`,`anonimo`,`url`,`submitter`,`urltitle`,`plataformas`,`modify`,`id_mod`) 
			VALUES ('$nombre','$version','$licencia','$file_name','$filetype','$img_name','$imgtype','$idc',
			'$longdesc','$size','$anonimo','$url','" . $xoopsUser->getvar('uid') . "','$web','$plats','1','$id_soft')"
    );

    $err = $xoopsDB->error();

    if ('' != $err) {
        if (1 == $filetype && $uploaded_file && file_exists($directorio . "/$file_name")) {
            unlink($directorio . "/$file_name");
        }

        if (1 == $imgtype && $uploaded_img && file_exists($dir_imgs . $img_name)) {
            unlink($dir_imgs . $img_name);
        }

        redirect_header('mysends.php', 1, _RMDP_SENDFAIL);

        die();
    }

    $id = $xoopsDB->getInsertId();

    /**
     * Guardamos las replicas
     */

    $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$id_soft' AND status='0'");

    $i = 0;

    foreach ($mirrortitle as $k) {
        if ('' != $k) {
            $xoopsDB->query(
                'INSERT INTO ' . $xoopsDB->prefix('rmdp_mirrors') . " (`id_soft`,`titulo`,`url`,`status`)
					VALUES('$id','$k','" . $mirrorfile[$i] . "','1');"
            );
        }

        $i++;
    }

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($xoopsConfig['adminmail']);

    $xoopsMailer->setFromEmail($xoopsConfig['from']);

    $xoopsMailer->setFromName($xoopsConfig['sitename'] . ' - ' . $xoopsModuleConfig['rmdptitle']);

    $xoopsMailer->setSubject(_RMDP_MAIL_SUBJECT);

    $xoopsMailer->setBody(_RMDP_MAIL_BODY . XOOPS_URL . '/modules/rmdp/admin/modified.php');

    $xoopsMailer->send();

    redirect_header('mysends.php', 1, _RMDP_SENDOK);

    die();
} elseif ('shots' == $op) {
    /**
     * Comprobamos que el usuario actual sea el publicador
     * del archivo seleccionado
     **/

    $id = $_GET['id'] ?? 0;

    $soft = rmdp_get_download_data($id);

    if (!$soft) {
        redirect_header('mysends.php', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    if ($soft['submitter'] != $xoopsUser->getVar('uid')) {
        redirect_header('mysends.php', 1, _RMDP_NOT_OWNER);

        die();
    }

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_send_shots.html';

    $shot = $_GET['shot'] ?? 0;

    /**
     * Cargamos la lista de pantallas existentes
     **/

    $shotsnum = rmdp_get_shots_list($id);

    if ($shotsnum >= $xoopsModuleConfig['shotlimit']) {
        $xoopsTpl->assign('shotlimit', true);

        $shot = 0;
    }

    // Barra de búsqueda

    rmdp_make_searchnav();

    rmdp_get_sponsor();

    $xoopsTpl->assign('lang_newshot', _RMDP_NEW_SHOT);

    $xoopsTpl->assign('action', 'addshot');

    // Varlores para el formato de la imágen

    $xoopsTpl->assign('img_width', $xoopsModuleConfig['imgshotsw']);

    $xoopsTpl->assign('rmdp_uploadfile', $xoopsModuleConfig['filesend']);

    $xoopsTpl->assign('lang_downshot', sprintf(_RMDP_SHOTS_TITLE, $soft['nombre']));

    $xoopsTpl->assign('lang_hits', _RMDP_SEND_HITS);

    $xoopsTpl->assign('lang_date', _RMDP_SEND_DATE);

    $xoopsTpl->assign('lang_small', _RMDP_NEW_SMALLIMG);

    $xoopsTpl->assign('lang_small_desc', _RMDP_SHOT_IMG_DESC);

    $xoopsTpl->assign('lang_img', _RMDP_SHOT_IMG);

    $xoopsTpl->assign('lang_big', _RMDP_NEW_BIGIMG);

    $xoopsTpl->assign('lang_text', _RMDP_NEW_TEXT);

    $xoopsTpl->assign('lang_send', _RMDP_NEW_SEND);

    $xoopsTpl->assign('lang_modify', _RMDP_MODIFY_DOWN);

    $xoopsTpl->assign('lang_delete', _RMDP_DELETE_DOWN);

    $xoopsTpl->assign('soft_id', $id);
} elseif ('addshot' == $op) {
    /**
     * Guardamos una nueva pantalla
     **/

    $small = $_POST['small'] ?? '';

    $big = $_POST['big'] ?? '';

    $text = $_POST['text'] ?? '';

    $id = $_POST['id'] ?? '';

    if ($id <= 0) {
        header('location: mysends.php');

        die();
    }

    $soft = rmdp_get_download_data($id);

    if (!$soft) {
        redirect_header('mysends.php', 1, _RMDP_ERR_NOTFOUND);

        die();
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$id'"));

    if ($num >= $xoopsModuleConfig['shotlimit']) {
        redirect_header('mysends.php', 1, _RMDP_SHOT_LIMIT);

        die();
    }

    $type = 0;

    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
        $type = 1;

        $dir_imgs = XOOPS_ROOT_PATH . '/modules/rmdp/uploads/shots/';

        $ext = mb_strrchr($_FILES['img']['name'], '.');

        do {
            $img = rmdpRandomWord('12', date('dMy_')) . $ext;

            if (!file_exists($dir_imgs . $img)) {
                $ok = true;
            }
        } while (false === $ok);

        // Movemos la imágen

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $dir_imgs . $img)) {
            unlink($directorio . $img);

            redirect_header('mysends.php?op=shots&amp;id=' . $id, 2, _RMDP_ERR_MOVE);

            die();
        }

        $small = $img;

        $big = $img;

        // Redimensionamos la imágen

        rmdpImageResize($dir_imgs . $img, $dir_imgs . $img, $xoopsModuleConfig['imgshotbw']);

        rmdpImageResize($dir_imgs . $img, $dir_imgs . 'ths/' . $img, $xoopsModuleConfig['imgshotsw']);
    }

    if ('' == $small || '' == $big) {
        redirect_header('mysends.php?op=shots&amp;id=' . $id, 1, _RMDP_ERR_IMAGES);

        die();
    }

    $xoopsDB->query(
        'INSERT INTO ' . $xoopsDB->prefix('rmdp_shots') . " (`id_soft`,`small`,`big`,`text`,`fecha`,`hits`,`type`)
			VALUES ('$id','$small','$big','$text','" . time() . "','0','$type')"
    );

    redirect_header('mysends.php?op=shots&amp;id=' . $id, 1, '');
} elseif ('delshot' == $op) {
    $ok = $_POST['ok'] ?? 0;

    $shot = $_GET['shot'] ?? ($_POST['shot'] ?? 0);

    $id = $_GET['id'] ?? ($_POST['id'] ?? 0);

    if ($id <= 0 || $shot <= 0) {
        redirect_header('mysends.php?op=shots&amp;id=' . $id, 1, '');

        die();
    }

    if ($ok) {
        $soft = rmdp_get_download_data($id);

        if (!$soft) {
            redirect_header('mysends.php?op=shots&amp;id=' . $id, 1);

            die();
        }

        $row = rmdpGetShot($shot);

        if (!$row) {
            redirect_header('mysends.php?op=shots&amp;id=' . $id, 1);

            die();
        }

        /**
         * Eliminamos la imágen existente
         */

        if ($row['type'] = 1) {
            unlink(XOOPS_ROOT_PATH . '/modules/rmdp/uploads/shots/' . $row['big']);

            unlink(XOOPS_ROOT_PATH . '/modules/rmdp/uploads/shots/ths/' . $row['small']);
        }

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$shot'");

        redirect_header('mysends.php?op=shots&amp;id=' . $id, 1, _RMDP_SHOT_DELETED);

        die();
    }

    echo "<div class='outer' align='center' style='padding: 1px;'><div class='even' align='center'>
				<br><form name='frmDel' method='post' action='mysends.php'>" . _RMDP_CONFIRM_DELETE . "
					<br><br><input type='submit' name='sbt' value='" . _RMDP_SEND_BUTTON . "'>
					<input type='button' name='cancel' value='" . _RMDP_CANCEL_BUTTON . "' onclick='javascript:history.go(-1);'>
					<input type='hidden' name='shot' value='$shot'>
					<input type='hidden' name='id' value='$id'>
					<input type='hidden' name='op' value='delshot'>
					<input type='hidden' name='ok' value='1'>
				</form>
			  </div></div>";
}

require __DIR__ . '/footer.php';


