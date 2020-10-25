<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: rmdp_functions.php,v 1.5 23/11/2005 13:46:19 BitC3R0 Exp $          //
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
 * Comprobar si un elemento es nuevo o no
 * Parámetros:
 * @fecha  = fecha de creación o actualización del elemento
 * @days   = días para considerar nuevo un elemento
 *
 * @param mixed $fecha
 * @param mixed $days
 * @return int = 1 verdadero 0 falso
 */
function rmdp_element_isnew($fecha, $days)
{
    $today = time();

    $lapso = $today - $fecha;

    $lapso = (int)($lapso / 86400);

    if ($lapso <= $days) {
        return 1;
    }

    return 0;
}

/**
 * Obtiene la lista de categorías existentes
 * junto con sus subcategorías.
 * Necesita de rmdp_subcategos() para funcionar correctamente
 * Params
 *
 * @idc = Id de la categoría padre por la cual empezar
 * @param mixed $idc
 * @return int
 * @return int
 */
function get_categos_list($idc = 0)
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE parent='$idc'");

    $num = $xoopsDB->getRowsNum($result);

    // Amplitud de la imágen (29/07/2005)

    $xoopsTpl->assign('catego_img_width', $xoopsModuleConfig['imgcategow']);

    $xoopsTpl->assign('catego_show_images', $xoopsModuleConfig['showimgcat']);

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $new = rmdp_element_isnew($row['fecha'], $xoopsModuleConfig['categonew']);

        if (1 == $row['imgtype']) {
            $img = XOOPS_URL . '/modules/rmdp/uploads/' . $row['img'];
        } else {
            $img = $row['img'];
        }

        $xoopsTpl->append('categos', ['id' => $row['id_cat'], 'nombre' => $row['nombre'], 'img' => $img, 'fecha' => $row['fecha'], 'isnew' => $new, 'subcats' => rmdp_subcategos($row['id_cat'])]);
    }

    if ($num > 0) {
        return 1;
    }

    return 0;
}

function rmdp_subcategos($parent)
{
    global $xoopsDB, $xoopsModuleConfig;

    $rtn = '';

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE parent='$parent' LIMIT 0, $xoopsModuleConfig[subcategoslimit]");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $rtn .= "<a href='categos.php?id=$row[id_cat]'>$row[nombre]</a> · ";
    }

    if ('· ' == mb_substr($rtn, mb_strlen($rtn) - 2, 2)) {
        $rtn = mb_substr($rtn, 0, -3);
    }

    if ($xoopsDB->getRowsNum($result) == $xoopsModuleConfig['subcategoslimit']) {
        $rtn .= ' ...';
    }

    return $rtn;
}

/**
 * Obtiene las descargas patrocinadas dependiendo
 * del número de descargas establecidas en la configuración
 * Param
 *
 * @$xoopsModuleConfig['sponsor_downs'] = Limita el numero de resultados
 *
 * @return void = No retorno. Establece el array Smarty sponsors
 * @throws \Exception
 */
function rmdp_get_sponsor()
{
    global $xoopsDB, $xoopsTpl, $myts, $xoopsModuleConfig;

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_partners')));

    if ($num >= $xoopsModuleConfig['sponsor_downs']) {
        $do = $xoopsModuleConfig['sponsor_downs'];
    } elseif ($num >= 1 && $num < $xoopsModuleConfig['sponsor_downs']) {
        $do = $num;
    } else {
        return;
    }

    $num -= 1;

    $numero = [];

    for ($i = 0; $i <= $num; $i++) {
        $numero[$i] = $i;
    }

    $values = [];

    // mt_srand((double)microtime() * 1000000);

    for ($i = 0; $i <= $do - 1; $i++) {
        $item = random_int(0, count($numero) - 1); //Elemento a obtener
        $search = $numero[$item]; // Obtenmos el numero inicial del spaonsor
        array_splice($numero, $item, 1);

        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_partners') . " LIMIT $search, 1 ;");

        $row = $xoopsDB->fetchArray($result);

        $xoopsTpl->append('sponsors', ['id' => $row['id_soft'], 'desc' => $myts->displayTarea(mb_substr($row['text'], 0, $xoopsModuleConfig['len_desc'])), 'title' => rmdp_download_name($row['id_soft'])]);
    }

    $xoopsTpl->assign('lang_sponsornews', _RMDP_SPONSOR_NEWS);
}

