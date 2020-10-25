<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: main.php,v 1.2 2006/03/27 16:17:25 mikhail Exp $ //
// ------------------------------------------------------------------------ //
// RM+Soft Downloads Plus 1.5 //
// Copyright © 2005. Red Mexico Soft //
// <www.redmexico.com.mx> //
// Modulo XOOPS que permite el control y distribución avanzado de //
// descargas. //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License, or //
// (at your option) any later version. //
// //
// This program is distributed in the hope that it will be useful, but //
// WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU //
// General Public License for more details. //
// //
// You should have received a copy of the GNU General Public License //
// along with this program; if not, write to the //
// Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, //
// MA 02111-1307 USA //
// ------------------------------------------------------------------------ //
// Questions, Bugs or any comment plese write me //
// Preguntas, errores o cualquier comentario escribeme //
// <adminone@redmexico.com.mx> //
// ------------------------------------------------------------------------ //
// Visita http://www.xoops-mexico.net para obtener los últimos módulos //
// de Red México Soft. //
// //
// For more modules from Red México Soft visit http://www.xoops-mexico.net //
// ------------------------------------------------------------------------ //
//////////////////////////////////////////////////////////////////////////////
//Traduzido por Hugo Christiano AKA agamen0n (Lingo -> http://lingo.underpop.com)
global $rmdp_location;
define('_RMDP_DOWNLOAD_NOW', 'Fazer Download Agora');
define('_RMDP_DOWNLOAD_TODAY', 'Download de hoje');
define('_RMDP_THENEW_INCAT', 'Novo em: %s');
define('_RMDP_SEALL_INCAT', 'Ver Tudo');
define('_RMDP_MORE_DOWNLOADS', 'Mais Downloads');
define('_RMDP_POPULAR', 'Popular');
define('_RMDP_BEST_RATED', 'Melhor Avaliado');
define('_RMDP_FORUMS', 'Fóruns');
define('_RMDP_OUR_FAVORITES', 'Nossos Favoritos');
define('_RMDP_POPULAR_SOFT', 'Software Popular');
define('_RMDP_FAVORITE_TEXT', 'Aqui mostramos a você os downloads gratuitos mais apreciados');
define('_RMDP_SPONSOR_NEWS', 'Novidade em Destaque');
define('_RMDP_TOTAL_RESULTS', '%s - %s de %s');
define('_RMDP_RESULT_PAGES', 'Página: ');
define('_RMDP_VOTES', '(%s votos)');
define('_RMDP_NEW_DOWN', 'Novo');
define('_RMDP_UPDATE_DOWN', 'Atualizado');
define('_RMDP_ERR_ACCESS', 'Desculpe, você não tem acesso à esta categoria');
define('_RMDP_CANCEL_BUTTON', 'Cancelar');
define('_RMDP_SEND_BUTTON', 'Enviar');
/**
 * Cadenas para la barra de busqueda
 */
define('_RMDP_ALL_WEB', 'Buscar em todo %s');
define('_RMDP_SEARCH_BUTTON', 'Buscar');
define('_RMDP_VIEW_FAV', 'Ver Favoritos');
define('_RMDP_VIEW_POP', 'Ver Popular');
define('_RMDP_VIEW_RATED', 'Ver Melhor Avaliado');
define('_RMDP_SUBMIT_DOWN', 'Enviar Downloads');
/**
 * Cadenas para los resultados
 **/
