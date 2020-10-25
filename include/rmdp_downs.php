<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_downs.php,v 1.5 23/11/2005 13:46:15 BitC3R0 Exp $              //
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
 * Obtiene todos los datos de una descarga
 * Parámetros
 * @ids    = Id de la descarga
 * @param mixed $ids
 * @return void = Datos de la descarga
 */
function rmdp_load_downdata($ids)
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl, $myts, $xoopsConfig;

    global $cid, $xoopsUser, $xoopsUserIsAdmin;

    if ($ids <= 0) {
        return;
    }

    $tbls = $xoopsDB->prefix('rmdp_software');

    $result = $xoopsDB->query("SELECT * FROM $tbls WHERE id_soft='$ids'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        return;
    }

    /**
     * Calulamos el indice del rating
     */

    $rate = rmdp_set_rating();

    $row = $xoopsDB->fetchArray($result);

    /**
     * formatemos la fecha en base a las preferencias
     * del módulo
     */

    $fecha = date($xoopsModuleConfig['dateformat'], $row['fecha']);

    /**
     * Comprobamos si la descarga es nueva
     * o si ha sido actualizada
     */

    $isnew = rmdp_element_isnew($row['fecha'], $xoopsModuleConfig['downnew']);

    $isupdate = rmdp_element_isnew($row['update'], $xoopsModuleConfig['update_days']);

    /**
     * Obtenmos el nombre del publicador
     */

    $uname = rmdp_get_username($row['submitter']);

    $cid = $row['reviews'];

    /**
     * Cargamos los datos
     */

    $xoopsTpl->assign(
        'download',
        [
            'id' => $row['id_soft'],
'nombre' => $row['nombre'],
'fecha' => $fecha,
'isnew' => $isnew,
'isupdate' => $isupdate,
'licence' => rmdp_get_licencelink($row['licencia']),
'os' => rmdp_get_downos($row['id_soft']),
'shots' => rmdp_get_shotsnum($row['id_soft']),
'size' => rmdp_convert_size($row['size']),
'rating' => rmdp_calculate_rating($row['rating'], $rate),
'calificacion' => $row['calificacion'],
'descargas' => $row['descargas'],
'url' => $row['url'],
'homepage' => $row['urltitle'],
'uname' => $uname,
'submitter' => $row['submitter'],
'ispopular' => rmdp_is_popular($row['descargas']),
'desc' => $myts->displayTarea($row['longdesc']),
'img' => $row['img'],
'editor' => rmdp_get_editor_review($row['id_soft']),
        ]
    );

    $xoopsTpl->assign('lng_downloads', _RMDP_DOWNLOADS);

    $xoopsTpl->assign('lng_web_site', _RMDP_WEB_SITE);

    $xoopsTpl->assign('lng_date', _RMDP_DATE);

    $xoopsTpl->assign('lng_isnew', _RMDP_NEW_DOWN);

    $xoopsTpl->assign('lng_isupdate', _RMDP_UPDATE_DOWN);

    $xoopsTpl->assign('lng_licence', _RMDP_LICENCE);

    $xoopsTpl->assign('lng_os', _RMDP_OSS);

    $xoopsTpl->assign('lng_screenshot', _RMDP_SCREEN_SHOT);

    $xoopsTpl->assign('lng_sendby', _RMDP_SEND_BY);

    $xoopsTpl->assign('lng_viewshots', _RMDP_VIEW_SHOT);

    $xoopsTpl->assign('lng_rating', _RMDP_USER_RATING);

    $xoopsTpl->assign('lng_vote', _RMDP_VOTE);

    $xoopsTpl->assign('lng_our_rating', _RMDP_OUR_RATING);

    $xoopsTpl->assign('lng_filesize', _RMDP_SIZE);

    $xoopsTpl->assign('lng_usercomments', _RMDP_USER_COMMENTS);

    $xoopsTpl->assign('lng_editorcom', sprintf(_RMDP_EDITOR_COM, $xoopsConfig['sitename']));

    $xoopsTpl->assign('lng_publisher_desc', sprintf(_RMDP_PUBLISHER_DESC, $uname));

    if ('' == $xoopsUser && $xoopsModuleConfig['uservote']) {
        /**
         * El usuario anónimo puede votar
         */

        $xoopsTpl->assign('vote_form', rmdp_make_voteform($row['id_soft']));
    } elseif ($xoopsUser) {
        /**
         * Si el usuario esta registrado y no es el publicador
         * entonces mostramos las opciones de voto
         */

        if ($xoopsUser->getvar('uid') != $row['submitter']) {
            $xoopsTpl->assign('vote_form', rmdp_make_voteform($row['id_soft']));
        }

        /**
         * Si el usuario es el administrador mostramos
         * Opciones administrativas
         */

        if ($xoopsUserIsAdmin) {
            $adminoptions = "<a href='admin/downs.php?op=mod&amp;ids=" . $row['id_soft'] . "'><img src='images/edit.gif' border='0'></a>
				<a href='admin/downs.php?op=review&amp;ids=" . $row['id_soft'] . "'><img src='images/review.gif' border='0'></a>";

            $xoopsTpl->assign('admin_options', $adminoptions);
        }

        /**
         * Opcion para reportar un enlace roto
         **/

        $useroptions = "<a href='broken.php?id=$row[id_soft]'><img src='images/report.gif' border='0' alt='" . _RMDP_REPORT_BROKEN . "'></a>";

        /**
         * Si el usuario es el publicador de la descarga
         * Mostramos opciones administrativas del usuario
         */

        if ($xoopsUser->getvar('uid') == $row['submitter']) {
            $xoopsTpl->assign('is_Submitter', true);

            $useroptions .= "<a href='mysends.php?op=modify&amp;id=" . $row['id_soft'] . "'><img src='images/edit.gif' border='0'></a>";
        }

        $xoopsTpl->assign('user_options', $useroptions);
    }
}