/**
 * Obtiene el nombre de una descarga
 * Params
 *
 * @ids    = Identificador de la descarga
 *
 * @param mixed $ids
 * @return mixed|void = Nombre de la descarga
 */
function rmdp_download_name($ids)
{
    global $xoopsDB;

    if ($ids <= 0) {
        return;
    }

    [$dn] = $xoopsDB->fetchRow($xoopsDB->query('SELECT nombre FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$ids'"));

    return ($dn);
}

/**
 * Obtiene el nombre de una categoría dada
 * Params
 *
 * @idc    = Id de la categoría requerida
 * @param mixed $idc
 * @return mixed|void = Nombre de la categoría
 */
function rmdp_get_categoname($idc)
{
    global $xoopsDB;

    if ($idc <= 0) {
        return;
    }

    [$rtn] = $xoopsDB->fetchRow($xoopsDB->query('SELECT nombre FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$idc'"));

    return ($rtn);
}

/**
 * Obtiene la descarga del día
 * No hay parámetros
 */
function rmdp_today_download()
{
    global $xoopsDB, $xoopsTpl, $myts;

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software')));

    if ($num > 1) {
        $num -= 1;

        // mt_srand((double)microtime() * 1000000);

        $bnum = random_int(0, $num);
    } else {
        $bnum = 0;
    }

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_software') . " LIMIT $bnum, 1 ;");

    $row = $xoopsDB->fetchArray($result);

    if ('' == $row['img']) {
        $img = 'images/no_image.gif';
    } else {
        $img = $row['img'];
    }

    $desc = $myts->displayTarea(mb_substr($row['longdesc'], 0, 255)) . ' [...]';

    $xoopsTpl->assign('drandom', ['id' => $row['id_soft'], 'desc' => $desc, 'title' => $row['nombre'], 'img' => $img]);
}

/**
 * Obtiene los datos de la descarga reciente de una
 * categoría
 * Params
 *
 * @idc    = Identificador de la categoría
 *
 * @param mixed $idc
 * @return array|void = Array con los valores de la descarga
 */
function rmdp_recentdown_catego($idc)
{
    global $xoopsDB, $myts;

    if ($idc <= 0) {
        return;
    }

    $rtn = [];

    $result = $xoopsDB->query('SELECT id_soft, nombre, img, imgtype, longdesc FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_cat='$idc' ORDER BY `update` DESC LIMIT 0, 1");

    $row = $xoopsDB->fetchArray($result);

    $rtn['id'] = $row['id_soft'];

    $rtn['nombre'] = $row['nombre'];

    $rtn['imgtype'] = $row['imgtype'];

    if ('' == $row['img']) {
        $img = 'images/no_image.gif';
    } else {
        $img = $row['img'];
    }

    $rtn['img'] = $img;

    $rtn['desc'] = $myts->displayTarea(mb_substr($row['longdesc'], 0, 150)) . ' ...';

    return $rtn;
}

/**
 * Obtiene lo nuevo de las categorías
 * Params
 *
 * @limite = Limita el numero de categorías a mostrar
 * @param mixed $limite
 */
function rmdp_get_thenew($limite = 2)
{
    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE shownews='1'");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $soft = rmdp_recentdown_catego($row['id_cat']);

        if (1 == $row['imgtype']) {
            $img = "uploads/$row[img]";
        } else {
            $img = $row['img'];
        }

        if (1 == $soft['imgtype']) {
            $imgs = "uploads/$soft[img]";
        } else {
            $imgs = $soft['img'];
        }

        $xoopsTpl->append(
            'categos_with_news',
            [
                'id' => $row['id_cat'],
'nombre' => $row['nombre'],
'img' => $img,
'down_nombre' => $soft['nombre'],
'down_id' => $soft['id'],
'down_img' => $imgs,
'down_desc' => $soft['desc'],
            ]
        );
    }
}

/**
 * Obtiene las descargas asignadas como favoritos
 * Params
 *
 * @idc = Identificador de la categoría donde se busca
 * @param mixed $idc
 */
function rmdp_get_favorites($idc = 0)
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $myts;

    $sql = 'SELECT id_soft, nombre, longdesc FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE favorito='1'";

    if ($idc <= 0) {
        $sql .= " ORDER BY `update` DESC LIMIT 0, $xoopsModuleConfig[favo_downs]";
    } else {
        $sql .= " AND id_cat='$idc' ORDER BY `update` DESC LIMIT 0, $xoopsModuleConfig[favo_downs]";
    }

    $result = $xoopsDB->query($sql);

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $desc = $myts->displayTarea(mb_substr($row['longdesc'], 0, 80));

        $desc = str_replace('<br>', '. ', $desc);

        $xoopsTpl->append('favoritos', ['id' => $row['id_soft'], 'nombre' => $row['nombre'], 'desc' => $desc]);
    }
}

/**
 * Obtiene las descargas mas populares
 * de una categoría en particular o de todas
 * Param
 *
 * @idc = identificador de la categorías
 * @param mixed $idc
 */
function rmdp_get_popular($idc)
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl, $myts;

    $sql = 'SELECT id_soft, nombre, longdesc FROM ' . $xoopsDB->prefix('rmdp_software');

    if ($idc <= 0) {
        $sql .= " ORDER BY `descargas` DESC LIMIT 0, $xoopsModuleConfig[popular_downs]";
    } else {
        $sql .= " WHERE id_cat='$idc' ORDER BY `descargas` DESC LIMIT 0, $xoopsModuleConfig[popular_downs]";
    }

    $result = $xoopsDB->query($sql);

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $desc = $myts->displayTarea(mb_substr($row['longdesc'], 0, 80));

        $desc = str_replace('<br>', '. ', $desc);

        $xoopsTpl->append('populares', ['id' => $row['id_soft'], 'nombre' => $row['nombre'], 'desc' => $desc]);
    }
}

