<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: index.php,v 1.5 23/11/2005 13:42:57 BitC3R0 Exp $                   //
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

$location = 'indice';
require dirname(__DIR__, 3) . '/include/cp_header.php';
if (!file_exists('../language/' . $xoopsConfig['language'] . '/admin.php')) {
    include '../language/spanish/admin.php';
}

require __DIR__ . '/functions.php';
xoops_cp_header();
DP_ShowNav();

/**
 * Mostramos la lista de categorias
 */
// $result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmdp_categos")." WHERE parent='0' LIMIT 0,10");
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_categos'));
[$numCat] = $xoopsDB->fetchRow($result); // Numero de categorias existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_software'));
[$numSoft] = $xoopsDB->fetchRow($result); // Numero de programas existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_partners'));
[$numSpon] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_caracteristicas'));
[$numCars] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_licences'));
[$numLics] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_plataformas'));
[$numOs] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_sended'));
[$numSend] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes
$result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('rmdp_shots'));
[$numShots] = $xoopsDB->fetchRow($result); // Numero de patrocinadores existentes

// Creamos la tabla con la información actual
echo "<br><table width='50%' cellspacing='1' class='outer' align='left'>";
echo "<tr><th colspan='3'>" . _AM_RMDP_ACTUALSTATUS . '</th></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_CATEGOS . "</td>\n
      <td class='odd' align='center'><strong>$numCat</strong></td><td class='odd' align='center'>
	  <a href='categos.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_DOWNS . "</td>\n
      <td class='odd' align='center'><strong>$numSoft</strong></td><td class='odd' align='center'>
	  <a href='downs.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_SPONSOR . "</td>\n
      <td class='odd' align='center'><strong>$numSpon</strong></td><td class='odd' align='center'>
	  <a href='sponsor.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_CARS . "</td>\n
      <td class='odd' align='center'><strong>$numCars</strong></td><td class='odd' align='center'>
	  &nbsp;</td></tr>";
echo "<tr><td class='even' align='left'>" . _AM_RMDP_LICS . "</td>\n
      <td class='odd' align='center'><strong>$numLics</strong></td><td class='odd' align='center'>
	  <a href='lics.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_OSNUM . "</td>\n
      <td class='odd' align='center'><strong>$numOs</strong></td><td class='odd' align='center'>
	  <a href='os.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_DSEND . "</td>\n
      <td class='odd' align='center'><strong>$numSend</strong></td><td class='odd' align='center'>
	  <a href='sended.php'>" . _AM_RMDP_SEE . '</a></td></tr>';
echo "<tr><td class='even' align='left'>" . _AM_RMDP_NSHOTS . "</td>\n
      <td class='odd' align='center'><strong>$numShots</strong></td><td class='odd' align='center'>
	  &nbsp;</td></tr>";
echo '</table>';

// Mostramos la configuración actual del sistema
echo "<table width='50%' class='outer' cellspacing='1'>\n
		<tr><th colspan='2' align='center'>Configuración del Sistema</th></tr>";
echo "<tr><td class='even'>&nbsp;</td>";
echo "<td class='odd'>&nbsp;</td></tr></table>";

xoops_cp_footer();


