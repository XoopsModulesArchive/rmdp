<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: modinfo.php,v 1.2 2006/03/27 16:17:25 mikhail Exp $                 //
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

//Traduzido por Hugo Christiano AKA agamen0n (Lingo -> http://lingo.underpop.com)

define('_MI_RMDP_NAME', 'RMSoft Downloads Plus 1.5');
define('_MI_RMDP_DESC', 'Módulo para administração avançada de downloads');

/**
 * Menus del administrador
 */
define('_MI_RMDP_AM1', 'Categorias Existentes');
define('_MI_RMDP_AM2', 'Nova Categoria');
define('_MI_RMDP_AM3', 'Downloads Existentes');
define('_MI_RMDP_AM4', 'Novo Download');
define('_MI_RMDP_AM5', 'Downloads Patrocinados');
define('_MI_RMDP_AM6', 'Nueva Compa&ntilde;&iacute;a');
define('_MI_RMDP_AM8', 'Plataformas');
define('_MI_RMDP_AM9', 'Licenças');
define('_MI_RMDP_AM10', 'Downloads Enviados');
define('_MI_RMDP_AM11', 'Modificações');

/**
 * SubMenu
 */
define('_MI_SEND_DOWNLOAD', 'Enviar');
define('_MI_SENDED_DOWNS', 'Meus Downloads');

/**
 * Opciones de Configuraci&oacute;n
 */
define('_MI_RMDP_MODTITLE', 'Título do Módulo:');
define('_MI_RMDP_CATGOIMGW', 'Tamanho das imagens de categorias:');
define('_MI_RMDP_SHOWCATIMG', 'Mostrar imagens das categorias');
define('_MI_RMDP_DOWNIMGW', 'Tamanho das imagens dos downloads:');
define('_MI_RMDP_SHOTIMGW', 'Tamanho das imagens pequenas de screenshots:');
define('_MI_RMDP_SHOTIMGBIGW', 'Tamanho das imagens grandes de screenshots:');
define('_MI_RMDP_SHOTIMGBIGD', 'Útil somente quando não se vincula diretamente às imagens');
define('_MI_RMDP_SHOTLINK', 'Vincular screenshots diretamente às imagens:');
define('_MI_RMDP_CATEGODAYSNEW', 'Dias para mostrar uma categoria como nova:');
define('_MI_RMDP_CARACTDAYSNEW', 'Dias para mostrar uma característica como nova:');
define('_MI_RMDP_SHOTDAYSNEW', 'Dias para mostrar um screenshot como novo:');
define('_MI_RMDP_SENDDOWN', 'Ativar o envio de downloads:');
define('_MI_RMDP_SENDANONIMO', 'visitantes anônimos podem enviar downloads:');
define('_MI_RMDP_CATWITHNEWS', 'Número de Categorias con novidades na página principal:');
define('_MI_RMDP_SPONSORNUM', 'Número de downloads patrocinadas a mostrar:');
define('_MI_RMDP_FAVORITESNUM', 'Número de downloads a mostrar en Favoritos:');
define('_MI_RMDP_POPULARNUM', 'Número de downloads a mostrar en Populares:');
define('_MI_RMDP_LENDESC', 'Quanditade de caracteres na descrição<br>dos downloads patrocinados:');
define('_MI_RMDP_SHOTLIMIT', 'Limite de screenshots por download:');
define('_MI_RMDP_SUBCATLIMIT', 'Número de subcategorias para mostrar:');
define('_MI_RMDP_RESALTEBG', 'Cor de Fundo para downloads em destaque (HEX):');
define('_MI_RMDP_LIMITRESULT', 'Limite de resultados por página:');
define('_MI_RMDP_UPDATEDAYS', 'Dias para considerar um elemento como atualizado:');
define('_MI_RMDP_DOWNNEW', 'Dias para considerar um download como novo:');
define('_MI_RMDP_DATEFORMAT', 'Formato de Data:');
define('_MI_RMDP_POPULARNEEDS', 'Downloads para considerar como popular<br>um elemento:');
define('_MI_RMDP_USERVOTE', 'Permitir votos de visitantes anônimos');
define('_MI_RMDP_OPENWINDOW', 'Comportamento dos downlodas:');
define('_MI_RMDP_OPENSAME', 'Abrir na mesma janela');
define('_MI_RMDP_OPENNEW', 'Abrir em outra janela');
define('_MI_RMDP_SHOTCOLS', 'Número de colunas para tabelas de screenshots:');
define('_MI_RMDP_TOPPOP', 'Número de downloads populares a mostrar');
define('_MI_RMDP_TOPFAV', 'Número de downloads favoritos a mostrar');
define('_MI_RMDP_TOPRATE', 'Número de downloads melhor avaliados a mostrar');
define('_MI_RMDP_SENDMAIL', 'Notificar por email quando se envia um download');
define('_MI_RMDP_BODYMAIL', 'Conteúdo do email de aceitação de downloads:');
define('_MI_RMDP_BORKENINFO', 'Texto informativo para visitantes que desejam reportar um erro em um download');
define('_MI_RMDP_SENDNOTITY', 'Enviar notificação por inatividade:');
define('_MI_RMDP_SENDNOTITY_DESC', 'Um email será enviado ao publicador/autor do download');
define('_MI_RMDP_ADMINNOTIFY', 'Enviar notificação ao administrador:');
define('_MI_RMDP_DAYSNOTIFY', 'Dias de inatividade antes de enviar uma notificação:');