/**
 * Crea las opciones para la barra de búsqueda
 * Utiliza rmdp_subcats_options() para funcionar
 */
function rmdp_make_searchnav()
{
    global $xoopsDB, $xoopsTpl, $xoopsModule;

    $xoopsTpl->assign('lng_allweb', sprintf(_RMDP_ALL_WEB, $xoopsModule->getVar('name')));

    $xoopsTpl->assign('lng_search_button', _RMDP_SEARCH_BUTTON);

    $key = $_POST['key'] ?? ($_GET['key'] ?? '');

    $xoopsTpl->assign('key', $key);

    $result = $xoopsDB->query('SELECT id_cat, nombre FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE parent='0' ORDER BY nombre");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append('srhoptions', ['id' => $row['id_cat'], 'nombre' => $row['nombre']]);

        rmdp_subcats_option($row['id_cat'], 2);
    }

    $xoopsTpl->assign('lng_viewfav', _RMDP_VIEW_FAV);

    $xoopsTpl->assign('lng_viewpop', _RMDP_VIEW_POP);

    $xoopsTpl->assign('lng_bestrate', _RMDP_VIEW_RATED);

    $xoopsTpl->assign('lng_senddown', _RMDP_SUBMIT_DOWN);
}

function rmdp_subcats_option($idc, $saltos = 0)
{
    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT id_cat, nombre FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE parent=$idc");

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append('srhoptions', ['id' => $row['id_cat'], 'nombre' => str_repeat('-', $saltos) . ' ' . $row['nombre']]);

        rmdp_subcats_option($row['id_cat'], $saltos + 2);
    }
}

/**
 * Obtiene el nombre de una licencia dada
 * Params
 *
 * @idl = Id de la licencia solicitada
 * @param mixed $idl
 * @return mixed|void
 * @return mixed|void
 */
