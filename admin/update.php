<?php

/**
 * Archivo de actualización para RMSOFT Downloads Plus
 * Versión 1.52 -> 1.54
 *
 * Para versiones anteriores primero actualizar a la
 * versión 1.52
 *
 * IMPORTANTE:  Eliminar después de la actualización
 */
require dirname(__DIR__, 3) . '/include/cp_header.php';

$now = $_POST['now'] ?? 0;

if ($now) {
    $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('rmdp_software') . " ADD `seguro` TINYINT ( 1 ) NOT NULL DEFAULT '0' AFTER `fecha`");

    $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('rmdp_software') . " ADD `lastdown` INT ( 11 ) NOT NULL DEFAULT '0' AFTER `seguro`");

    $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('rmdp_software') . " ADD `notified` TINYINT ( 1 ) NOT NULL DEFAULT '0' AFTER `seguro`");

    xoops_cp_header();

    echo "<table class='outer' style='width: 60%' cellspacing='1' cellpadding='0' align='center'>
			<tr class='even'><td align='center'>
			Se actualizarón las tablas de la base de datos.<br><br>
			<strong>Por favor no olvides eliminar este script</strong>.
			</td></tr></table>";

    xoops_cp_footer();
} else {
    xoops_cp_header();

    echo "<table class='outer' style='width: 60%' cellspacing='1' cellpadding='0' align='center'>
			<tr class='even'>
			 <td align='left'>
			 <h2>Actualización de RMSOFT Downloads Plus</h2>
			 <span style='color: #0066CC'>Este archivo actualizará la versión 1.52 a 1.54</span><br>
			 <span style='color: #FF0000;'>IMPORTANTE: Si cuentas con una versión anterior a la 1.52 primero
			 deberás actualizar tu versión a la 1.52.</span><br><br>
			 Este <strong>script</strong> actualizará la base de datos de RMSOFT Downloads Plus.
			 Una vez completado el proceso ve al <strong>Panel de Control de XOOPS</strong> y
			 actualiza el módulo desde la <strong>Administración de Módulos</strong>.<br><br>
			 No olvides eliminar este script cuando hayas finalizado la actualización.<br><br>
			 <form method='post' action='update.php' name='frmAct'>
			 	<input type='hidden' name='now' value='1'>
			 	<input type='submit' name='sbt' value='Actualizar Ahora' class='formButton'>
			 </form>
			 </td>
			</tr>
			</table>";

    xoops_cp_footer();
}
