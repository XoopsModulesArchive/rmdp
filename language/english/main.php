<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: main.php,v 1.5 23/11/2005 13:48:12 BitC3R0 Exp $                    //
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

define('_RMDP_DOWNLOAD_NOW', 'Download Now');
define('_RMDP_DOWNLOAD_TODAY', "Today's Download");
define('_RMDP_THENEW_INCAT', 'The new in: %s');
define('_RMDP_SEALL_INCAT', 'See All');
define('_RMDP_MORE_DOWNLOADS', 'More Downloads');
define('_RMDP_POPULAR', 'Popular');
define('_RMDP_BEST_RATED', 'Best Rated');
define('_RMDP_FORUMS', 'Forums');
define('_RMDP_OUR_FAVORITES', 'Our Favorites');
define('_RMDP_POPULAR_SOFT', 'Popular Software');
define('_RMDP_FAVORITE_TEXT', '');
define('_RMDP_SPONSOR_NEWS', 'Sponsor News');
define('_RMDP_TOTAL_RESULTS', '%s - %s of %s');
define('_RMDP_RESULT_PAGES', 'Page: ');
define('_RMDP_VOTES', '(%s votes)');
define('_RMDP_NEW_DOWN', 'New');
define('_RMDP_UPDATE_DOWN', 'Updated');
define('_RMDP_ERR_ACCESS', 'Sorry, you do not have access to this category');
define('_RMDP_CANCEL_BUTTON', 'Cancel');
define('_RMDP_SEND_BUTTON', 'Send');

/**
 * Cadenas para la barra de busqueda
 */
define('_RMDP_ALL_WEB', 'Search in all %s');
define('_RMDP_SEARCH_BUTTON', 'Search');
define('_RMDP_VIEW_FAV', 'Favorites');
define('_RMDP_VIEW_POP', 'Popular');
define('_RMDP_VIEW_RATED', 'Best Rated');
define('_RMDP_SUBMIT_DOWN', 'Send Downloads');

/**
 * Cadenas para los resultados
 **/
define('_RMDP_SUBCATEGOS_IN', 'Subcategories in "%s"');
define('_RMDP_DOWNS_INCATEGO', 'Downloads in %s');
define('_RMDP_RESORT_BY', 'Order by:');
define('_RMDP_ORDER_NAME', 'Name');
define('_RMDP_ORDER_DATE', 'Date');
define('_RMDP_ORDER_RATING', 'Rating');
define('_RMDP_ORDER_OURRATING', 'Our Rating');
define('_RMDP_ORDER_DOWNLOADS', 'Downloads');
define('_RMDP_ORDER_SUBMITTER', 'Publisher');
define('_RMDP_OS', 'OS:');
define('_RMDP_VERSION', 'Version:');
define('_RMDP_FILE_SIZE', 'Size:');
define('_RMDP_LICENCE', 'License:');
define('_RMDP_SPONSORED', 'Stand Out');
define('_RMDP_VIEW_SHOT', 'Screenshots');

define('_RMDP_DOWNS_INCATS', 'Recent downloads in %s');
define('_RMDP_DOWNS_INCATS_DESC', 'Recend downloads in the category %s from %s');
define('_RMDP_DOWNS_LASTDESC', 'Recent downloads in the site');

if ('downloads' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_downloads.php';
} elseif ('votos' == $rmdp_location) {
    define('_RMDP_NO_ACCESS', 'Sorry, first register to vote');

    define('_RMDP_IS_PUBLISHER', "Sorry, you can't vote for your owns downloads");

    define('_RMDP_VOTE_ONEDAY', 'You only can vote once per day for the same resource');

    define('_RMDP_VOTE_THX', 'Thanks for voting. Please write a review  about this download');

    define('_RMDP_VOTE_ERR', 'An error ocurred, please try again');

    define('_RMDP_NOVOTE_TWICE', "You can't vote twice for the same resource");
} elseif ('shots' == $rmdp_location) {
    define('_RMDP_LOCATION_SHOT', 'Screenshots');

    define('_RMDP_DOWN_SHOTS', "%s' Screenshots");

    define('_RMDP_ERR_NOTFOUND', 'The specified screenshot was not found');

    define('_RMDP_BACK', 'Click to go back');
} elseif ('popular' == $rmdp_location) {
    define('_RMDP_POPULAR_TITLE', 'Popular Downloads');

    define('_RMDP_TOP_POP', 'Our <strong>%s</strong> most popular downloads');
} elseif ('favoritos' == $rmdp_location) {
    define('_RMDP_TOP_FAVS', 'Our Favorite Software');

    define('_RMDP_FAVORITE_TITLE', 'Aour Favorites');
} elseif ('mejorval' == $rmdp_location) {
    define('_RMDP_RATED_TITLE', 'Best Rated Downbloads');

    define('_RMDP_TOP_RATE', 'The <strong>%s</strong> best rated Downloads');
} elseif ('submit' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_submit.php';
} elseif ('mysends' == $rmdp_location) {
    require __DIR__ . '/rmdp_lang_mysends.php';
} elseif ('search' == $rmdp_location) {
    define('_RMDP_SEARCH_RESULTS', 'Results for "%s"');

    define('_RMDP_NOSEARCH_KEY', 'You do not specify a search key');
} elseif ('broken' == $rmdp_location) {
    define('_RMDP_ERR_NOTFOUND', 'the specified download was not found');

    define('_RMDP_NO_USER', 'Before report borken links you must be registered');

    define('_RMDP_BROKEN_BODY', "Hi %s:\n\nA dowunload yours has been reported like erroneous. Please check the data as soon as possible. Go to:\n\n%s\n\nCheck all your downloads in " . XOOPS_URL . "/modules/rmdp/mysend.php \n\nUser Comment:\n\n \"%s\" \n\n");

    define('_RMDP_BROKEN_BODYADMIN', "The user %s have reported a broken download. You can chek the data in:\n\n%s\n\n or you can see this download in\n\n%s. \n\nUser comment: \n\n\"%s\"");

    define('_RMDP_BROKEN_SEND', 'Your report has been succesfully sent. Thank you');

    define('_RMDP_BROKEN_SUBJECT', 'Broken Download Report');

    define('_RMDP_BROKEN_NOREPORT', 'Please write a comment in report. Try again');
}