define('_RMDP_SUBCATEGOS_IN', 'Subcategorias em "%s"');
define('_RMDP_DOWNS_INCATEGO', 'Downloads em %s');
define('_RMDP_RESORT_BY', 'Ordenar por:');
define('_RMDP_ORDER_NAME', 'Nome');
define('_RMDP_ORDER_DATE', 'Data');
define('_RMDP_ORDER_RATING', 'Avaliação');
define('_RMDP_ORDER_OURRATING', 'Nossa Avaliação');
define('_RMDP_ORDER_DOWNLOADS', 'Downloads');
define('_RMDP_ORDER_SUBMITTER', 'Enviar;');
define('_RMDP_OS', 'SO:');
define('_RMDP_VERSION', 'Versão:');
define('_RMDP_FILE_SIZE', 'Tamanho:');
define('_RMDP_LICENCE', 'Licença:');
define('_RMDP_SPONSORED', 'DESTACADO');
define('_RMDP_VIEW_SHOT', 'Ver Screenshots');
define('_RMDP_DOWNS_INCATS', 'Últimos Downloads em %s');
define('_RMDP_DOWNS_INCATS_DESC', 'Downloads recentes na categoria %s de %s');
define('_RMDP_DOWNS_LASTDESC', 'Ultimos downloads no site');
define('_RMDP_DOWNS_ERRHEADERS', 'Sentimos muito, um erro ocorreu ao processar o arquivo. \nPor favor tente novamente');
define('_RMDP_SUBJECT_NOTIFY', 'Aviso de inatividade de download');
if ('downloads' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_downloads.php';
} elseif ('votos' == $rmdp_location) {
    define('_RMDP_NO_ACCESS', 'Desculpe, você deve se cadastrar para poder votar');

    define('_RMDP_IS_PUBLISHER', 'Desculpe, você não pode votar em seus próprios downloads');

    define('_RMDP_VOTE_ONEDAY', 'Você somente pode votar uma vez por dia para o mesmo arquivo');

    define('_RMDP_VOTE_THX', 'Obrigado por seu voto. Por favor adicione um cometário sobre este arquivo');

    define('_RMDP_VOTE_ERR', 'Ocorreu um erro ao registrar seu voto, tente novamente por favor');

    define('_RMDP_NOVOTE_TWICE', 'Não é possível votar duas vezes para o mesmo arquivo');
} elseif ('shots' == $rmdp_location) {
    define('_RMDP_LOCATION_SHOT', 'Screenshots');

    define('_RMDP_DOWN_SHOTS', 'Screenshots de %s');

    define('_RMDP_ERR_NOTFOUND', 'Não foi possível encontrar o download especificado');

    define('_RMDP_BACK', 'Clique para voltar');
} elseif ('popular' == $rmdp_location) {
    define('_RMDP_POPULAR_TITLE', 'Downloads Populares');

    define('_RMDP_TOP_POP', 'Nossos <b>%s</b> downloads mais populares');
} elseif ('favoritos' == $rmdp_location) {
    define('_RMDP_TOP_FAVS', 'Nosso Software Favorito');

    define('_RMDP_FAVORITE_TITLE', 'Nossos Favoritos');
} elseif ('mejorval' == $rmdp_location) {
    define('_RMDP_RATED_TITLE', 'Downloads melhor avaliados');

    define('_RMDP_TOP_RATE', 'Os <b>%s</b> Downloads Melhor Avaliados');
} elseif ('submit' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_submit.php';
} elseif ('mysends' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_mysends.php';
} elseif ('search' == $rmdp_location) {
    define('_RMDP_SEARCH_RESULTS', 'Resultados para "%s"');

    define('_RMDP_NOSEARCH_KEY', 'Você não especificou uma sequência de busca');
} elseif ('broken' == $rmdp_location) {
    define('_RMDP_ERR_NOTFOUND', 'Não foi possível encontrar o download especificado');

    define('_RMDP_NO_USER', 'Para reportar um link quebrado você deve ser um visitante cadastrado');

    define(
        '_RMDP_BROKEN_BODY',
        "Olá %s:\n\nUm download seu foi reportado como estando com erro. Pedimos para confirmar os dados o quanto antes. Para fazê-lo você pode entrar em:\n\n%s\n\nTambém é possível comprovar todos os seus downloads em "
        . XOOPS_URL
        . "/modules/rmdp/mysend.php \n\nComentario del usuario:\n\n \"%s\" \n\nAtentamente:\nEl equipo de Xoops México\nwww.xoops-mexico.net"
    );

    define('_RMDP_BROKEN_BODYADMIN', "O visitante %s reportou um download com erro. Você pode revisar os dados em:\n\n%s\n\n Ou pode ver o downlaod em\n\n%s. \n\nComentário do visitante: \n\n\"%s\"");

    define('_RMDP_BROKEN_SEND', 'Sua informação foi enviada. Obrigado.');

    define('_RMDP_BROKEN_SUBJECT', 'Reportar um download com erro');

    define('_RMDP_BROKEN_NOREPORT', 'Você não escreveu nenhum aviso no aviso que está reportando. Por favor tente novamente');
}