// Bloques
define('_MI_RMDP_RECENT_TITLE', 'Downloads Recientes');
define('_MI_RMDP_POPULARTITLE', 'Downloads Top');
define('_MI_RMDP_UPDATETITLE', 'Downloads Atualizados');
define('_MI_RMDP_RATEDTITLE', 'Melhor Avaliados');
define('_MI_RMDP_LASTDOWN', 'Novo Download');

////////////////////////////////////////////
// NUEVOS O MODIFICADOS EN LA VERSIÓN 1.3 //
////////////////////////////////////////////
define('_MI_RMDP_BANNERS', 'Ativar banners no módulo:');
define('_MI_RMDP_BANNERS_CODE', 'Código para mostrar banners:');
define('_MI_RMDP_CONFIGCAT_IMGS', 'Configuração de Imagens');
define('_MI_RMDP_CONFIGCAT_DOWNS', 'Configuración de Downloads');
define('_MI_RMDP_SENDFILES', 'Ativar upload de arquivos:');
define('_MI_RMDP_SENDFILE_DESC', '<span style="font-size: 10px;">Ao ativar esta opção os visitantes poderão fazer upload de arquivos diretamente para o servidor</span>');
define('_MI_RMDP_SENDIMG', 'Ativar upload de imagens:');
define('_MI_RMDP_SENDIMG_DESC', 'Ao ativar esta opção os visitantes poderão fazer upload de imagens diretamente para o servidor');
define('_MI_RMDP_SHOTLINK_DESC', '<span style="font-size: 10px;">Se ativar, os visitantes serão direcionados diretamente ao arquivo de imagem quando clicarem em um screenshot. Do contrário as imagens serão carregadas em uma página do módulo.</span>');
define('_MI_RMDP_SOFTDIR', 'Diretório para uploads:');
define('_MI_RMDP_SOFTDIR_DESC', '<span style="font-size: 10px;">Indica o caminho do diretório onde se armazenarão os arquivos enviados pelos visitantes. Este diretório deve existir no servidor.<br>Tags útiles:<br>{XOOPS_PATH} = Ruta de XOOPS<br>{RMDP_PATH} = Ruta del módulo</span>');
define('_MI_RMDP_MIRRORSNUM', 'Número máximo mirrors:');
define('_MI_RMDP_MIRRORSNUM_DESC', '<span style="font-size: 10px;">Número mirrors para um download ou, também, número de formatos diferentes de arquivos para um download.</span>');
define('_MI_RMDP_FILESIZE', 'Tamanho máximo de arquivo para upload:');
define('_MI_RMDP_SIZEUNIT', 'Unidade de conversão para o tamanho de Arquivo:');
define('_AM_RMDP_EDITOR', 'Tipo de Editor para as descrições:');
define('_MI_RMDP_FORM_COMPACT', 'Compacto');
define('_MI_RMDP_FORM_DHTML', 'DHTML');
define('_MI_RMDP_FORM_SPAW', 'Editor Spaw');
define('_MI_RMDP_FORM_HTMLAREA', 'Editor HtmlArea');
define('_MI_RMDP_FORM_FCK', 'Editor FCK');
define('_MI_RMDP_FORM_KOIVI', 'Editor Koivi');
define('_MI_RMDP_FILETYPES', 'Tipos de arquivos aceitos:');
define('_MI_RMDP_FILETYPES_DESC', "Separar con '|' as extensões (.zip|.tar|etc)");
define('_MI_RMDP_RETARDO', 'Tempo de espera para iniciar um download:');
define('_MI_RMDP_RETARDO_DESC', 'Especificar en segundos.');
define('_MI_RMDP_BODYMAIL_DESC', '<span style="font-size: 10px;">Tags úteis:<br>{USER} = Nome do visitante.<br>{DOWN} = Nome do Download.<br>{LINK} = LINK para o download.<br>{URL} = URL do site.</span>');
