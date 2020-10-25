<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: header.php,v 1.5 23/11/2005 13:38:47 BitC3R0 Exp $                  //
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

include '../../mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';
$myts = MyTextSanitizer::getInstance();
$xoops_module_header = '<link rel="stylesheet" type="text/css" href="rmdp.css">';
$xoopsTpl->assign('rmdp_title', $xoopsModuleConfig['rmdptitle']);
$xoopsTpl->assign('module_path', XOOPS_ROOT_PATH . '/modules/rmdp');
$xoopsTpl->assign('module_language', $xoopsConfig['language']);
$xoopsTpl->assign('show_images', $xoopsModuleConfig['showimgcat']);
$xoopsTpl->assign('thumb_width', $xoopsModuleConfig['imgdownw']);
$xoopsTpl->assign('rmdp_uri', $_SERVER['PHP_SELF']);