function rmdp_get_licencename($idl)
{
    global $xoopsDB;

    if ($idl <= 0) {
        return;
    }

    $rtn = $xoopsDB->fetchArray($xoopsDB->query('SELECT nombre FROM ' . $xoopsDB->prefix('rmdp_licences') . " WHERE id_lic='$idl'"));

    return ($rtn['nombre']);
}

/**
 * Devuelve un vinculo a la licencia especificada
 * @param mixed $idl
 *
 * @return mixed|string|void
 * @return mixed|string|void
 */
function rmdp_get_licencelink($idl)
{
    global $xoopsDB;

    if ($idl <= 0) {
        return;
    }

    $rtn = $xoopsDB->fetchArray($xoopsDB->query('SELECT url, nombre FROM ' . $xoopsDB->prefix('rmdp_licences') . " WHERE id_lic='$idl'"));

    if ('' != $rtn['url']) {
        return "<a href='$rtn[url]' target='_blank'>$rtn[nombre]</a>";
    }

    return $rtn['nombre'];
}

/**
 * Formatea un tamño de archivo en KB, MB o GB
 * Params tomada de modulo mydownloads
 * Nombre original PrettySize
 *
 * @size   = Tamaño del archivo
 * @param mixed $size
 * @return string = Cadena formateada
 */
function rmdp_convert_size($size)
{
    $mb = 1024 * 1024;

    if ($size > $mb) {
        $mysize = sprintf('%01.2f', $size / $mb) . ' MB';
    } elseif ($size >= 1024) {
        $mysize = sprintf('%01.2f', $size / 1024) . ' KB';
    } else {
        $mysize = sprintf(_MD_NUMBYTES, $size);
    }

    return $mysize;
}

/**
 * Establece el array para calcular los ratings
 * Sin Parámetros
 * Devuelve el porcentaje de votos para aumentar
 * un punto de rating
 */
function rmdp_set_rating()
{
    global $xoopsDB;

    [$rate] = $xoopsDB->fetchRow($xoopsDB->query('SELECT rating FROM ' . $xoopsDB->prefix('rmdp_software') . ' ORDER BY rating DESC LIMIT 0, 1'));

    $rtn = $rate / 5;

    return $rtn;
}

/**
 * Calcula el rating de una descarga
 * Params
 * @votos = Cantidad de votos de la descarga
 * @rate  = valor necesario de votos para ganar puntos
 * @param mixed $votos
 * @param mixed $rate
 * @return int
 * @return int
 */
function rmdp_calculate_rating($votos, $rate)
{
    if (0 == $rate) {
        return 0;
    }

    if ($votos < $rate) {
        return 0;
    } elseif ($votos == $rate) {
        return 1;
    }

    $rtn = (int)($votos / $rate);

    return $rtn;
}

/**
 * Determina si una descarga pertenece a las descargas patrocinadas
 * Parámetros:
 * @ids    = Id de la descarga
 * @param mixed $ids
 * @return int = true o false
 */
function rmdp_element_issponsor($ids)
{
    global $xoopsDB;

    if ($ids <= 0) {
        return 0;
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT id_soft FROM ' . $xoopsDB->prefix('rmdp_partners') . " WHERE id_soft='$ids'"));

    if ($num > 0) {
        return 1;
    }

    return 0;
}

/**
 * Devuelve el nombre de usuario
 * Parámetros
 * @idu = Id del usuario
 * @param mixed $idu
 * @param mixed $que
 * @return mixed|void
 * @return mixed|void
 */
function rmdp_get_username($idu, $que = 'uname')
{
    global $xoopsDB;

    if ($idu <= 0) {
        return;
    }

    [$rtn] = $xoopsDB->fetchRow($xoopsDB->query("SELECT $que FROM " . $xoopsDB->prefix('users') . " WHERE uid='$idu'"));

    return ($rtn);
}

/**
 * Devuelve el nombre de una plataforma
 * Parámetros
 * @ids = id de la descarga
 * @param mixed $ids
 * @return string|void
 * @return string|void
 */
function rmdp_get_downos($ids)
{
    global $xoopsDB;

    $rtn = '';

    if ($ids <= 0) {
        return;
    }

    $tblos = $xoopsDB->prefix('rmdp_plataformas');

    $tblr = $xoopsDB->prefix('rmdp_softos');

    $result = $xoopsDB->query("SELECT $tblr.*, $tblos.nombre FROM $tblr, $tblos WHERE $tblr.id_soft='$ids' AND $tblos.id_os=$tblr.id_os LIMIT 0,3");

    $num = $xoopsDB->getRowsNum($result);

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $rtn .= $row['nombre'] . ', ';
    }

    if (', ' == mb_substr($rtn, mb_strlen($rtn) - 2, 2)) {
        $rtn = mb_substr($rtn, 0, -3);
    }

    if ($num > 3) {
        $rtn .= ' ...';
    }

    return ($rtn);
}

