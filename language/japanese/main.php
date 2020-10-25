<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: main.php,v 1.1 2006/03/27 14:28:43 mikhail Exp $                    //
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
global $rmdp_location;

define('_RMDP_DOWNLOAD_NOW', 'Descargar Ahora');
define('_RMDP_DOWNLOAD_TODAY', 'Descarga de Hoy');
define('_RMDP_THENEW_INCAT', 'Lo nuevo en: %s');
define('_RMDP_SEALL_INCAT', 'Ver Todo');
define('_RMDP_MORE_DOWNLOADS', 'Mas Descargas');
define('_RMDP_POPULAR', 'Popular');
define('_RMDP_BEST_RATED', 'Mejor Valorado');
define('_RMDP_FORUMS', 'Foros');
define('_RMDP_OUR_FAVORITES', 'Nuestros Favoritos');
define('_RMDP_POPULAR_SOFT', 'Software Popular');
define('_RMDP_FAVORITE_TEXT', 'Aqui te mostramos %s descargas gratuitas que te gustar&aacute;n');
define('_RMDP_SPONSOR_NEWS', 'Novedades Destacadas');
define('_RMDP_TOTAL_RESULTS', '%s - %s de %s');
define('_RMDP_RESULT_PAGES', 'P&aacute;gina: ');
define('_RMDP_VOTES', '(%s votos)');
define('_RMDP_NEW_DOWN', 'Nuevo');
define('_RMDP_UPDATE_DOWN', 'Actualizado');
define('_RMDP_ERR_ACCESS', 'Lo sentimos, no tiene acceso a esta categor&iacute;a');
define('_RMDP_CANCEL_BUTTON', 'Cancelar');
define('_RMDP_SEND_BUTTON', 'Enviar');

/**
 * Cadenas para la barra de busqueda
 */
define('_RMDP_ALL_WEB', 'Buscar en todo %s');
define('_RMDP_SEARCH_BUTTON', 'Buscar');
define('_RMDP_VIEW_FAV', 'Ver Favoritos');
define('_RMDP_VIEW_POP', 'Ver Popular');
define('_RMDP_VIEW_RATED', 'Ver Mejor Valorado');
define('_RMDP_SUBMIT_DOWN', 'Enviar Descargas');

/**
 * Cadenas para los resultados
 **/
define('_RMDP_SUBCATEGOS_IN', 'Subcategor&iacute;as en "%s"');
define('_RMDP_DOWNS_INCATEGO', 'Descargas en %s');
define('_RMDP_RESORT_BY', 'Ordenar por:');
define('_RMDP_ORDER_NAME', 'Nombre');
define('_RMDP_ORDER_DATE', 'Fecha');
define('_RMDP_ORDER_RATING', 'Rating');
define('_RMDP_ORDER_OURRATING', 'Nuestro Rating');
define('_RMDP_ORDER_DOWNLOADS', 'Descargas');
define('_RMDP_ORDER_SUBMITTER', 'Envi&oacute;');
define('_RMDP_OS', 'SO:');
define('_RMDP_VERSION', 'Versi&oacute;n:');
define('_RMDP_FILE_SIZE', 'Tama&ntilde;o:');
define('_RMDP_LICENCE', 'Licencia:');
define('_RMDP_SPONSORED', 'DESTACADO');
define('_RMDP_VIEW_SHOT', 'Ver Pantallas');

define('_RMDP_DOWNS_INCATS', 'Ultimas descragas en %s');
define('_RMDP_DOWNS_INCATS_DESC', 'Descargas recientes en la categoría %s de %s');
define('_RMDP_DOWNS_LASTDESC', 'Ultimas descargas en el sitio');
define('_RMDP_DOWNS_ERRHEADERS', 'Sorry, there was an error. Please try again');

if ('downloads' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_downloads.php';
} elseif ('votos' == $rmdp_location) {
    define('_RMDP_NO_ACCESS', 'Lo sentimos, debes registrarte para poder votar');

    define('_RMDP_IS_PUBLISHER', 'Lo sentimos, no puedes votar por tus propias descargas');

    define('_RMDP_VOTE_ONEDAY', 'Solo puedes votar una vez por dia por el mismo recurso');

    define('_RMDP_VOTE_THX', 'Gracias por tu voto. Por favor agrega un comentario acerca de este recurso');

    define('_RMDP_VOTE_ERR', 'Ocurrio un error al registrar tu voto, por favor vuelve a intentarlo');

    define('_RMDP_NOVOTE_TWICE', 'No puedes votar dos veces por el mismo recurso');
} elseif ('shots' == $rmdp_location) {
    define('_RMDP_LOCATION_SHOT', 'Pantallas');

    define('_RMDP_DOWN_SHOTS', 'Pantallas de %s');

    define('_RMDP_ERR_NOTFOUND', 'No se encontr&oacute; la pantalla especificada');

    define('_RMDP_BACK', 'Haz click para volver');
} elseif ('popular' == $rmdp_location) {
    define('_RMDP_POPULAR_TITLE', 'Descargas Populares');

    define('_RMDP_TOP_POP', 'Nuestras <strong>%s</strong> descargas mas populares');
} elseif ('favoritos' == $rmdp_location) {
    define('_RMDP_TOP_FAVS', 'Nuestro Software Favorito');

    define('_RMDP_FAVORITE_TITLE', 'Nuestros Favoritos');
} elseif ('mejorval' == $rmdp_location) {
    define('_RMDP_RATED_TITLE', 'Descargas Mejor Valoradas');

    define('_RMDP_TOP_RATE', 'Las <strong>%s</strong> Descargas mejor valoradas');
} elseif ('submit' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_submit.php';
} elseif ('mysends' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_mysends.php';
} elseif ('search' == $rmdp_location) {
    define('_RMDP_SEARCH_RESULTS', 'Resultados para "%s"');

    define('_RMDP_NOSEARCH_KEY', 'No especificaste una cadena de b&uacute;squeda');
} elseif ('broken' == $rmdp_location) {
    define('_RMDP_ERR_NOTFOUND', 'No se encontró la descarga especificada');

    define('_RMDP_NO_USER', 'Para poder reportar un enlace roto debes ser un usuario registrado');

    define(
        '_RMDP_BROKEN_BODY',
        "Hola %s:\n\nUna descarga tuya ha sido reportada como errónea. Te suplicamos comprobar los datos cuanto antes. Para hacerlo puedes ingresar a:\n\n%s\n\nTambien puedes comprobar todas tus descargas en "
        . XOOPS_URL
        . "/modules/rmdp/mysend.php \n\nComentario del usuario:\n\n \"%s\" \n\nAtentamente:\nEl equipo de Xoops México\nwww.xoops-mexico.net"
    );

    define('_RMDP_BROKEN_BODYADMIN', "El usuario %s ha reportado una descarga como errónea. Puedes revisar los datos en:\n\n%s\n\n O puedes ver la descarga en\n\n%s. \n\nComentario del usuario: \n\n\"%s\"");

    define('_RMDP_BROKEN_SEND', 'Tu reporte ha sido enviado. Gracias');

    define('_RMDP_BROKEN_SUBJECT', 'Reporte de descarga errónea');

    define('_RMDP_BROKEN_NOREPORT', 'No has escrito ningún mensaje para el reporte. Por favor intentalo nuevamente');
}


