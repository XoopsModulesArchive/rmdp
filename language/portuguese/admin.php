<?php

//////////////////////////////////////////////////////////////////////////////
// $Id: admin.php,v 1.2 2006/03/27 16:17:24 mikhail Exp $                   //
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

global $location;

define('_AM_RMDP_SEND', 'Enviar');
define('_AM_RMDP_CANCEL', 'Cancelar');
define('_AM_RMDP_MODIFY', 'Modificar');
define('_AM_RMDP_DELETE', 'Apagar');
define('_AM_RMDP_NEWCATEGO', 'Nova Categoria');
define('_AM_RMDP_YES', 'Sim');
define('_AM_RMDP_NO', 'Não');
define('_AM_RMDP_CATEGOFAIL', 'Ocorreu um erro:<br>');

/**
 * Declaraciones para la barra de navegación
 */
define('_AM_RMDP_CATEGOS', 'Categorias:');
define('_AM_RMDP_DOWNLOADS', 'Downloads');
define('_AM_RMDP_CARACTS', 'Características');
define('_AM_RMDP_DSPONSOR', 'Patrocinado');
define('_AM_RMDP_OS', 'Plataformas');
define('_AM_RMDP_OPTIONS', 'Opções');
define('_AM_RMDP_SLICS', 'Licenças');
define('_AM_RMDP_SNSENDED', 'Recebidos');
define('_AM_RMDP_SMODIFIED', 'Modificações');
define('_AM_RMDP_GOPAGE', 'Página: ');
define('_AM_RMDP_HELP', 'Ajuda');

// NUEVO EN VERSION 1.3
define('_AM_RMDP_ACTUAL', '<span style="font-size: 10px;">Atual: <strong>%s</strong></span>');
define('_AM_RMDP_ERRMOVEFILE', 'Ocorreu um erro enquanto você tentava fazer upload do arquivo. Por favor verifique as permissões do diretório "%s".');

