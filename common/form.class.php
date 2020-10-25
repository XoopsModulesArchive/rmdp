<?php

/*******************************************************************
 * $Id: Default.php,v 0.1.0 16/12/2005 15:39 BitC3R0 Exp $          *
 * -------------------------------------------------------          *
 *                                                                  *
 * This program is free software; you can redistribute it and/or    *
 * modify it under the terms of the GNU General Public License as   *
 * published by the Free Software Foundation; either version 2 of   *
 * the License, or (at your option) any later version.              *
 *                                                                  *
 * This program is distributed in the hope that it will be useful,  *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of   *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the     *
 * GNU General Public License for more details.                     *
 *                                                                  *
 * You should have received a copy of the GNU General Public        *
 * License along with this program; if not, write to the Free       *
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,   *
 * MA 02111-1307 USA                                                *
 *                                                                  *
 * -------------------------------------------------------          *
 * Default.php: Archivo PHP                                         *
 * -------------------------------------------------------          *
 * @copyright :  2005 - 2006. BitC3R0.                              *
 * @autor     : BitC3R0                                                  *
 * @paquete   : Archivo PHP                                            *
 * @version   : 0.1.0                                                  *
 * @modificado: 16/12/2005 03:39:24 p.m.                            *
 *******************************************************************/

require XOOPS_ROOT_PATH . '/modules/rmdp/common/formelement.class.php';
require XOOPS_ROOT_PATH . '/modules/rmdp/common/formtexts.class.php';
require XOOPS_ROOT_PATH . '/modules/rmdp/common/formdates.class.php';

class RMForm
{
    public $_fields = [];

    public $_name = '';

    public $_action = '';

    public $_extra = '';

    public $_method = '';

    public $_title = '';

    /**
     * Funci&oacute;n inicializadora
     * @param mixed $title
     * @param mixed $name
     * @param mixed $action
     * @param mixed $method
     */
    public function __construct($title, $name, $action, $method = 'post')
    {
        $this->_name = $name;

        $this->_action = $action;

        $this->_method = $method;

        $this->_title = $title;
    }

    /**
     * Agregar un nuevo campo de texto
     * @param mixed $extra
     */
    public function setExtra($extra)
    {
        $this->_extra = $extra;
    }

    public function getExtra()
    {
        return $this->_extra;
    }

    public function setMehod($method)
    {
        if ('post' == $method || 'get' == $method) {
            $this->_method = $method;
        }
    }

    public function setName($name)
    {
        $this->_name = trim($name);
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Agregamos nuevos elementos
     * Estos elementos son instanacias de algun elemento de formulario
     * @param mixed $element
     */
    public function addElement($element)
    {
        $this->_fields[] = $element;
    }

    /**
     * Devolvemos el codigo HTML
     */
    public function render()
    {
        $ret = "<form name='" . $this->_name . "' id='" . $this->_name . "' action='" . $this->_action . "' method='" . $this->_method . "' " . $this->_extra . ">
				<table width='100%' class='outer' cellspacing='1'>
					<tr><th colspan='2'>" . $this->_title . '</th></tr>';

        foreach ($this->_fields as $element) {
            if (is_a($element, 'RMSubTitle') || is_a($element, 'RMHidden')) {
                $ret .= $element->render();
            } else {
                $ret .= "<tr align='left' class='even'><td class='even'>" . $element->getCaption();

                if ('' != $element->getDescription()) {
                    $ret .= "<br><br><span style='font-size: 10px;'>" . $element->getDescription() . '</span></td>';
                }

                $ret .= '<td>' . $element->render() . '</td></tr>';
            }
        }

        $ret .= '</table></form>';

        return $ret;
    }

    /**
     * Escribe el contenido HTML
     */
    public function display()
    {
        echo $this->render();
    }
}