/**
 * Obtiene la cadena de posición actual del objeto
 * @param mixed $idc
 * @return string
 * @return string
 */
function rmdp_get_location($idc)
{
    global $xoopsDB;

    $rtn = '';

    [$id, $nombre, $parent] = $xoopsDB->fetchRow($xoopsDB->query('SELECT id_cat, nombre, parent FROM ' . $xoopsDB->prefix('rmdp_categos') . " WHERE id_cat='$idc'"));

    if ($parent > 0) {
        $rtn .= rmdp_get_location($parent);
    }

    $rtn .= "<a href='categos.php?id=" . $id . "'>$nombre</a> <img src='images/arrow.gif' align='absmiddle'> ";

    return $rtn;
}

/**
 * Comprueba si un usuario es el publicador de una descarga
 * Parámetros
 * @uid    = Id del usuario
 * @ids    = Id de la descarga
 * @param mixed $uid
 * @param mixed $ids
 * @return bool = true, false
 */
function rmdp_is_publisher($uid, $ids)
{
    global $xoopsDB;

    if ($uid <= 0 || $ids <= 0) {
        return false;
    }

    [$num] = $xoopsDB->fetchRow($xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software') . " WHERE id_soft='$ids' AND submitter='$uid'"));

    if ($num <= 0) {
        return false;
    } elseif (1 == $num) {
        return true;
    }
}

/**
 * Devuelve las licencias existentes en la base de datos
 **/
function rmdp_licence_list()
{
    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_licences') . ' ORDER BY nombre');

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append('licencias', ['id' => $row['id_lic'], 'nombre' => $row['nombre']]);
    }
}

/**
 * Devuelve las plataformas existentes en la base de datos
 **/
function rmdp_plataforms_list()
{
    global $xoopsDB, $xoopsTpl;

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('rmdp_plataformas') . ' ORDER BY nombre');

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $xoopsTpl->append('plataformas', ['id' => $row['id_os'], 'nombre' => $row['nombre']]);
    }
}

/**
 * Función para determinar cual editor
 * utilizar para las descripciones de las categorías
 * @param mixed $caption
 * @param mixed $name
 * @param mixed $value
 * @param mixed $width
 * @param mixed $height
 * @param mixed $addon
 * @param mixed $as_object
 *
 * @return false|\sting|string|\XoopsFormDhtmlTextArea|\XoopsFormEditor|\XoopsFormFckeditor|\XoopsFormHtmlarea|\XoopsFormSpaw|\XoopsFormTextArea|\XoopsFormWysiwygTextArea|null
 * @return false|\sting|string|\XoopsFormDhtmlTextArea|\XoopsFormEditor|\XoopsFormFckeditor|\XoopsFormHtmlarea|\XoopsFormSpaw|\XoopsFormTextArea|\XoopsFormWysiwygTextArea|null
 */
