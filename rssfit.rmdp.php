<?php

// $Id: rssfit.rmdp.php,v 1.2 2006/03/27 16:31:54 mikhail Exp $
###############################################################################
##                RSSFit - Extendable XML news feed generator                ##
##                   Copyright (c) 2004 NS Tai (aka tuff)                    ##
##                       <http://www.brandycoke.com>                        ##
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <https://www.xoops.org>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
/*
* About this RSSFit plug-in
* Author: agamen0n <http://www.tradux.underpop.com>
* Requirements:
*  Module: RMDP <http://www.xoops-mexico.net>
*  Version: 1.0
*  RSSFit version: 1.1
*/

if (!defined('RSSFIT_ROOT_PATH')) {
    exit();
}

class Rssfitrmdp extends XoopsObject
{
    public $dirname = 'rmdp';

    public $modname;

    public $module;

    public $grab;

    public function __construct()
    {
    }

    public function loadModule()
    {
        global $moduleHandler;

        $mod = $moduleHandler->getByDirname($this->dirname);

        if (!$mod || !$mod->getVar('isactive')) {
            return false;
        }

        $this->modname = $mod->getVar('name');

        $this->module = &$mod;

        return $mod;
    }

    public function grabEntries(&$obj)
    {
        global $xoopsDB, $modulepermHandler;

        $ret = [];

        $i = 0;

        $sql = 'SELECT id_soft, id_cat, nombre, fecha, longdesc FROM ' . $xoopsDB->prefix('rmdp_software') . ' ORDER BY fecha DESC';

        $result = $xoopsDB->query($sql, $this->grab, 0);

        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            $ret[$i]['title'] = $row['nombre'];

            $link = XOOPS_URL . '/modules/' . $this->dirname . '/down.php?id=' . $row['id_soft'];

            $ret[$i]['link'] = $ret[$i]['guid'] = $link;

            $ret[$i]['timestamp'] = $row['fecha'];

            $ret[$i]['description'] = $row['longdesc'];

            $ret[$i]['category'] = $this->modname;

            $ret[$i]['domain'] = XOOPS_URL . '/modules/' . $this->dirname . '/';

            $i++;
        }

        return $ret;
    }
}
