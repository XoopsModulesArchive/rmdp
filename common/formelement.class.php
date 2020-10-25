<?php

/*********************************************************************
 * $Id: formelement.class.php,v 0.1.0 17/12/2005 20:10 BitC3R0 Exp $  *
 * -----------------------------------------------------------------  *
 * RMSOFT Gallery System 2.0                                          *
 * Sistema Avanzado de Galer&iacute;as                                       *
 * CopyRight © 2005 - 2006. Red M&eacute;xico Soft                           *
 * http://www.redmexico.com.mx                                        *
 * http://www.xoops-mexico.net                                        *
 *                                                                    *
 * This program is free software; you can redistribute it and/or      *
 * modify it under the terms of the GNU General Public License as     *
 * published by the Free Software Foundation; either version 2 of     *
 * the License, or (at your option) any later version.                *
 *                                                                    *
 * This program is distributed in the hope that it will be useful,    *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of     *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the       *
 * GNU General Public License for more details.                       *
 *                                                                    *
 * You should have received a copy of the GNU General Public          *
 * License along with this program; if not, write to the Free         *
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,     *
 * MA 02111-1307 USA                                                  *
 *                                                                    *
 * -----------------------------------------------------------------  *
 * formelement.class.php:                                             *
 * Clase b&aacute;sica para los elementos de un formulario                   *
 * -----------------------------------------------------------------  *
 * @copyright : © 2005 - 2006. BitC3R0.                                *
 * @autor     : BitC3R0                                                    *
 * @paquete   : RMSOFT GS 2.0                                            *
 * @version   : 0.1.0                                                    *
 * @modificado: 17/12/2005 08:10:47 p.m.                              *
 *********************************************************************/

class RMFormElement
{
    public $_name = '';

    public $_caption = '';

    public $_class = '';

    public $_extra = '';

    public $_required = '';

    public $_description = '';

    public function FormElement()
    {
        exit('Esta clase no debe ser instanciada');
    }

    public function setName($name)
    {
        $this->_name = trim($name);
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setClass($class)
    {
        $this->_class = $class;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function setCaption($caption)
    {
        $this->_caption = trim($caption);
    }

    public function getCaption()
    {
        return $this->_caption;
    }

    public function setDescription($desc)
    {
        $this->_description = $desc;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setExtra($extra)
    {
        $this->_extra = $extra;
    }

    public function getExtra()
    {
        return $this->_extra;
    }

    /**
     * Obtenemos la tabla html formateada
     * metodo abastracto
     */
    public function render()
    {
    }
}