function rmdpGetEditor($caption, $name, $value = '', $width = '100%', $height = '400px', $addon = '', $as_object = true)
{
    global $xoopsModuleConfig;

    $editor = false;

    $x22 = false;

    $xv = str_replace('XOOPS ', '', XOOPS_VERSION);

    if ('2' == mb_substr($xv, 2, 1)) {
        $x22 = true;
    }

    $editor_configs = [];

    $editor_configs['name'] = $name;

    $editor_configs['value'] = $value;

    $editor_configs['rows'] = 15;

    $editor_configs['cols'] = 50;

    $editor_configs['width'] = $width;

    $editor_configs['height'] = $height;

    switch (mb_strtolower($xoopsModuleConfig['editor'])) {
        case 'spaw':
            if (!$x22) {
                if (is_readable(XOOPS_ROOT_PATH . '/class/spaw/formspaw.php')) {
                    require_once XOOPS_ROOT_PATH . '/class/spaw/formspaw.php';

                    $editor = new XoopsFormSpaw($caption, $name, $value);
                }
            } else {
                $editor = new XoopsFormEditor($caption, 'spaw', $editor_configs);
            }
            break;
        case 'fck':
            if (!$x22) {
                if (is_readable(XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php')) {
                    require_once XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php';

                    $editor = new XoopsFormFckeditor($caption, $name, $value);
                }
            } else {
                $editor = new XoopsFormEditor($caption, 'fckeditor', $editor_configs);
            }
            break;
        case 'htmlarea':
            if (!$x22) {
                if (is_readable(XOOPS_ROOT_PATH . '/class/htmlarea/formhtmlarea.php')) {
                    require_once XOOPS_ROOT_PATH . '/class/htmlarea/formhtmlarea.php';

                    $editor = new XoopsFormHtmlarea($caption, $name, $value);
                }
            } else {
                $editor = new XoopsFormEditor($caption, 'htmlarea', $editor_configs);
            }
            break;
        case 'dhtml':
            if (!$x22) {
                $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 10, 50, $supplemental);
            } else {
                $editor = new XoopsFormEditor($caption, 'dhtmltextarea', $editor_configs);
            }
            break;
        case 'textarea':
            $editor = new XoopsFormTextArea($caption, $name, $value);
            break;
        case 'koivi':
            if (!$x22) {
                if (is_readable(XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php')) {
                    require_once XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php';

                    $editor = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px', '');
                }
            } else {
                $editor = new XoopsFormEditor($caption, 'koivi', $editor_configs);
            }
            break;
    }

    if ($as_object) {
        return $editor;
    }

    return $editor->render();
}

/**
 * Creamos una cadena aleatoria
 * utilizada en varios casos
 * @param mixed $size
 * @param mixed $prefix
 *
 * @return string
 * @return string
 */
function rmdpRandomWord($size = 8, $prefix = 'rmdp_')
{
    $chars = 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $ret = '';

    $len = mb_strlen($chars);

    for ($i = 1; $i <= $size; $i++) {
        // mt_srand((double)microtime() * 1000000);

        $sel = random_int(0, $len);

        $ret .= mb_substr($chars, $sel, 1);
    }

    return $prefix . $ret;
}

/**
 * Permite redimensionar una imágen
 * a un tamaño dado
 * @param mixed $source
 * @param mixed $target
 * @param mixed $width
 */
function rmdpImageResize($source, $target, $width)
{
    //calculamos la altura proporcional

    $datos = getimagesize($source);

    $ratio = ($datos[0] / $width);

    $altura = round($datos[1] / $ratio);

    $type = mb_strrchr($target, '.');

    // esta será la nueva imagen reescalada

    $thumb = imagecreatetruecolor($width, $altura);

    switch ($type) {
        case '.jpg':
            $img = imagecreatefromjpeg($source);
            break;
        case '.gif':
            $img = imagecreatefromgif($source);
            break;
        case '.png':
            $img = imagecreatefrompng($source);
            break;
    }

    // con esta función la reescalamos

    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $width, $altura, $datos[0], $datos[1]);

    // la guardamos con el nombre y en el lugar que nos interesa.

    switch ($type) {
        case '.jpg':
            imagejpeg($thumb, $target, 80);
            break;
        case '.gif':
            imagegif($thumb, $target, 80);
            break;
        case '.png':
            imagepng($thumb, $target, 80);
            break;
    }
}
