-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_categos`
-- 

CREATE TABLE `rmdp_categos` (
    `id_cat`   INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre`   VARCHAR(200) NOT NULL DEFAULT '',
    `parent`   INT(11)      NOT NULL DEFAULT '0',
    `acceso`   SMALLINT(1)  NOT NULL DEFAULT '0',
    `img`      VARCHAR(200)          DEFAULT '',
    `imgtype`  TINYINT(1)   NOT NULL DEFAULT '0',
    `fecha`    VARCHAR(20)  NOT NULL DEFAULT '',
    `shownews` SMALLINT(1)  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_cat`)
)
    ENGINE = MyISAM COMMENT ='Categorias de Software';

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_data`
-- 

CREATE TABLE `rmdp_data` (
    `total_votos`     INT(11) NOT NULL DEFAULT '0',
    `total_descargas` INT(11) NOT NULL DEFAULT '0',
    `download_day`    INT(11) NOT NULL DEFAULT '0'
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_editorcom`
-- 

CREATE TABLE `rmdp_editorcom` (
    `id_ce`   INT(11)     NOT NULL AUTO_INCREMENT,
    `id_soft` INT(11)     NOT NULL DEFAULT '0',
    `text`    TEXT        NOT NULL,
    `fecha`   VARCHAR(20) NOT NULL DEFAULT '',
    PRIMARY KEY (`id_ce`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_licences`
-- 

CREATE TABLE `rmdp_licences` (
    `id_lic` INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL DEFAULT '',
    `url`    VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id_lic`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_mirrors`
-- 

CREATE TABLE `rmdp_mirrors` (
    `id_mir`  INT(11)      NOT NULL AUTO_INCREMENT,
    `id_soft` INT(11)      NOT NULL DEFAULT '0',
    `titulo`  VARCHAR(100) NOT NULL DEFAULT '',
    `url`     VARCHAR(255) NOT NULL DEFAULT '',
    `status`  TINYINT(1)   NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_mir`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_partners`
-- 

CREATE TABLE `rmdp_partners` (
    `id_par`  INT(11)      NOT NULL AUTO_INCREMENT,
    `id_soft` INT(11)      NOT NULL DEFAULT '0',
    `text`    VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id_par`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_plataformas`
-- 

CREATE TABLE `rmdp_plataformas` (
    `id_os`  INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(200) NOT NULL DEFAULT '',
    `img`    VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id_os`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_sended`
-- 

CREATE TABLE `rmdp_sended` (
    `id_soft`     INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre`      VARCHAR(200) NOT NULL DEFAULT '',
    `version`     VARCHAR(10)  NOT NULL DEFAULT '',
    `licencia`    SMALLINT(1)  NOT NULL DEFAULT '0',
    `archivo`     VARCHAR(255) NOT NULL DEFAULT '',
    `filetype`    TINYINT(4)   NOT NULL DEFAULT '0',
    `img`         VARCHAR(255) NOT NULL DEFAULT '',
    `imgtype`     TINYINT(1)   NOT NULL DEFAULT '0',
    `id_cat`      INT(11)      NOT NULL DEFAULT '0',
    `longdesc`    TEXT         NOT NULL,
    `size`        DOUBLE       NOT NULL DEFAULT '0',
    `anonimo`     SMALLINT(1)  NOT NULL DEFAULT '0',
    `fecha`       VARCHAR(20)  NOT NULL DEFAULT '0',
    `url`         VARCHAR(255) NOT NULL DEFAULT '',
    `urltitle`    VARCHAR(255) NOT NULL DEFAULT '',
    `submitter`   INT(11)      NOT NULL DEFAULT '0',
    `plataformas` VARCHAR(255) NOT NULL DEFAULT '',
    `modify`      TINYINT(1)   NOT NULL DEFAULT '0',
    `id_mod`      INT(11)      NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_soft`)
)
    ENGINE = MyISAM COMMENT ='Software para descargar desde el sitio';

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_shots`
-- 

CREATE TABLE `rmdp_shots` (
    `id_shot` INT(11)      NOT NULL AUTO_INCREMENT,
    `id_soft` INT(11)      NOT NULL DEFAULT '0',
    `small`   VARCHAR(255) NOT NULL DEFAULT '',
    `big`     VARCHAR(255) NOT NULL DEFAULT '',
    `text`    VARCHAR(255) NOT NULL DEFAULT '',
    `fecha`   VARCHAR(20)  NOT NULL DEFAULT '0',
    `hits`    INT(11)      NOT NULL DEFAULT '0',
    `type`    TINYINT(1)   NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_shot`)
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_softos`
-- 

CREATE TABLE `rmdp_softos` (
    `id_os`   INT(11) NOT NULL DEFAULT '0',
    `id_soft` INT(11) NOT NULL DEFAULT '0'
)
    ENGINE = MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_software`
-- 

CREATE TABLE `rmdp_software` (
    `id_soft`      INT(11)      NOT NULL AUTO_INCREMENT,
    `nombre`       VARCHAR(200) NOT NULL DEFAULT '',
    `version`      VARCHAR(10)  NOT NULL DEFAULT '',
    `licencia`     SMALLINT(1)  NOT NULL DEFAULT '0',
    `archivo`      VARCHAR(255) NOT NULL DEFAULT '',
    `filetype`     TINYINT(4)   NOT NULL DEFAULT '0',
    `img`          VARCHAR(255) NOT NULL DEFAULT '',
    `imgtype`      TINYINT(1)   NOT NULL DEFAULT '0',
    `id_cat`       INT(11)      NOT NULL DEFAULT '0',
    `longdesc`     TEXT         NOT NULL,
    `size`         DOUBLE       NOT NULL DEFAULT '0',
    `favorito`     SMALLINT(1)  NOT NULL DEFAULT '0',
    `descargas`    INT(11)      NOT NULL DEFAULT '0',
    `reviews`      INT(11)      NOT NULL DEFAULT '0',
    `votos`        INT(11)      NOT NULL DEFAULT '0',
    `rating`       BIGINT(20)   NOT NULL DEFAULT '0',
    `calificacion` INT(1)       NOT NULL DEFAULT '0',
    `anonimo`      SMALLINT(1)  NOT NULL DEFAULT '0',
    `resaltar`     SMALLINT(1)  NOT NULL DEFAULT '0',
    `fecha`        VARCHAR(20)  NOT NULL DEFAULT '0',
    `update`       VARCHAR(20)  NOT NULL DEFAULT '0',
    `url`          VARCHAR(255) NOT NULL DEFAULT '',
    `urltitle`     VARCHAR(255) NOT NULL DEFAULT '',
    `submitter`    INT(11)      NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_soft`)
)
    ENGINE = MyISAM COMMENT ='Software para descargar desde el sitio';

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmdp_votes`
-- 

CREATE TABLE `rmdp_votes` (
    `id_vote` INT(11)     NOT NULL AUTO_INCREMENT,
    `id_soft` INT(11)     NOT NULL DEFAULT '0',
    `uid`     INT(11)     NOT NULL DEFAULT '0',
    `user_ip` VARCHAR(30) NOT NULL DEFAULT '',
    `fecha`   VARCHAR(20) NOT NULL DEFAULT '',
    PRIMARY KEY (`id_vote`)
)
    ENGINE = MyISAM;
