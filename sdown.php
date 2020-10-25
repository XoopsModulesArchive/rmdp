<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: sdown.php,v 1.1 2006/03/27 14:28:17 mikhail Exp $			        //
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

if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

require dirname(__DIR__, 2) . '/mainfile.php';
$db = XoopsDatabaseFactory::getDatabaseConnection();
$id = $_GET['id'] ?? 0;
$mir = $_GET['mir'] ?? 0;

if ($id <= 0) {
    echo "<script type='text/javascript'>
			window.close();
		</script>";
}

if ($mir > 0) {
    $result = $db->query('SELECT titulo,url FROM ' . $db->prefix('rmdp_mirrors') . " WHERE id_soft='$id'");

    [$seguro] = $db->fetchRow($db->query('SELECT seguro FROM ' . $db->prefix('rmdp_software') . " WHERE id_soft='$id'"));
} else {
    $result = $db->query('SELECT archivo,filetype,seguro FROM ' . $db->prefix('rmdp_software') . " WHERE id_soft='$id'");
}
if ($db->getRowsNum($result) <= 0) {
    echo "<script type='text/javascript'>
			window.close();
		</script>";
}

$row = $db->fetchArray($result);

if ($mir > 0) {
    if (0 == $seguro) {
        echo "<script type='text/javascript'>
				window.close();
			</script>";
    }

    $mc = $xoopsModuleConfig;

    $file = $row['url'];

    $temp = explode('/', $row['url']);

    $filename = $temp[count($temp) - 1];
} else {
    if (0 == $row['seguro']) {
        echo "<script type='text/javascript'>
				window.close();
			</script>";
    }

    $mc = $xoopsModuleConfig;

    if ($row['filetype']) {
        //if (substr($mc['softdir'],strlen($mc['softdir']) - 1, 1)!='/'){ $mc['softdir'] .= '/'; }

        $file = str_replace('{XOOPS_PATH}', XOOPS_ROOT_PATH, $xoopsModuleConfig['softdir'] . '/' . $row['archivo']);

        $file = str_replace('{RMDP_PATH}', XOOPS_ROOT_PATH . '/modules/rmdp/', $file);

        $filename = $row['archivo'];
    } else {
        $file = $row['archivo'];

        $temp = explode('/', $row['archivo']);

        $filename = $temp[count($temp) - 1];
    }
}

//echo $file; die();

if (headers_sent()) {
    echo "<script type='text/javascript'>
			alert('" . _RMDP_DOWNS_ERRHEADERS . "');
			window.close();
		</script>";
}

header('Content-Type: application/octet-stream');
if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])) {
    header('Content-Disposition: inline; filename="' . $filename . '"');

    header('Expires: 0');

    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

    header('Pragma: public');
} else {
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    header('Expires: 0');

    header('Pragma: no-cache');
}

readfile($file);
exit();