if ('indice' == $location) {
    define('_AM_RMDP_ACTUALSTATUS', 'Status atual');

    define('_AM_RMDP_CATEGOS', 'Categorias:');

    define('_AM_RMDP_SEE', 'Ver');

    define('_AM_RMDP_DOWNS', 'Número de Downloads:');

    define('_AM_RMDP_SPONSOR', 'Downloads patrocinados:');

    define('_AM_RMDP_CARS', 'Características:');

    define('_AM_RMDP_LICS', 'Número de Licenças:');

    define('_AM_RMDP_OSNUM', 'Número de Plataformas:');

    define('_AM_RMDP_DSEND', 'Downloads Recebidos:');

    define('_AM_RMDP_NSHOTS', 'Screenshots:');
} elseif ('categorias' == $location) {
    define('_AM_RMDP_FNAME', 'Nome:');

    define('_AM_RMDP_FACCESS', 'Acesso:');

    define('_AM_RMDP_REGISTERED', 'Somente visitantes cadastrados');

    define('_AM_RMDP_EVERYBODY', 'Todos');

    define('_AM_RMDP_FPARENT', 'Categoria Principal:');

    define('_AM_RMDP_FIMG', 'Imagem:');

    define('_AM_RMDP_FIMGURL', 'Imagem (URL):');

    define('_AM_RMDP_SELECT', 'Selecionar...');

    define('_AM_RMDP_ERRNAME', 'Você não especificou um nome do download');

    define('_AM_RMDP_ERREXIST', 'Já existe um download com o mesmo nome');

    define('_AM_RMDP_ERRNOEXIST', 'Não existe o download especificado');

    define('_AM_RMDP_CATEGOOK', 'Categoria criada com sucesso');

    define('_AM_RMDP_CATEGOMODOK', 'Categoria modificada com sucesso');

    define('_AM_RMDP_CATEGOLIST', 'Lista de Categorias');

    define('_AM_RMDP_LNAME', 'Nome');

    define('_AM_RMDP_LACCESS', 'Acessos');

    define('_AM_RMDP_MODCATEGO', 'Editar Categoria');

    define('_AM_RMDP_DELOK', 'Elemento eliminado corretamente');

    define('_AM_RMDP_CONFIRM', 'Você realmente deseja eliminar este download patrocinado?');

    define('_AM_RMDP_DOWNSLIST', 'Lista de Downloads');

    define('_AM_RMDP_SOFTCARS', 'Características');

    define('_AM_RMDP_SOFTOS', 'Plataformas');

    define('_AM_RMDP_SOFTSHOTS', 'Screenshots');

    define('_AM_RMDP_NEWDOWN', 'Novos Downloads');

    define('_AM_RMDP_SHOWNEWS', 'Mostrar Novos no topo da página do módulo:');
} elseif ('descargas' == $location) {
    // SIN CAMBIO //

    define('_AM_RMDP_DOWNSLIST', 'Lista de Downloads');

    define('_AM_RMDP_SOFTCARS', 'Características');

    define('_AM_RMDP_SOFTOS', 'Plataformas');

    define('_AM_RMDP_SOFTSHOTS', 'Screenshots');

    define('_AM_RMDP_NEWDOWN', 'Novos Downloads');

    define('_AM_RMDP_MODDOWN', 'Editar Download');

    define('_AM_RMDP_FNAME', 'Nome:');

    define('_AM_RMDP_SENDBY', 'Enviado por:');

    define('_AM_RMDP_FVERSION', 'Versão:');

    define('_AM_RMDP_FLICENSE', 'Licença:');

    define('_AM_RMDP_FFILE', 'Arquivo:');

    define('_AM_RMDP_RATING', 'Avaliação:');

    define('_AM_RMDP_FIMG', 'Imagem:');

    define('_AM_RMDP_FCATEGO', 'Categoria:');

    define('_AM_RMDP_SELECT', 'Selecionar...');

    define('_AM_RMDP_FLONG', 'Descrição:');

    define('_AM_RMDP_FSIZE', 'Tamanho (em bytes):');

    define('_AM_RMDP_FFAVS', 'Adicionar a Favoritos:');

    define('_AM_RMDP_FALLOWANONIM', 'Permitir downloads anônimos:');

    define('_AM_RMDP_FSECURE', 'Este arquivo se baixa de modo seguro:');

    define('_AM_RMDP_FSECURE_DESC', 'Ao ativar esta opção os visitantes não poderão conhecer a condição física do arquivo.');

    define('_AM_RMDP_FRESALTE', 'Ressaltar:');

    define('_AM_RMDP_FURLTITLE', 'Título do Site do Autor:');

    define('_AM_RMDP_FURL', 'URL do Autor:');

    // NEW IN VERSION 1.3 //

    define('_AM_RMDP_MIRRORS_TITLE', 'Mirrors (opcionais)');

    define('_AM_RMDP_FFILEURL', 'Arquivo (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'Não é necessário indicar o campo "Arquivo"');

    define('_AM_RMDP_FIMGURL', 'Imagem (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'Não é necsessário indicar o campo "Imagem"');

    define('_AM_RMDP_FSIZE_DESC', 'Se foi indicado um arquivo local, será calculado automaticamente.');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Título %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'URL do Arquivo %s:');

    define('_AM_RMDP_ERRSIZE', 'O tamanho do arquivo excede ao tamanho permitido');

    define('_AM_RMDP_MAXSIZE', 'Tamanho máximo: <strong>%s</strong>');

    define('_AM_RMDP_OSS', 'Plataformas:');

    // SIN CAMBIOS //

    define('_AM_RMDP_ERRNAME', 'Você não especificou um nome do download');

    define('_AM_RMDP_ERRNAMECAR', 'Está faltando o nome da característica');

    define('_AM_RMDP_ERRVERSION', 'Por favor indique a versão do arquivo');

    define('_AM_RMDP_ERRVFILE', 'Indica o arquivo para download');

    define('_AM_RMDP_ERRCATEGO', 'Seleciona uma categoría para este download');

    define('_AM_RMDP_ERRDESC', 'Por favor escreva uma breve descrição para este download');

    define('_AM_RMDP_ERREXIST', 'Já existe um download com o mesmo nome');

    define('_AM_RMDP_ERRCAREXIST', 'Uma característica com o mesmo nome já existe');

    define('_AM_RMDP_DOWNOK', 'Download criado com sucesso');

    define('_AM_RMDP_CAROK', 'característica criada com sucesso');

    define('_AM_RMDP_CARMODOK', 'Característica modificada corretamente');

    define('_AM_RMDP_DOWNMODOK', 'Download modificado corretacmente');

    define('_AM_RMDP_ERRNOEXIST', 'Não existe o download especificado');

    define('_AM_RMDP_ERRCARNOEXIST', 'Não existe a característica especificada');

    define('_AM_RMDP_CONFIRM', 'Você realmente deseja eliminar este download patrocinado?');

    define('_AM_RMDP_CONFIRMCAR', 'Você realmente deseja eliminar esta característica?');

    define('_AM_RMDP_DELOK', 'Elemento eliminado corretamente');

    define('_AM_RMDP_DELCAROK', 'Característica eliminada corretamente');

    define('_AM_RMDP_ALLCARS', 'Todas as características');

    define('_AM_RMDP_ASSIGNEDCARS', 'Características assinadas como "%s"');

    define('_AM_RMDP_ADD', 'Assinar');

    define('_AM_RMDP_NEWCAR', 'Nova Característica');

    define('_AM_RMDP_MODCAR', 'Modificar Característica');

    define('_AM_RMDP_CARINFO', 'As imagens devem estar localizadas em "modules/rmdp/images/caracts"');

    define('_AM_RMDP_OSALL', 'Plataformas Existentes');

    define('_AM_RMDP_OSASSIGN', 'Plataformas Assinadas');

    define('_AM_RMDP_OSEXIST', 'Esta Plataforma já foi assinada previamente');

    define('_AM_RMDP_LISTNAME', 'Nome');

    define('_AM_RMDP_LISTACCESS', 'Acesso');

    define('_AM_RMDP_REGISTERED', 'Somente visitantes cadastrados');

    define('_AM_RMDP_EVERYBODY', 'Todos');

    // Sección para las capturas de pantalla

    define('_AM_RMDP_SHOTLIST', 'Screenshots existentes para "%s"');

    define('_AM_RMDP_SHOTNEW', 'Novo screenshot');

    define('_AM_RMDP_SHOTMOD', 'Modificar screenshot');

    define('_AM_RMDP_SHOTDOWN', 'Download:');

    define('_AM_RMDP_SHOTSMALL', 'Imagem pequena:');

    define('_AM_RMDP_SHOTBIG', 'Imagem Grande:');

    define('_AM_RMDP_SHOT', 'Imagem:');

    define('_AM_RMDP_SHOTDESC', 'Descrição;n:');

    define('_AM_RMDP_SHOTERRSB', 'Erro: Especifique a imagem pequena ou imagem grande');

    define('_AM_RMDP_SHOTNOEXIST', 'Não existe o screenshot especificado');

    define('_AM_RMDP_SHOTCONFIRM', 'Você realmente quer eliminar este screenshot?');

    define('_AM_RMDP_SHOTDEL', 'Screenshot eliminado corretamente');

    // Sección de Reviews

    define('_AM_RMDP_REVIEWTITLE', 'Comentário do Editor');

    define('_AM_RMDP_REVIEW', 'Comentário:');

    define('_AM_RMDP_REVIEWOK', 'Seu comentário foi adicionado corretamente');
} elseif ('licencias' == $location) {
    define('_AM_RMDP_LICEXISTS', 'Licenças Existentes');

    define('_AM_RMDP_NEWLIC', 'Nova Licença');

    define('_AM_RMDP_MODLIC', 'Modificar Licença');

    define('_AM_RMDP_FNAME', 'Nome:');

    define('_AM_RMDP_FURL', 'URL do Autor:');

    define('_AM_RMDP_ERRNAME', 'Você não especificou um nome do download');

    define('_AM_RMDP_ERREXIST', 'Já existe um download com o mesmo nome');

    define('_AM_RMDP_LICOK', 'Licença criada corretamente');

    define('_AM_RMDP_LICMODOK', 'Licencia modificada correctamente');

    define('_AM_RMDP_ERRNOEXIST', 'Não existe o download especificado');

    define('_AM_RMDP_DELOK', 'Elemento eliminado corretamente');

    define('_AM_RMDP_CONFIRM', 'Você realmente deseja eliminar este download patrocinado?');
} elseif ('plataformas' == $location) {
    define('_AM_RMDP_OSEXISTS', 'Plataformas Existentes');

    define('_AM_RMDP_NEWOS', 'Nova Plataforma');

    define('_AM_RMDP_FNAME', 'Nome:');

    define('_AM_RMDP_FIMG', 'Imagem:');

    define('_AM_RMDP_ERRNAME', 'Você não especificou um nome do download');

    define('_AM_RMDP_ERREXIST', 'Já existe um download com o mesmo nome');

    define('_AM_RMDP_OSOK', 'Plataforma criada corretamente');

    define('_AM_RMDP_CONFIRM', 'Você realmente deseja eliminar este download patrocinado?');

    define('_AM_RMDP_DELOK', 'Elemento eliminado corretamente');
} elseif ('sponsor' == $location) {
    define('_AM_RMDP_SPONSORLIST', 'Lista de Downloads Patrocinados');

    define('_AM_RMDP_SNAME', 'Nome');

    define('_AM_RMDP_SOPTIONS', 'Opções');

    define('_AM_RMDP_NEWSPONSOR', 'Novo Download Patrocinado');

    define('_AM_RMDP_FDOWN', 'Selecionar Download:');

    define('_AM_RMDP_FTEXT', 'Texto:');

    define('_AM_RMDP_ERRDOWN', 'Erro: Você não especificou um download');

    define('_AM_RMDP_ERRTEXT', 'Erro: Você não especificou o texto para este download patrocinado');

    define('_AM_RMDPO_SPONNOEXIST', 'Nao existe o download especificado');

    define('_AM_RMDP_CONFIRM', 'Você realmente deseja eliminar este download patrocinado?');
} elseif ('sended' == $location) {
    define('_RMDP_SENDED_TITLE', 'Downloads Enviados por visitantes');

    define('_RMDP_NAME', 'Nome');

    define('_RMDP_SENDBY', 'Enviou');

    define('_RMDP_DATE', 'Data');

    define('_AM_RMDP_ERRNOEXIST', 'Não existe o download especificado');

    define('_AM_RMDP_FNAME', 'Nome:');

    define('_AM_RMDP_SENDBY', 'Enviado por:');

    define('_AM_RMDP_FVERSION', 'Versão:');

    define('_AM_RMDP_FLICENSE', 'Licença:');

    define('_AM_RMDP_FFILE', 'Arquivo:');

    define('_AM_RMDP_RATING', 'Avaliação:');

    define('_AM_RMDP_FIMG', 'Imagem:');

    define('_AM_RMDP_FCATEGO', 'Categoria:');

    define('_AM_RMDP_SELECT', 'Selecionar...');

    define('_AM_RMDP_FLONG', 'Descrição:');

    define('_AM_RMDP_FSIZE', 'Tamanho (em bytes):');

    define('_AM_RMDP_FFAVS', 'Adicionar a Favoritos:');

    define('_AM_RMDP_FALLOWANONIM', 'Permitir downloads anônimos:');

    define('_AM_RMDP_FRESALTE', 'Ressaltar:');

    define('_AM_RMDP_FURLTITLE', 'Título do Site do Autor:');

    define('_AM_RMDP_FURL', 'URL do Autor:');

    define('_AM_RMDP_SAVE', 'Salvar');

    define('_AM_RMDP_ACEPT', 'Aceitar Download');

    define('_AM_RMDP_ERRNAME', 'Você não especificou um nome do download');

    define('_AM_RMDP_ERREXIST', 'Já existe um download com o mesmo nome');

    define('_AM_RMDP_ERRVERSION', 'Por favor indique a versão do arquivo');

    define('_AM_RMDP_ERRVFILE', 'Indica o arquivo para download');

    define('_AM_RMDP_ERRCATEGO', 'Seleciona uma categoría para este download');

    define('_AM_RMDP_SENDOK', 'Download aceito corretamente');

    define('_RMDP_MAIL_SUBJECT', 'Seu download foi aceito');

    define('_AM_RMDP_OSS', 'Plataformas:');

    // Mensajes y redirecciones

    define('_AM_RMDP_DELCONFIRM', 'Você realmente deseja eliminar este elemento?');

    define('_AM_RMDP_DELOK', 'Elemento eliminado corretamente');

    // Nuevo en la version 1.3 //

    define('_AM_RMDP_FFILEURL', 'Arquivo (URL):');

    define('_AM_RMDP_FFILEURL_DESC', 'Não é necessário indicar o campo "Arquivo"');

    define('_AM_RMDP_FIMGURL', 'Imagem (URL):');

    define('_AM_RMDP_FIMGURL_DESC', 'Não é necsessário indicar o campo "Imagem"');

    define('_AM_RMDP_MAXSIZE', 'Tamanho máximo: <strong>%s</strong>');

    define('_AM_RMDP_ITEMMIR_TITLE', 'Título %s:');

    define('_AM_RMDP_ITEMMIR_URL', 'URL do Arquivo %s:');

    define('_AM_RMDP_FSIZE_DESC', 'Se foi indicado um arquivo local, será calculado automaticamente.');

    define('_AM_RMDP_MIRRORS_TITLE', 'Mirrors (opcionais)');
}
