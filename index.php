<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: index.php,v 1.5 23/11/2005 13:39:21 BitC3R0 Exp $                   //
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

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'rmdp_index.html'; //Plantilla para esta página

//Cargamos las descargas patrocinadas
require __DIR__ . '/include/rmdp_functions.php';
rmdp_get_sponsor();

rmdp_make_searchnav();
// Obtenemos una descarga aleatoría
//rmdp_today_download();

// Obtenemos la lista de categorías
get_categos_list();

//Obtenemos lo nuevo en las categorías
rmdp_get_thenew();

//Obtenemos los favoritos
rmdp_get_favorites(0);

//Obtenemos las descargas recientes
rmdp_get_popular(0);

$xoopsTpl->assign('lang_download_now', _RMDP_DOWNLOAD_NOW);
//$xoopsTpl->assign('lang_today', _RMDP_DOWNLOAD_TODAY);
//$xoopsTpl->assign('lang_seall', _RMDP_SEALL_INCAT);
$xoopsTpl->assign('lang_popular', _RMDP_POPULAR);
$xoopsTpl->assign('lang_bestrated', _RMDP_BEST_RATED);
//$xoopsTpl->assign('lang_forums', _RMDP_FORUMS);
//$xoopsTpl->assign('lng_moredownloads',_RMDP_MORE_DOWNLOADS);
$xoopsTpl->assign('download_imgw', $xoopsModuleConfig['imgdownw']);
$xoopsTpl->assign('catego_imgw', $xoopsModuleConfig['imgcategow'] + 10);
//$xoopsTpl->assign('lang_our_favorites', _RMDP_OUR_FAVORITES);
//$xoopsTpl->assign('lang_popular_soft', _RMDP_POPULAR_SOFT);
$xoopsTpl->assign('lng_favmsg', sprintf(_RMDP_FAVORITE_TEXT, $xoopsModuleConfig['favo_downs']));
//$xoopsTpl->assign('lang_sponsornews',_RMDP_SPONSOR_NEWS);
$xoopsTpl->assign('module_language', $xoopsConfig['language']);
$xoopsTpl->assign('root_path', XOOPS_ROOT_PATH);
$xoopsTpl->assign('rmdp_showbanner', $xoopsModuleConfig['banners']);
if (1 == $xoopsModuleConfig['banners']) {
    $xoopsTpl->assign('code_banner', $xoopsModuleConfig['banncode']);
}

include 'footer.php';


