<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: submit.php,v 1.5 23/11/2005 13:40:27 BitC3R0 Exp $                  //
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

$rmdp_location = 'submit';
require __DIR__ . '/header.php';

/**
 * Comprobamos que este habilitado el envio de descargas
 **/
if (!$xoopsModuleConfig['downsend']) {
    redirect_header('index.php', 1, _RMDP_SUBMIT_INACTIVE);

    die();
}

/**
 * Comprobamos si el usuario es anónimo y si tiene
 * permitido el envio de descargas
 **/
$anon = $xoopsModuleConfig['sendanonimo'];
if ('' == $xoopsUser && 0 == $anon) {
    redirect_header(XOOPS_URL . '/user.php?xoops_redirect=' . parse_url($_SERVER['PHP_SELF']), 1, _RMDP_REGISTER_FORSUBMIT);

    die();
}

// Elegimos que hacer
$op = $_POST['op'] ?? '';

require __DIR__ . '/include/rmdp_functions.php';
require __DIR__ . '/include/rmdp_downs.php';

if ('save' == $op) {
    /**
     * Guardamos las descargas
     **/

    $urlparam .= '';

    foreach ($_POST as $key => $value) {
        $$key = $value;

        if ('archivo' != $key && 'img' != $key) {
            if ('' == $urlparam) {
                $urlparam .= "$key=$value";
            } else {
                $urlparam .= "&amp;$key=$value";
            }
        }
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

    if (rmdp_check_download_name($nombre, $idc, 'save')) {
        redirect_header('submit.php?' . $urlparam, 1, _RMDP_NAME_EXIST);

        die();
    }

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

        $size = filesize($directorio . "/$file_name");
    } else {
        $file_name = $archivo_url;

        $filetype = 0;
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
			`imgtype`,`id_cat`,`longdesc`,`size`,`anonimo`,`url`,`submitter`,`urltitle`,`plataformas`) 
			VALUES ('$nombre','$version','$licencia','$file_name','$filetype','$img_name','$imgtype','$idc',
			'$longdesc','$size','$anonimo','$url','" . $xoopsUser->getvar('uid') . "','$urltitle','$plats')"
    );

    $err = $xoopsDB->error();

    if ('' != $err) {
        if (1 == $filetype && file_exists($directorio . "/$file_name")) {
            unlink($directorio . "/$file_name");
        }

        if (1 == $imgtype && file_exists($dir_imgs . $img_name)) {
            unlink($dir_imgs . $img_name);
        }

        redirect_header('submit.php?' . $urlparam, 1, _RMDP_SENDFAIL);

        die();
    }

    $id = $xoopsDB->getInsertId();

    /**
     * Guardamos las replicas
     */

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

    $xoopsMailer->setBody(sprintf(_RMDP_MAIL_BODY, XOOPS_URL . '/modules/rmdp/admin/sended.php'));

    $xoopsMailer->send();

    redirect_header('mysends.php', 1, _RMDP_SENDOK);

    die();
}
    rmdp_make_searchnav();
    // Cargmos las licencias
    rmdp_licence_list();
    // Cargamos los sistemas operativos
    rmdp_plataforms_list();

    $GLOBALS['xoopsOption']['template_main'] = 'rmdp_submit.html';
    $xoopsTpl->assign('lang_info', sprintf(_RMDP_SUBMIT_INFO, $xoopsConfig['sitename']));
    $xoopsTpl->assign('lang_info2', _RMDP_SUBMIT_INFO2);
    $xoopsTpl->assign('lang_os', _RMDP_OSS);

    // Cadenas de errores
    $xoopsTpl->assign('lang_errores_happen', _RMDP_ERRORS_HAPPEND);
    $xoopsTpl->assign('lang_mustbe_num', _RMDP_MUSTBE_NUM);
    $xoopsTpl->assign('lang_is_empty', _RMDP_IS_EMPTY);

    // Cargamos los valores de url si estamos regresando por un error
    foreach ($_GET as $key => $value) {
        $xoopsTpl->assign('param_' . $key, $value);
    }

    // Formulario para la descarga
    require __DIR__ . '/include/rmdp_categos.php';
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $cform = new XoopsThemeForm(_RMDP_FORM_TITLE, 'frmNew', 'submit.php');
    $cform->setExtra('enctype="multipart/form-data"');
    $cform->addElement(new XoopsFormText(_RMDP_FNAME, 'nombre', 50, 200), true);
    $cform->addElement(new XoopsFormText(_RMDP_FVERSION, 'version', 15, 10), true);
    $select = "<select name='licencia' id='licencia'>
			<option value='0'>Ninguna</option>";
    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_licences') . ' ORDER BY nombre');
    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$row[id_lic]'>$row[nombre]</option>";
    }
    $select .= '</select>';
    $cform->addElement(new XoopsFormLabel(_RMDP_FLIC, $select), false);
    /** Archivos **/
    if (1 == $xoopsModuleConfig['filesend']) {
        $cform->addElement(
            new XoopsFormLabel(
                _RMDP_FFILE . "<br><span style='font-size: 10px;'>" . sprintf(_RMDP_MAXSIZE, (rmdp_convert_size($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']))) . '</span>',
                "<input type='hidden' name='MAX_FILE_SIZE' value='" . (int)($xoopsModuleConfig['filesize'] * $xoopsModuleConfig['sizeunit']) . "'>
			<input name='archivo' type='file' id='archivo' size='50'>"
            ),
            false
        );
    }
    $cform->addElement(new XoopsFormText(_RMDP_FFILEURL . "<br><span style='font-size: 10px;'>" . _RMDP_FFILEURL_DESC . '</span>', 'archivo_url', 50, 255), false);
    if (1 == $xoopsModuleConfig['imagesend']) {
        $cform->addElement(new XoopsFormLabel(_RMDP_FIMAGE, "<input name='img' type='file' id='img' size='50' >"), false);
    }
    $cform->addElement(new XoopsFormText(_RMDP_FIMGURL . "<br><span style='font-size: 10px;'>" . _RMDP_FIMGURL_DESC . '</span>', 'img_url', 50, 255), false);
    $select = "<select name='idc' id='idc'><option value='0' selected>" . _RMDP_SELECT . '</option>';
    $select .= rmdpCategoOptions() . '</select>';
    $cform->addElement(new XoopsFormLabel(_RMDP_FCATEGO, $select), false);
    $editor = rmdpGetEditor(_RMDP_FDESC, 'longdesc', '', '100%', '150px', '');
    $cform->addElement($editor, true);
    if (1 == $xoopsModuleConfig['filesend']) {
        $editor = _RMDP_FSIZE . "<br><span style='font-size: 10px;'>" . _RMDP_FSIZE_DESC . '</span>';
    } else {
        $editor = _RMDP_FSIZE;
    }
    $cform->addElement(new XoopsFormText($editor, 'size', 20, 20), false);
    $cform->addElement(
        new XoopsFormLabel(
            _RMDP_FANONIM,
            "<input name='anonimo' type='radio' value='1'>
  			" . _RMDP_YES . "
  			<input name='anonimo' type='radio' value='0' checked>
  			" . _RMDP_NO
        ),
        false
    );
    $cform->addElement(new XoopsFormText(_RMDP_FWEB, 'urltitle', 50, 255), true);
    $cform->addElement(new XoopsFormText(_RMDP_FURL, 'url', 50, 255), false);

    $select = "<select name='os[]' size='5' multiple='multiple'>";
    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas'));
    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $select .= "<option value='$row[id_os]'>$row[nombre]</option>";
    }
    $select .= '</select>';
    $cform->addElement(new XoopsFormLabel(_RMDP_OSS, $select), false);
    $cform->assign($xoopsTpl);

    if ($xoopsModuleConfig['mirrors'] > 0) {
        for ($i = 1; $i <= $xoopsModuleConfig['mirrors']; $i++) {
            $xoopsTpl->append('mirrors', ['title' => sprintf(_RMDP_ITEMMIR_TITLE, $i), 'url' => sprintf(_RMDP_ITEMMIR_URL, $i)]);
        }
    }
    $xoopsTpl->assign('mirrors_title', _RMDP_MIRRORS_TITLE);
    $xoopsTpl->assign('lang_send', _RMDP_SEND);
    $xoopsTpl->assign('lang_cancel', _RMDP_CANCEL_BUTTON);

require __DIR__ . '/footer.php';