/**
 * Devuelve el número de pantallas de una descarga
 * @param mixed $ids
 * @return int|mixed
 * @return int|mixed
 */
function rmdp_get_shotsnum($ids)
{
    global $xoopsDB;

    if ($ids <= 0) {
        return 0;
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$ids'"));

    return $num;
}

/**
 * Determina si una descarga es popular
 * Parametros
 * @downs = número de descargas
 * @param mixed $downs
 * @return int
 * @return int
 */
function rmdp_is_popular($downs)
{
    global $xoopsModuleConfig;

    if ($downs >= $xoopsModuleConfig['popular_needs']) {
        return 1;
    }

    return 0;
}

/**
 * Devuelve el comentario completo de los editores
 * Parámetros
 * @ids = Id del programa
 * @param mixed $ids
 * @return mixed|string|void
 * @return mixed|string|void
 */
function rmdp_get_editor_review($ids)
{
    global $xoopsDB, $myts;

    if ($ids <= 0) {
        return;
    }

    $tbler = $xoopsDB->prefix('rmdp_editorcom');

    $result = $xoopsDB->query("SELECT text FROM $tbler WHERE id_soft='$ids'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        return;
    }

    $row = $xoopsDB->fetchArray($result);

    $rtn = $myts->displayTarea($row['text']);

    return $rtn;
}

/**
 * Crea el formulario para votar por un recurso
 * Parámetros
 * @ids = Id del programa
 * @param mixed $ids
 * @return string|void
 * @return string|void
 */
function rmdp_make_voteform($ids)
{
    if ($ids <= 0) {
        return;
    }

    $rtn = '' . _RMDP_VOTE . "&nbsp; 
			 <a href='vote.php?id=" . $ids . "&amp;rate=1'><img src='images/starvote.gif' border='0' align='absmiddle'></a>
			 <a href='vote.php?id=" . $ids . "&amp;rate=2'><img src='images/starvote.gif' border='0' align='absmiddle'></a>
			 <a href='vote.php?id=" . $ids . "&amp;rate=3'><img src='images/starvote.gif' border='0' align='absmiddle'></a>
			 <a href='vote.php?id=" . $ids . "&amp;rate=4'><img src='images/starvote.gif' border='0' align='absmiddle'></a>
			 <a href='vote.php?id=" . $ids . "&amp;rate=5'><img src='images/starvote.gif' border='0' align='absmiddle'></a>
			 </div>";

    return $rtn;
}

/**
 * Devuelve un array con los datos de una descarga
 * @ids    = Id de descarga
 * @param mixed $ids
 * @return false = array con los datos, false si no se encuentra
 */
function rmdp_get_download_data($ids)
{
    global $xoopsDB;

    if ($ids <= 0) {
        return false;
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$ids'");

    if ($xoopsDB->getRowsNum($result) <= 0) {
        return false;
    }

    $row = $xoopsDB->fetchArray($result);

    return $row;
}

/**
 * Comprueba que no exista una descarga repetida
 * Parámetros
 * @param Nombre $nombre de la descarga a comprobar
 * @param Id     $idc    de la categoría
 * @param string $action "mod" o "save"
 * @param int    $ids    de software. Útil si $action = "mod"
 * @return bool
 */
function rmdp_check_download_name($nombre, $idc, $action = 'save', $ids = 0)
{
    global $xoopsDB;

    if ('save' == $action) {
        [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE nombre='$nombre'"));

        if ($num > 0) {
            return true;
        }

        return false;
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE nombre='$nombre' AND id_soft<>'$ids'"));

    if ($num > 0) {
        return true;
    }

    return false;
}

/**
 * Obtiene todas las pantallas de un programa
 * @param mixed $ids
 *
 * @return int
 * @return int
 */
function rmdp_get_shots_list($ids)
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig;

    if ($ids <= 0) {
        return 0;
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_soft='$ids'");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        if (1 == $row['type']) {
            $pre = XOOPS_URL . '/modules/rmdp/uploads/shots/';
        } else {
            $pre = '';
        }

        $xoopsTpl->append(
            'shots',
            [
                'id' => $row['id_shot'],
'small' => $pre . $row['small'],
'big' => $pre . $row['big'],
'text' => $row['text'],
'fecha' => date($xoopsModuleConfig['dateformat'], $row['fecha']),
'hits' => $row['hits'],
            ]
        );
    }

    return $xoopsDB->getRowsNum($result);
}

/**
 * Obtiene una pantalla y todos sus datos
 * @param Id $id de la pantalla
 * @return array|false
 * @return array|false
 */
function rmdpGetShot($id)
{
    global $xoopsDB;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_shots') . " WHERE id_shot='$id'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        return false;
    }

    $row = $xoopsDB->fetchArray($result);

    return $row;
}

/**
 * Obtiene los enlaces alternativos para una descarga
 * @param mixed $id
 * @param mixed $getNums
 */
function rmdpGetMirrors($id, $getNums = false)
{
    global $xoopsDB, $xoopsTpl;

    /**
     * Cargamos el enlace principal
     */

    $result = $xoopsDB->query('SELECT archivo FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$id'");

    if ($xoopsDB->getRowsNum($result) <= 0) {
        return;
    }

    $row = $xoopsDB->fetchArray($result);

    $ext = mb_strrchr($row['archivo'], '.');

    if ('' != $ext) {
        $ext = mb_substr($ext, 1);
    }

    if (file_exists('images/files/' . $ext . '.gif')) {
        $xoopsTpl->append('rmdp_mirrors', ['id' => 0, 'titulo' => _RMDP_MIRROR_PRIMARY, 'icon' => $ext, 'format' => sprintf(_RMDP_FILE_TYPE, $ext)]);
    } else {
        $xoopsTpl->append('rmdp_mirrors', ['id' => 0, 'titulo' => _RMDP_MIRROR_PRIMARY, 'icon' => 'default', 'format' => sprintf(_RMDP_FILE_TYPE, '')]);
    }

    /**
     * Cargamos los enlaces alternativos
     */

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_soft='$id' AND status='0'");

    $num = $xoopsDB->getRowsNum($result);

    $xoopsTpl->assign('num_mirrors', $num);

    if ($getNums) {
        return;
    }

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $ext = mb_strrchr($row['url'], '.');

        if ('' != $ext) {
            $ext = mb_substr($ext, 1);
        }

        if (file_exists('images/files/' . $ext . '.gif')) {
            $xoopsTpl->append('rmdp_mirrors', ['id' => $row['id_mir'], 'titulo' => $row['titulo'], 'icon' => $ext, 'format' => sprintf(_RMDP_FILE_TYPE, $ext)]);
        } else {
            $xoopsTpl->append('rmdp_mirrors', ['id' => $row['id_mir'], 'titulo' => _RMDP_MIRROR_PRIMARY, 'icon' => 'default', 'format' => sprintf(_RMDP_FILE_TYPE, '')]);
        }
    }
}

/**
 * Función para obtener la url de descarga
 * de un formato o sitio réplica especificado
 * si no lo encuentra retorna el valor por defecto
 *
 * @param Id     $id      del mirror
 * @param string $default por defecto
 * @return \Archivo|mixed|string
 */
function rmdpGetMirror($id, $default = '')
{
    global $xoopsDB;

    $result = $xoopsDB->query('SELECT url FROM ' . $xoopsDB->prefix('rmdp_mirrors') . " WHERE id_mir='$id'");

    $num = $xoopsDB->getRowsNum($result);

    if ($num <= 0) {
        return $default;
    }

    $row = $xoopsDB->fetchArray($result);

    return $row['url'];
}



