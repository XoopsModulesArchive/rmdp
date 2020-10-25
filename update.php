<?php

require __DIR__ . '/header.php';

$ok = $_POST['ok'] ?? 0;

if ($ok <= 0) {
    echo "<div class='outer' style='padding: 2px;'><div class='even'><br>
			<form name='frm' method='post' action='update.php'>
			Bienvenido al script de actualización de RMSOFT Downloads Plus 1.5.<br><br>
			<strong>IMPORTANTE!:</strong> Este script debería utilizarse para actualizar
			la versión 1.2 de RMSOFT Downloads Plus. Haz una copia de respaldo de tus datos
			antes de proceder.<br><br>
			Para continuar solamente oprime el botón \"Proceder\".<br><br>
			<input type='submit' name='sbt' value='PROCEDER'>
			<input type='hidden' name='ok' value='1'></form></div></div>";
} else {
    /**
     * Actualizamos las tablas de la base de datos
     * @param mixed $msg
     */

    function showerror($msg)
    {
        global $xoopsDB;

        if ('' != $xoopsDB->error()) {
            echo '<br>' . $msg . '  -  ERROR: ' . $xoopsDB->error();
        } else {
            echo '<br>' . $msg . ' !LISTO!';
        }
    }

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_categos') . "` ADD `imgtype` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `img`");

    showerror('Actualizando tabla "Categorías"...');

    $xoopsDB->queryF(
        'CREATE TABLE `' . $xoopsDB->prefix('rmdp_mirrors') . "` (
	  `id_mir` int(11) NOT NULL auto_increment,
	  `id_soft` int(11) NOT NULL default '0',
	  `titulo` varchar(100) NOT NULL default '',
	  `url` varchar(255) NOT NULL default '',
	  `status` tinyint(1) NOT NULL default '0',
	  PRIMARY KEY  (`id_mir`)
	) ENGINE=MyISAM ;"
    );

    showerror('Creando tabla "Replicas"...');

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_sended') . '` CHANGE `id_send` `id_soft` INT( 11 ) NOT NULL AUTO_INCREMENT ');

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_sended') . "` ADD `filetype` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `archivo`");

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_sended') . "` ADD `imgtype` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `img`");

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_sended') . "` CHANGE `ids` `id_mod` INT( 11 ) NOT NULL DEFAULT '0' ");

    showerror('Actualizando tabla "Envios"...');

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_shots') . "` ADD `type` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `hits`");

    showerror('Actualizando tabla "Pantallas"...');

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_software') . "` ADD `filetype` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `archivo`");

    $xoopsDB->queryF('ALTER TABLE `' . $xoopsDB->prefix('rmdp_software') . "` ADD `imgtype` TINYINT( 1 ) DEFAULT '0' NOT NULL AFTER `img`");

    showerror('Actualizando tabla "Software"...');

    echo "<br><br><div class='outer' style='padding: 1px;'><div class='even'>
		  	<strong>Actualización finalizada!</strong><br><br>
			Ahora por favor sigue los siguientes pasos para completar la actualización.<br><br>
			<ol>
			  <li>Copia los nuevos archivos de RMSOFT Downloads Plus 1.5 a tu sitio web 
			  sobreescribiendo los archivos existentes</li>
			  <li>Ve al panel de control de XOOPS -> Administración de Módulos</li>
			  <li>Actualiza el Módulo.</li>
			  <li>¡LISTO!. RMSOFT Downloads Plus ha quedado actualizado a la versión 1.5</li>
			  <li>Elimina este archivo \"update.php\"</li>
			</ol><br>
			
			Para información o ayuda por favor visita <a href='http://www.xoops-mexico.net'>www.xoops-mexico.net</a><br>
		  </div></div>";
}

require __DIR__ . '/footer.php';
