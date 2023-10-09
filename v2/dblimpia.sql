#
# Estructura de tabla para la tabla `cw_comentarios`
#

CREATE TABLE `cw_comentarios` (
  `id_coment` int(11) NOT NULL auto_increment,
  `id_user` varchar(20) collate utf8_spanish_ci default NULL,
  `comentario` text collate utf8_spanish_ci,
  `id_post` varchar(20) collate utf8_spanish_ci default NULL,
  `fecha` text collate utf8_spanish_ci NOT NULL,
  `id_cat` varchar(20) collate utf8_spanish_ci NOT NULL default '0',
  PRIMARY KEY  (`id_coment`),
  FULLTEXT KEY `id_cat` (`id_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `cw_comentarios`
#


# ############################

#
# Estructura de tabla para la tabla `cw_denuncias`
#

CREATE TABLE `cw_denuncias` (
  `id_denuncia` int(10) unsigned NOT NULL auto_increment,
  `id_post` int(10) NOT NULL default '0',
  `id_user` int(10) NOT NULL default '0',
  `razon` text collate utf8_spanish_ci NOT NULL,
  `comentario` text collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_denuncia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='cw_denuncias' AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `cw_denuncias`
#


# ############################

#
# Estructura de tabla para la tabla `cw_puntos`
#

CREATE TABLE `cw_puntos` (
  `id` int(11) NOT NULL auto_increment,
  `id_post` varchar(30) collate utf8_spanish_ci default NULL,
  `id_member` text collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `cw_puntos`
#


# ############################

#
# Estructura de tabla para la tabla `smf_attachments`
#

CREATE TABLE `smf_attachments` (
  `ID_ATTACH` int(10) unsigned NOT NULL auto_increment,
  `ID_THUMB` int(10) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `attachmentType` tinyint(3) unsigned NOT NULL default '0',
  `filename` tinytext NOT NULL,
  `size` int(10) unsigned NOT NULL default '0',
  `downloads` mediumint(8) unsigned NOT NULL default '0',
  `width` mediumint(8) unsigned NOT NULL default '0',
  `height` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_ATTACH`),
  UNIQUE KEY `ID_MEMBER` (`ID_MEMBER`,`ID_ATTACH`),
  KEY `ID_MSG` (`ID_MSG`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_attachments`
#


# ############################

#
# Estructura de tabla para la tabla `smf_ban_groups`
#

CREATE TABLE `smf_ban_groups` (
  `ID_BAN_GROUP` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `ban_time` int(10) unsigned NOT NULL default '0',
  `expire_time` int(10) unsigned default NULL,
  `cannot_access` tinyint(3) unsigned NOT NULL default '0',
  `cannot_register` tinyint(3) unsigned NOT NULL default '0',
  `cannot_post` tinyint(3) unsigned NOT NULL default '0',
  `cannot_login` tinyint(3) unsigned NOT NULL default '0',
  `reason` tinytext NOT NULL,
  `notes` mediumtext NOT NULL,
  PRIMARY KEY  (`ID_BAN_GROUP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `smf_ban_groups`
#

INSERT INTO `smf_ban_groups` (`ID_BAN_GROUP`, `name`, `ban_time`, `expire_time`, `cannot_access`, `cannot_register`, `cannot_post`, `cannot_login`, `reason`, `notes`) VALUES
(1, 'gil', 1231224968, NULL, 1, 0, 0, 0, '', ''),
(2, 'elgallo_elmejor', 1231225019, NULL, 1, 0, 0, 0, '', '');

# ############################

#
# Estructura de tabla para la tabla `smf_ban_items`
#

CREATE TABLE `smf_ban_items` (
  `ID_BAN` mediumint(8) unsigned NOT NULL auto_increment,
  `ID_BAN_GROUP` smallint(5) unsigned NOT NULL default '0',
  `ip_low1` tinyint(3) unsigned NOT NULL default '0',
  `ip_high1` tinyint(3) unsigned NOT NULL default '0',
  `ip_low2` tinyint(3) unsigned NOT NULL default '0',
  `ip_high2` tinyint(3) unsigned NOT NULL default '0',
  `ip_low3` tinyint(3) unsigned NOT NULL default '0',
  `ip_high3` tinyint(3) unsigned NOT NULL default '0',
  `ip_low4` tinyint(3) unsigned NOT NULL default '0',
  `ip_high4` tinyint(3) unsigned NOT NULL default '0',
  `hostname` tinytext NOT NULL,
  `email_address` tinytext NOT NULL,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `hits` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_BAN`),
  KEY `ID_BAN_GROUP` (`ID_BAN_GROUP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

#
# Volcar la base de datos para la tabla `smf_ban_items`
#

INSERT INTO `smf_ban_items` (`ID_BAN`, `ID_BAN_GROUP`, `ip_low1`, `ip_high1`, `ip_low2`, `ip_high2`, `ip_low3`, `ip_high3`, `ip_low4`, `ip_high4`, `hostname`, `email_address`, `ID_MEMBER`, `hits`) VALUES
(1, 1, 190, 190, 51, 51, 182, 182, 108, 108, '', '', 0, 3),
(2, 1, 0, 0, 0, 0, 0, 0, 0, 0, '190-51-182-108.speedy.com.ar', '', 0, 3),
(3, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'asas4x5as4@cas.com', 0, 0),
(4, 2, 190, 190, 11, 11, 32, 32, 188, 188, '', '', 0, 0),
(5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 'ip-190-011-032-188.coopvgg.com.ar', '', 0, 0),
(6, 2, 0, 0, 0, 0, 0, 0, 0, 0, '', 'asdasdff@hotmail.com', 0, 0),
(7, 2, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 61, 0);

# ############################

#
# Estructura de tabla para la tabla `smf_boards`
#

CREATE TABLE `smf_boards` (
  `ID_BOARD` smallint(5) unsigned NOT NULL auto_increment,
  `ID_CAT` tinyint(4) unsigned NOT NULL default '0',
  `childLevel` tinyint(4) unsigned NOT NULL default '0',
  `ID_PARENT` smallint(5) unsigned NOT NULL default '0',
  `boardOrder` smallint(5) NOT NULL default '0',
  `ID_LAST_MSG` int(10) unsigned NOT NULL default '0',
  `ID_MSG_UPDATED` int(10) unsigned NOT NULL default '0',
  `memberGroups` varchar(255) NOT NULL default '-1,0',
  `name` tinytext NOT NULL,
  `description` mediumtext NOT NULL,
  `numTopics` mediumint(8) unsigned NOT NULL default '0',
  `numPosts` mediumint(8) unsigned NOT NULL default '0',
  `countPosts` tinyint(4) NOT NULL default '0',
  `ID_THEME` tinyint(4) unsigned NOT NULL default '0',
  `permission_mode` tinyint(4) unsigned NOT NULL default '0',
  `override_theme` tinyint(4) unsigned NOT NULL default '0',
  `countMoney` tinyint(1) unsigned NOT NULL default '1',
  `thank_you_post_enable` tinyint(4) unsigned NOT NULL default '1',
  PRIMARY KEY  (`ID_BOARD`),
  UNIQUE KEY `categories` (`ID_CAT`,`ID_BOARD`),
  KEY `ID_PARENT` (`ID_PARENT`),
  KEY `ID_MSG_UPDATED` (`ID_MSG_UPDATED`),
  KEY `memberGroups` (`memberGroups`(48))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

#
# Volcar la base de datos para la tabla `smf_boards`
#

INSERT INTO `smf_boards` (`ID_BOARD`, `ID_CAT`, `childLevel`, `ID_PARENT`, `boardOrder`, `ID_LAST_MSG`, `ID_MSG_UPDATED`, `memberGroups`, `name`, `description`, `numTopics`, `numPosts`, `countPosts`, `ID_THEME`, `permission_mode`, `override_theme`, `countMoney`, `thank_you_post_enable`) VALUES
(107, 1, 0, 0, 1, 19435, 19435, '-1,0,2,4,5,6,7', 'Animaciones', '', 0, 0, 0, 0, 0, 0, 1, 0),
(42, 1, 0, 0, 2, 114, 19841, '-1,0,2,4,5,6,7,7', 'Anime / Manga / Otros', '', 0, 0, 0, 0, 0, 0, 1, 0),
(14, 1, 0, 0, 3, 124, 19797, '-1,0,2,4,5,6,7,9,7', 'Cine y TV', '', 0, 0, 0, 0, 0, 0, 1, 0),
(76, 1, 0, 0, 4, 19296, 19296, '-1,0,2,4,5,6,7,9,10,7', 'Comic''s', '', 0, 0, 0, 0, 0, 0, 1, 0),
(48, 1, 0, 0, 5, 0, 0, '-1,0,2,4,5,6,7,9,10,11,7', 'Comunidad casera', '', 0, 0, 0, 0, 0, 0, 1, 0),
(25, 1, 0, 0, 6, 144, 19844, '-1,0,2,4,5,6,7,9,10,11,12,7', 'Descargas', '', 0, 0, 0, 0, 0, 0, 1, 0),
(66, 1, 0, 0, 7, 19793, 19793, '-1,0,2,13,4,5,6,7,9,10,11,12,7', 'Enlaces', '', 0, 0, 0, 0, 0, 0, 1, 0),
(94, 1, 0, 0, 8, 19408, 19408, '-1,0,2,13,4,5,6,7,9,10,11,12,7', 'Emule / Torrents', '', 0, 0, 0, 0, 0, 0, 1, 0),
(46, 1, 0, 0, 9, 19827, 19827, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Humor', '', 0, 0, 0, 0, 0, 0, 1, 0),
(109, 1, 0, 0, 10, 19840, 19840, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Imágenes', '', 0, 0, 0, 0, 0, 0, 1, 0),
(11, 1, 0, 0, 11, 136, 0, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Juegos', '', 0, 0, 0, 0, 0, 0, 1, 0),
(108, 1, 0, 0, 12, 19805, 19805, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Libros', '', 0, 0, 0, 0, 0, 0, 1, 0),
(23, 1, 0, 0, 13, 83, 83, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Linux', '', 0, 0, 0, 0, 0, 0, 1, 0),
(4, 1, 0, 0, 14, 193, 193, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Música', '', 0, 0, 0, 0, 0, 0, 1, 0),
(34, 1, 0, 0, 15, 165, 165, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Noticias', '', 0, 0, 0, 0, 0, 0, 1, 0),
(49, 1, 0, 0, 16, 0, 0, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Off-topic', '', 0, 0, 0, 0, 0, 0, 1, 0),
(45, 1, 0, 0, 17, 19673, 19673, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Peticiones / Soporte', '', 0, 0, 0, 0, 0, 0, 1, 0),
(96, 1, 0, 0, 18, 126, 19807, '-1,0,2,7,4,5,6', 'Psp', '', 0, 0, 0, 0, 0, 0, 1, 0),
(58, 1, 0, 0, 19, 19830, 19830, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Tips y Trucos', '', 0, 0, 0, 0, 0, 0, 1, 0),
(74, 1, 0, 0, 20, 19581, 19581, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Tutoriales / Ayuda', '', 0, 0, 0, 0, 0, 0, 1, 0),
(95, 1, 0, 0, 21, 140, 19800, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Videos On-line', '', 0, 0, 0, 0, 0, 0, 1, 0),
(22, 1, 0, 0, 22, 20, 19828, '-1,0,2,13,4,5,6,7,8,9,10,11,12,7,8,8', 'Windows', '', 0, 0, 0, 0, 0, 0, 1, 0);

# ############################

#
# 
# Estructura de tabla para la tabla `smf_log_polls`
#

CREATE TABLE smf_log_polls (
  ID_POLL mediumint(8) unsigned NOT NULL default '0',
  ID_MEMBER mediumint(8) unsigned NOT NULL default '0',
  ID_CHOICE tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY (ID_POLL, ID_MEMBER, ID_CHOICE)
) TYPE=MyISAM;


# ############################


#
# Estructura de tabla para la tabla `smf_board_permissions`
#

CREATE TABLE `smf_board_permissions` (
  `ID_GROUP` smallint(5) NOT NULL default '0',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `permission` varchar(30) NOT NULL default '',
  `addDeny` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`ID_GROUP`,`ID_BOARD`,`permission`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_board_permissions`
#

INSERT INTO `smf_board_permissions` (`ID_GROUP`, `ID_BOARD`, `permission`, `addDeny`) VALUES
(3, 0, 'thank_you_post_post', 1),
(3, 0, 'mark_notify', 1),
(3, 0, 'mark_any_notify', 1),
(3, 0, 'poll_remove_own', 1),
(0, 0, 'move_own', 1),
(3, 0, 'poll_edit_own', 1),
(3, 0, 'poll_add_own', 1),
(3, 0, 'poll_post', 1),
(2, 0, 'thank_you_post_unlock_all', 1),
(3, 0, 'poll_vote', 1),
(3, 0, 'poll_view', 1),
(3, 0, 'report_any', 1),
(3, 0, 'modify_any', 1),
(3, 0, 'delete_any', 1),
(3, 0, 'post_reply_any', 1),
(-1, 0, 'thank_you_post_show', 1),
(3, 0, 'post_reply_own', 1),
(3, 0, 'remove_any', 1),
(3, 0, 'lock_any', 1),
(3, 0, 'lock_own', 1),
(3, 0, 'move_any', 1),
(3, 0, 'make_sticky', 1),
(3, 0, 'send_topic', 1),
(3, 0, 'split_any', 1),
(3, 0, 'merge_any', 1),
(3, 0, 'post_new', 1),
(3, 0, 'moderate_board', 1),
(0, 0, 'post_new', 1),
(2, 0, 'thank_you_post_lock_all_own', 1),
(3, 0, 'thank_you_post_show', 1),
(3, 0, 'thank_you_post_delete_own', 1),
(3, 0, 'thank_you_post_lock_own', 1),
(3, 0, 'thank_you_post_lock_all_own', 1),
(3, 0, 'thank_you_post_delete_mem_own', 1),
(2, 0, 'thank_you_post_lock_own', 1),
(2, 0, 'thank_you_post_delete_own', 1),
(2, 0, 'thank_you_post_show', 1),
(2, 0, 'report_any', 1),
(-1, 0, 'send_topic', 1),
(0, 0, 'modify_own', 1),
(2, 0, 'thank_you_post_post', 1),
(3, 0, 'hide_post_own', 1),
(3, 0, 'hide_post_any', 1),
(3, 0, 'view_hidden_msg', 1),
(2, 0, 'view_hidden_msg', 1),
(3, 0, 'view_hidden_post', 1),
(0, 0, 'view_hidden_msg', 1),
(0, 0, 'delete_replies', 1),
(2, 0, 'view_hidden_post', 1),
(2, 0, 'hide_post_any', 1),
(0, 0, 'hide_post_own', 1),
(0, 0, 'report_any', 1),
(0, 0, 'hide_post_any', 1),
(0, 0, 'send_topic', 1),
(0, 0, 'lock_own', 1),
(0, 0, 'remove_own', 1),
(0, 0, 'post_reply_any', 1),
(2, 0, 'hide_post_own', 1),
(2, 0, 'modify_any', 1),
(2, 0, 'modify_own', 1),
(2, 0, 'delete_any', 1),
(2, 0, 'delete_own', 1),
(7, 0, 'delete_replies', 1),
(7, 0, 'hide_post_any', 1),
(7, 0, 'hide_post_own', 1),
(7, 0, 'lock_own', 1),
(7, 0, 'modify_own', 1),
(7, 0, 'move_own', 1),
(7, 0, 'post_new', 1),
(7, 0, 'post_reply_any', 1),
(7, 0, 'remove_own', 1),
(7, 0, 'report_any', 1),
(7, 0, 'send_topic', 1),
(7, 0, 'thank_you_post_delete_mem_any', 1),
(7, 0, 'thank_you_post_delete_own', 1),
(7, 0, 'thank_you_post_lock_all_own', 1),
(7, 0, 'thank_you_post_lock_own', 1),
(7, 0, 'thank_you_post_post', 1),
(7, 0, 'thank_you_post_show', 1),
(7, 0, 'view_hidden_msg', 1),
(0, 0, 'thank_you_post_post', 1),
(0, 0, 'thank_you_post_show', 1),
(0, 0, 'thank_you_post_delete_own', 1),
(0, 0, 'thank_you_post_lock_own', 1),
(0, 0, 'thank_you_post_lock_all_own', 1),
(0, 0, 'thank_you_post_delete_mem_any', 1),
(2, 0, 'delete_replies', 1),
(2, 0, 'post_reply_any', 1),
(2, 0, 'remove_any', 1),
(2, 0, 'lock_any', 1),
(2, 0, 'move_any', 1),
(2, 0, 'make_sticky', 1),
(2, 0, 'send_topic', 1),
(2, 0, 'post_new', 1),
(2, 0, 'moderate_board', 1),
(2, 0, 'thank_you_post_delete_mem_own', 1),
(2, 0, 'thank_you_post_delete_mem_any', 1);

# ############################

#
# Estructura de tabla para la tabla `smf_bookmarks`
#

CREATE TABLE `smf_bookmarks` (
  `id` int(11) NOT NULL auto_increment,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ID_MEMBER` (`ID_MEMBER`,`ID_TOPIC`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `smf_bookmarks`
#

INSERT INTO `smf_bookmarks` (`id`, `ID_MEMBER`, `ID_TOPIC`) VALUES
(1, 21, 125);

# ############################

#
# Estructura de tabla para la tabla `smf_calendar`
#

CREATE TABLE `smf_calendar` (
  `ID_EVENT` smallint(5) unsigned NOT NULL auto_increment,
  `startDate` date NOT NULL default '0001-01-01',
  `endDate` date NOT NULL default '0001-01-01',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(48) NOT NULL default '',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_EVENT`),
  KEY `startDate` (`startDate`),
  KEY `endDate` (`endDate`),
  KEY `topic` (`ID_TOPIC`,`ID_MEMBER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_calendar`
#


# ############################

#
# Estructura de tabla para la tabla `smf_calendar_holidays`
#

CREATE TABLE `smf_calendar_holidays` (
  `ID_HOLIDAY` smallint(5) unsigned NOT NULL auto_increment,
  `eventDate` date NOT NULL default '0001-01-01',
  `title` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`ID_HOLIDAY`),
  KEY `eventDate` (`eventDate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_calendar_holidays`
#


# ############################

#
# Estructura de tabla para la tabla `smf_categories`
#

CREATE TABLE `smf_categories` (
  `ID_CAT` tinyint(4) unsigned NOT NULL auto_increment,
  `catOrder` tinyint(4) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `canCollapse` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ID_CAT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `smf_categories`
#

INSERT INTO `smf_categories` (`ID_CAT`, `catOrder`, `name`, `canCollapse`) VALUES
(1, 0, 'Categorias', 0);

# ############################

#
# Estructura de tabla para la tabla `smf_collapsed_categories`
#

CREATE TABLE `smf_collapsed_categories` (
  `ID_CAT` tinyint(4) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_CAT`,`ID_MEMBER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_collapsed_categories`
#


# ############################

#
# Estructura de tabla para la tabla `smf_gallery_cat`
#

CREATE TABLE `smf_gallery_cat` (
  `ID_CAT` mediumint(8) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `roworder` mediumint(8) unsigned NOT NULL default '0',
  `image` varchar(255) NOT NULL,
  `id_img` int(10) NOT NULL default '0',
  `id_user` int(10) NOT NULL default '0',
  PRIMARY KEY  (`ID_CAT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_gallery_cat`
#


# ############################

#
# Estructura de tabla para la tabla `smf_gallery_comment`
#

CREATE TABLE `smf_gallery_comment` (
  `ID_COMMENT` int(11) NOT NULL auto_increment,
  `ID_PICTURE` int(11) NOT NULL,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `approved` tinyint(4) NOT NULL default '0',
  `comment` mediumtext,
  `date` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_COMMENT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_gallery_comment`
#


# ############################

#
# Estructura de tabla para la tabla `smf_gallery_pic`
#

CREATE TABLE `smf_gallery_pic` (
  `ID_PICTURE` int(11) NOT NULL auto_increment,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `date` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` mediumtext,
  `views` int(10) NOT NULL default '0',
  `filesize` int(10) NOT NULL default '0',
  `height` int(10) NOT NULL default '0',
  `width` int(10) NOT NULL default '0',
  `filename` tinytext,
  `commenttotal` int(10) NOT NULL default '0',
  `ID_CAT` int(10) NOT NULL default '0',
  `allowcomments` tinyint(4) NOT NULL default '0',
  `keywords` varchar(100) default NULL,
  `puntos` int(10) NOT NULL default '0',
  PRIMARY KEY  (`ID_PICTURE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_gallery_pic`
#


# ############################

#
# Estructura de tabla para la tabla `smf_gallery_report`
#

CREATE TABLE `smf_gallery_report` (
  `ID` int(11) NOT NULL auto_increment,
  `ID_PICTURE` int(11) NOT NULL,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `comment` mediumtext,
  `date` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_gallery_report`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_actions`
#

CREATE TABLE `smf_log_actions` (
  `ID_ACTION` int(10) unsigned NOT NULL auto_increment,
  `logTime` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(16) NOT NULL default '',
  `action` varchar(30) NOT NULL default '',
  `extra` mediumtext NOT NULL,
  PRIMARY KEY  (`ID_ACTION`),
  KEY `logTime` (`logTime`),
  KEY `ID_MEMBER` (`ID_MEMBER`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `smf_log_actions`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_activity`
#

CREATE TABLE `smf_log_activity` (
  `date` date NOT NULL default '0001-01-01',
  `hits` mediumint(8) unsigned NOT NULL default '0',
  `topics` smallint(5) unsigned NOT NULL default '0',
  `posts` smallint(5) unsigned NOT NULL default '0',
  `registers` smallint(5) unsigned NOT NULL default '0',
  `mostOn` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`date`),
  KEY `hits` (`hits`),
  KEY `mostOn` (`mostOn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_activity`
#

INSERT INTO `smf_log_activity` (`date`, `hits`, `topics`, `posts`, `registers`, `mostOn`) VALUES
('2009-03-18', 50, 0, 0, 1, 0);

# ############################

#
# Estructura de tabla para la tabla `smf_log_banned`
#

CREATE TABLE `smf_log_banned` (
  `ID_BAN_LOG` mediumint(8) unsigned NOT NULL auto_increment,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(16) NOT NULL default '',
  `email` tinytext NOT NULL,
  `logTime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_BAN_LOG`),
  KEY `logTime` (`logTime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `smf_log_banned`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_boards`
#

CREATE TABLE `smf_log_boards` (
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_MEMBER`,`ID_BOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_boards`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_errors`
#

CREATE TABLE `smf_log_errors` (
  `ID_ERROR` mediumint(8) unsigned NOT NULL auto_increment,
  `logTime` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(16) NOT NULL default '',
  `url` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `session` char(32) NOT NULL default '',
  PRIMARY KEY  (`ID_ERROR`),
  KEY `logTime` (`logTime`),
  KEY `ID_MEMBER` (`ID_MEMBER`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_log_errors`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_floodcontrol`
#

CREATE TABLE `smf_log_floodcontrol` (
  `ip` char(16) NOT NULL default '',
  `logTime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_floodcontrol`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_karma`
#

CREATE TABLE `smf_log_karma` (
  `ID_TARGET` mediumint(8) unsigned NOT NULL default '0',
  `ID_EXECUTOR` mediumint(8) unsigned NOT NULL default '0',
  `logTime` int(10) unsigned NOT NULL default '0',
  `action` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID_TARGET`,`ID_EXECUTOR`),
  KEY `logTime` (`logTime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_karma`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_mark_read`
#

CREATE TABLE `smf_log_mark_read` (
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_MEMBER`,`ID_BOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_mark_read`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_notify`
#

CREATE TABLE `smf_log_notify` (
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `sent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_MEMBER`,`ID_TOPIC`,`ID_BOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_notify`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_online`
#

CREATE TABLE `smf_log_online` (
  `session` varchar(32) NOT NULL default '',
  `logTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ip` int(10) unsigned NOT NULL default '0',
  `url` mediumtext NOT NULL,
  PRIMARY KEY  (`session`),
  KEY `logTime` (`logTime`),
  KEY `ID_MEMBER` (`ID_MEMBER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_online`
#

INSERT INTO `smf_log_online` (`session`, `logTime`, `ID_MEMBER`, `ip`, `url`) VALUES
('32178e3401e610dbfb1863c635ba605b', '2009-03-18 14:40:59', 1, 3199313812, 'a:4:{s:6:"action";s:2:"pm";s:1:"f";s:5:"inbox";s:5:"start";s:1:"0";s:10:"USER_AGENT";s:126:"Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.4 MEGAUPLOAD 2.0 (.NET CLR 3.5.30729)";}');

# ############################

#
# Estructura de tabla para la tabla `smf_log_search_messages`
#

CREATE TABLE `smf_log_search_messages` (
  `ID_SEARCH` tinyint(3) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_SEARCH`,`ID_MSG`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_search_messages`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_search_results`
#

CREATE TABLE `smf_log_search_results` (
  `ID_SEARCH` tinyint(3) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  `relevance` smallint(5) unsigned NOT NULL default '0',
  `num_matches` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_SEARCH`,`ID_TOPIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_search_results`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_search_subjects`
#

CREATE TABLE `smf_log_search_subjects` (
  `word` varchar(20) NOT NULL default '',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word`,`ID_TOPIC`),
  KEY `ID_TOPIC` (`ID_TOPIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_search_subjects`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_search_topics`
#

CREATE TABLE `smf_log_search_topics` (
  `ID_SEARCH` tinyint(3) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`ID_SEARCH`,`ID_TOPIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_search_topics`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_search_words`
#

CREATE TABLE `smf_log_search_words` (
  `ID_WORD` int(10) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_WORD`,`ID_MSG`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_search_words`
#


# ############################

#
# Estructura de tabla para la tabla `smf_log_topics`
#

CREATE TABLE `smf_log_topics` (
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  `ID_MSG` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_MEMBER`,`ID_TOPIC`),
  KEY `ID_TOPIC` (`ID_TOPIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_log_topics`
#


# ############################

#
# Estructura de tabla para la tabla `smf_membergroups`
#

CREATE TABLE `smf_membergroups` (
  `ID_GROUP` smallint(5) unsigned NOT NULL auto_increment,
  `groupName` varchar(80) NOT NULL default '',
  `onlineColor` varchar(20) NOT NULL default '',
  `minPosts` mediumint(9) NOT NULL default '-1',
  `maxMessages` smallint(5) unsigned NOT NULL default '0',
  `stars` tinytext NOT NULL,
  PRIMARY KEY  (`ID_GROUP`),
  KEY `minPosts` (`minPosts`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

#
# Volcar la base de datos para la tabla `smf_membergroups`
#

INSERT INTO `smf_membergroups` (`ID_GROUP`, `groupName`, `onlineColor`, `minPosts`, `maxMessages`, `stars`) VALUES
(1, 'Administrador', '#1984FF', -1, 0, '1#rangos/admin.gif'),
(2, 'Moderador', '#FFBF00', -1, 0, '1#rangos/moderador.gif'),
(3, 'Moderatdor', '#13DD02', -1, 0, ''),
(4, 'Leecher', '#B3B7B7', 0, 0, '1#rangos/leecher.gif'),
(5, 'Novato', '#8B8E8E', 5, 0, '1#rangos/novato.gif'),
(6, 'Gamexero', '#B8C100', 150, 0, '1#rangos/user-complet.gif'),
(7, 'Miembro VIP', '', -1, 0, '1#rangos/VIP.gif');

# ############################

#
# Estructura de tabla para la tabla `smf_members`
#

CREATE TABLE `smf_members` (
  `ID_MEMBER` mediumint(8) unsigned NOT NULL auto_increment,
  `memberName` varchar(80) NOT NULL default '',
  `dateRegistered` int(10) unsigned NOT NULL default '0',
  `posts` mediumint(8) unsigned NOT NULL default '0',
  `topics` mediumint(8) unsigned NOT NULL default '0',
  `ID_GROUP` smallint(5) unsigned NOT NULL default '0',
  `lngfile` tinytext NOT NULL,
  `lastLogin` int(10) unsigned NOT NULL default '0',
  `realName` tinytext NOT NULL,
  `instantMessages` smallint(5) NOT NULL default '0',
  `unreadMessages` smallint(5) NOT NULL default '0',
  `buddy_list` mediumtext NOT NULL,
  `pm_ignore_list` tinytext NOT NULL,
  `messageLabels` mediumtext NOT NULL,
  `passwd` varchar(64) NOT NULL default '',
  `emailAddress` tinytext NOT NULL,
  `personalText` tinytext NOT NULL,
  `gender` tinyint(4) unsigned NOT NULL default '0',
  `birthdate` date NOT NULL default '0001-01-01',
  `websiteTitle` tinytext NOT NULL,
  `websiteUrl` tinytext NOT NULL,
  `location` tinytext NOT NULL,
  `ICQ` tinytext NOT NULL,
  `AIM` varchar(16) NOT NULL default '',
  `YIM` varchar(32) NOT NULL default '',
  `MSN` tinytext NOT NULL,
  `hideEmail` tinyint(4) NOT NULL default '0',
  `showOnline` tinyint(4) NOT NULL default '1',
  `timeFormat` varchar(80) NOT NULL default '',
  `signature` mediumtext NOT NULL,
  `timeOffset` float NOT NULL default '0',
  `avatar` tinytext NOT NULL,
  `pm_email_notify` tinyint(4) NOT NULL default '0',
  `karmaBad` smallint(5) unsigned NOT NULL default '0',
  `karmaGood` smallint(5) unsigned NOT NULL default '0',
  `usertitle` tinytext NOT NULL,
  `notifyAnnouncements` tinyint(4) NOT NULL default '1',
  `notifyOnce` tinyint(4) NOT NULL default '1',
  `notifySendBody` tinyint(4) NOT NULL default '0',
  `notifyTypes` tinyint(4) NOT NULL default '2',
  `memberIP` tinytext NOT NULL,
  `memberIP2` tinytext NOT NULL,
  `secretQuestion` tinytext NOT NULL,
  `secretAnswer` varchar(64) NOT NULL default '',
  `ID_THEME` tinyint(4) unsigned NOT NULL default '0',
  `is_activated` tinyint(3) unsigned NOT NULL default '1',
  `validation_code` varchar(10) NOT NULL default '',
  `ID_MSG_LAST_VISIT` int(10) unsigned NOT NULL default '0',
  `additionalGroups` tinytext NOT NULL,
  `smileySet` varchar(48) NOT NULL default '',
  `ID_POST_GROUP` smallint(5) unsigned NOT NULL default '0',
  `totalTimeLoggedIn` int(10) unsigned NOT NULL default '0',
  `passwordSalt` varchar(5) NOT NULL default '',
  `money` decimal(9,2) unsigned NOT NULL default '0.00',
  `moneyBank` decimal(9,2) unsigned NOT NULL default '0.00',
  `thank_you_post_made` mediumint(8) unsigned NOT NULL default '0',
  `thank_you_post_became` mediumint(8) unsigned NOT NULL default '0',
  `recentpostBoards` text,
  `recentLastOnly` tinyint(4) default NULL,
  `recentNrofPosts` tinyint(4) default NULL,
  PRIMARY KEY  (`ID_MEMBER`),
  KEY `memberName` (`memberName`(30)),
  KEY `dateRegistered` (`dateRegistered`),
  KEY `ID_GROUP` (`ID_GROUP`),
  KEY `birthdate` (`birthdate`),
  KEY `posts` (`posts`),
  KEY `lastLogin` (`lastLogin`),
  KEY `lngfile` (`lngfile`(30)),
  KEY `ID_POST_GROUP` (`ID_POST_GROUP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


# ############################

#
# Estructura de tabla para la tabla `smf_messages`
#

CREATE TABLE `smf_messages` (
  `ID_MSG` int(10) unsigned NOT NULL auto_increment,
  `ID_TOPIC` mediumint(8) unsigned NOT NULL,
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `posterTime` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `ID_MSG_MODIFIED` int(10) unsigned NOT NULL default '0',
  `subject` tinytext NOT NULL,
  `posterName` tinytext NOT NULL,
  `posterEmail` tinytext NOT NULL,
  `posterIP` tinytext NOT NULL,
  `smileysEnabled` tinyint(4) NOT NULL default '1',
  `modifiedTime` int(10) unsigned NOT NULL default '0',
  `modifiedName` tinytext NOT NULL,
  `body` mediumtext,
  `icon` varchar(16) NOT NULL default 'xx',
  `edit_reason` tinytext NOT NULL,
  `thank_you_post` tinyint(4) unsigned NOT NULL default '0',
  `thank_you_post_counter` smallint(5) unsigned NOT NULL default '0',
  `hiddenOption` tinyint(4) unsigned NOT NULL default '0',
  `hiddenValue` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_MSG`),
  UNIQUE KEY `ID_BOARD` (`ID_BOARD`,`ID_MSG`),
  UNIQUE KEY `ID_MEMBER` (`ID_MEMBER`,`ID_MSG`),
  UNIQUE KEY `topic` (`ID_MSG`,`ID_TOPIC`),
  KEY `ipIndex` (`posterIP`(15),`ID_TOPIC`),
  KEY `participation` (`ID_MEMBER`,`ID_TOPIC`),
  KEY `showPosts` (`ID_MEMBER`,`ID_BOARD`),
  KEY `ID_TOPIC` (`ID_TOPIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_messages`
#


# ############################

#
# Estructura de tabla para la tabla `smf_message_icons`
#

CREATE TABLE `smf_message_icons` (
  `ID_ICON` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(80) NOT NULL default '',
  `filename` varchar(80) NOT NULL default '',
  `ID_BOARD` mediumint(8) unsigned NOT NULL default '0',
  `iconOrder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_ICON`),
  KEY `ID_BOARD` (`ID_BOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_message_icons`
#


# ############################

#
# Estructura de tabla para la tabla `smf_moderators`
#

CREATE TABLE `smf_moderators` (
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_BOARD`,`ID_MEMBER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_moderators`
#


# ############################

#
# Estructura de tabla para la tabla `smf_package_servers`
#

CREATE TABLE `smf_package_servers` (
  `ID_SERVER` smallint(5) unsigned NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  PRIMARY KEY  (`ID_SERVER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_package_servers`
#


# ############################

#
# Estructura de tabla para la tabla `smf_permissions`
#

CREATE TABLE `smf_permissions` (
  `ID_GROUP` smallint(5) NOT NULL default '0',
  `permission` varchar(30) NOT NULL default '',
  `addDeny` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`ID_GROUP`,`permission`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_permissions`
#

INSERT INTO `smf_permissions` (`ID_GROUP`, `permission`, `addDeny`) VALUES
(1, 'shop_main', 1),
(1, 'shop_buy', 1),
(1, 'shop_invother', 1),
(1, 'shop_sendmoney', 1),
(1, 'shop_senditems', 1),
(1, 'shop_bank', 1),
(1, 'shop_trade', 1),
(3, 'shop_main', 1),
(3, 'shop_buy', 1),
(3, 'shop_invother', 1),
(3, 'shop_sendmoney', 1),
(3, 'shop_senditems', 1),
(3, 'shop_bank', 1),
(3, 'shop_trade', 1),
(0, 'smfgallery_delete', 1),
(0, 'smfgallery_report', 1),
(0, 'shop_sendmoney', 1),
(-1, 'search_posts', 1),
(0, 'smfgallery_view', 1),
(0, 'shop_main', 1),
(-1, 'smfgallery_view', 1),
(0, 'smfgallery_comment', 1),
(-1, 'view_stafflist', 1),
(0, 'smfgallery_edit', 1),
(0, 'pm_send', 1),
(0, 'smfgallery_add', 1),
(0, 'view_stats', 1),
(0, 'search_posts', 1),
(0, 'view_stafflist', 1),
(0, 'pm_read', 1),
(7, 'profile_remote_avatar', 1),
(2, 'profile_title_own', 1),
(2, 'profile_extra_own', 1),
(2, 'profile_identity_own', 1),
(2, 'profile_view_any', 1),
(2, 'profile_view_own', 1),
(2, 'smfgallery_manage', 1),
(2, 'smfgallery_autoapprove', 1),
(2, 'smfgallery_report', 1),
(2, 'smfgallery_comment', 1),
(2, 'smfgallery_edit', 1),
(7, 'pm_read', 1),
(7, 'pm_send', 1),
(7, 'profile_extra_own', 1),
(7, 'profile_identity_own', 1),
(2, 'profile_remote_avatar', 1),
(7, 'profile_view_any', 1),
(7, 'profile_view_own', 1),
(7, 'search_posts', 1),
(7, 'shop_main', 1),
(7, 'shop_sendmoney', 1),
(7, 'smfgallery_add', 1),
(7, 'smfgallery_autoapprove', 1),
(7, 'smfgallery_comment', 1),
(7, 'smfgallery_delete', 1),
(7, 'smfgallery_edit', 1),
(7, 'smfgallery_report', 1),
(7, 'smfgallery_view', 1),
(7, 'view_stafflist', 1),
(7, 'view_stats', 1),
(0, 'smfgallery_autoapprove', 1),
(0, 'profile_view_own', 1),
(0, 'profile_view_any', 1),
(0, 'profile_identity_own', 1),
(0, 'profile_extra_own', 1),
(0, 'profile_title_own', 1),
(0, 'profile_remote_avatar', 1),
(2, 'smfgallery_delete', 1),
(2, 'smfgallery_add', 1),
(2, 'smfgallery_view', 1),
(2, 'shop_sendmoney', 1),
(2, 'shop_main', 1),
(2, 'pm_send', 1),
(2, 'pm_read', 1),
(2, 'manage_bans', 1),
(2, 'edit_news', 1),
(2, 'manage_boards', 1),
(2, 'view_stafflist', 1),
(2, 'search_posts', 1),
(2, 'view_mlist', 1),
(2, 'view_stats', 1);

# ############################

#
# Estructura de tabla para la tabla `smf_personal_messages`
#

CREATE TABLE `smf_personal_messages` (
  `ID_PM` int(10) unsigned NOT NULL auto_increment,
  `ID_MEMBER_FROM` mediumint(8) unsigned NOT NULL default '0',
  `deletedBySender` tinyint(3) unsigned NOT NULL default '0',
  `fromName` tinytext NOT NULL,
  `msgtime` int(10) unsigned NOT NULL default '0',
  `subject` tinytext NOT NULL,
  `body` mediumtext NOT NULL,
  PRIMARY KEY  (`ID_PM`),
  KEY `ID_MEMBER` (`ID_MEMBER_FROM`,`deletedBySender`),
  KEY `msgtime` (`msgtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

#
# Volcar la base de datos para la tabla `smf_personal_messages`
#

INSERT INTO `smf_personal_messages` (`ID_PM`, `ID_MEMBER_FROM`, `deletedBySender`, `fromName`, `msgtime`, `subject`, `body`) VALUES
(2, 1, 1, 'LoverFire', 1227859950, 'Re: password para los zips', 'www.ga-mex.org&nbsp;  o www.ga-mex-almacen.net'),
(3, 0, 1, 'MetalKing', 1228443324, 'Importante', 'Dos de tus ultimos posts estan en mayusculas (sus titulos) editalo , o para mañana se borran'),
(4, 0, 1, 'shin-gori', 1228445875, 'Re: Importante', 'xuta... no lei esa parte... weno como digas...'),
(5, 0, 1, 'gil', 1231214676, 'Sin Asunto', 'putooooooooooooooooooooooooooooooo<br /><br />jajajjaja'),
(6, 0, 1, 'Nobody', 1232839155, 'Hola', 'Hola MirrorKissers...<br /><br />Oie te tengo una propuesta para mejorar el diseño de el AREA DE TEXTO de cuando agregas un Posts...<br /><br />Agrégame un hablamos<br />xico_electronicox_93@hotmail.com<br /><br />Es para que el Textarea quede como el de taringa...');

# ############################

#
# Estructura de tabla para la tabla `smf_pm_recipients`
#

CREATE TABLE `smf_pm_recipients` (
  `ID_PM` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `labels` varchar(60) NOT NULL default '-1',
  `bcc` tinyint(3) unsigned NOT NULL default '0',
  `is_read` tinyint(3) unsigned NOT NULL default '0',
  `deleted` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_PM`,`ID_MEMBER`),
  UNIQUE KEY `ID_MEMBER` (`ID_MEMBER`,`deleted`,`ID_PM`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_pm_recipients`
#


# ############################

#
# Estructura de tabla para la tabla `smf_polls`
#

CREATE TABLE `smf_polls` (
  `ID_POLL` mediumint(8) unsigned NOT NULL auto_increment,
  `question` tinytext NOT NULL,
  `votingLocked` tinyint(1) NOT NULL default '0',
  `maxVotes` tinyint(3) unsigned NOT NULL default '1',
  `expireTime` int(10) unsigned NOT NULL default '0',
  `hideResults` tinyint(3) unsigned NOT NULL default '0',
  `changeVote` tinyint(3) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `posterName` tinytext NOT NULL,
  PRIMARY KEY  (`ID_POLL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_polls`
#


# ############################

#
# Estructura de tabla para la tabla `smf_sbox_content`
#

CREATE TABLE `smf_sbox_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `smf_sbox_content`
#

INSERT INTO `smf_sbox_content` (`id`, `time`, `ID_MEMBER`, `content`) VALUES
(1, 1225648201, 1, 'bd829932Prueba de chat en almacen ga-mex :musica:');

# ############################

#
# Estructura de tabla para la tabla `smf_sessions`
#

CREATE TABLE `smf_sessions` (
  `session_id` varchar(32) NOT NULL default '',
  `last_update` int(10) unsigned NOT NULL default '0',
  `data` mediumtext NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# ############################

#
# Table structure for table `poll_choices`
#

CREATE TABLE smf_poll_choices (
  ID_POLL mediumint(8) unsigned NOT NULL default '0',
  ID_CHOICE tinyint(3) unsigned NOT NULL default '0',
  label tinytext NOT NULL,
  votes smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY (ID_POLL, ID_CHOICE)
) TYPE=MyISAM;


# ############################

#
# Estructura de tabla para la tabla `smf_settings`
#

CREATE TABLE `smf_settings` (
  `variable` tinytext NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY  (`variable`(30))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_settings`
#

INSERT INTO `smf_settings` (`variable`, `value`) VALUES
('smfVersion', '1.1.4'),
('news', ''),
('enableReportPM', '1'),
('compactTopicPagesContiguous', '4'),
('compactTopicPagesEnable', '1'),
('enableStickyTopics', '1'),
('todayMod', '0'),
('karmaMode', '0'),
('karmaTimeRestrictAdmins', '1'),
('enablePreviousNext', '0'),
('pollMode', '0'),
('enableVBStyleLogin', '1'),
('enableCompressedOutput', '1'),
('karmaWaitTime', '0'),
('karmaMinPosts', '0'),
('karmaLabel', ''),
('karmaSmiteLabel', ''),
('karmaApplaudLabel', ''),
('attachmentSizeLimit', '0'),
('attachmentPostLimit', '0'),
('attachmentNumPerPostLimit', '0'),
('attachmentDirSizeLimit', '0'),
('attachmentUploadDir', ''),
('attachmentExtensions', 'doc,gif,jpg,mpg,pdf,png,txt,zip'),
('attachmentCheckExtensions', '0'),
('attachmentShowImages', '0'),
('attachmentEnable', '0'),
('attachmentEncryptFilenames', '0'),
('attachmentThumbnails', '0'),
('attachmentThumbWidth', '0'),
('attachmentThumbHeight', '0'),
('censorIgnoreCase', '0'),
('mostOnline', '968'),
('mostOnlineToday', '16'),
('mostDate', '1209925058'),
('allow_disableAnnounce', '1'),
('trackStats', '1'),
('userLanguage', '0'),
('titlesEnable', '1'),
('topicSummaryPosts', '9999999'),
('enableErrorLogging', '0'),
('max_image_width', '800'),
('max_image_height', '0'),
('onlineEnable', '1'),
('cal_holidaycolor', '80'),
('cal_bdaycolor', '920AC4'),
('cal_eventcolor', '78907'),
('cal_enabled', '0'),
('cal_maxyear', '2010'),
('cal_minyear', '2004'),
('cal_daysaslink', '0'),
('cal_defaultboard', ''),
('cal_showeventsonindex', '0'),
('cal_showbdaysonindex', '0'),
('cal_showholidaysonindex', '0'),
('cal_showeventsoncalendar', '1'),
('cal_showbdaysoncalendar', '1'),
('cal_showholidaysoncalendar', '1'),
('cal_showweeknum', '0'),
('cal_maxspan', '7'),
('smtp_host', ''),
('smtp_port', '25'),
('smtp_username', ''),
('smtp_password', ''),
('mail_type', '0'),
('timeLoadPageEnable', '0'),
('totalTopics', '0'),
('totalMessages', '0'),
('simpleSearch', '1'),
('censor_vulgar', 'Taringa\ntaringa.net\npantera86_1986@hotmail.com\nqwertys.com.ar\ndomsn.es\ntaringa\nTaringa!\ntArInGa\nTARINGA\nTaRiNgA\nwww.taaringa.net\nwww.tariinga.net\nwww.tarringa.net\ntarringa.net\nT!\nusercash.com\nhttp://www.filthimagehost.com/files/7z7oitkjbynejq09epqm.gif\nhttp://www.cuervolandiaweb.com.ar/imagehost/galleries/Mundial%202010/descargargiraazul.gif\nhttp://casitaweb.net/index.php?action=profile;u=10871;sa=post\nLoverFire\nloverfire\nlover\nhttp://www.limitends.com/out.php?u='),
('censor_proper', '******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\n******\nLoverFire\nLoverFire\nLoverFire\n'),
('enablePostHTML', '1'),
('theme_allow', '0'),
('theme_default', '0'),
('theme_guests', '1'),
('enableEmbeddedFlash', '1'),
('xmlnews_enable', '1'),
('xmlnews_maxlen', '255'),
('hotTopicPosts', '20'),
('hotTopicVeryPosts', '50'),
('registration_method', '0'),
('send_validation_onChange', '1'),
('send_welcomeEmail', '0'),
('allow_editDisplayName', '0'),
('allow_hideOnline', '0'),
('allow_hideEmail', '1'),
('guest_hideContacts', '1'),
('spamWaitTime', '10'),
('pm_spam_settings', '5,0,0'),
('reserveWord', '1'),
('reserveCase', '1'),
('reserveUser', '1'),
('reserveName', '1'),
('reserveNames', 'Webmaster\r\nGuest\r\nroot\r\ntaringa\r\n.net\r\n.org\r\n.com.ar\r\nAAAA\r\nAdministrador\r\nnoexite'),
('autoLinkUrls', '1'),
('banLastUpdated', '1231225019'),
('smileys_dir', '{$boarddir}/Smileys'),
('smileys_url', '{$boardurl}/Smileys'),
('avatar_directory', ''),
('avatar_url', ''),
('avatar_max_height_external', '0'),
('avatar_max_width_external', '150'),
('avatar_action_too_large', 'option_html_resize'),
('avatar_max_height_upload', '0'),
('avatar_max_width_upload', '0'),
('avatar_resize_upload', '0'),
('avatar_download_png', '0'),
('failed_login_threshold', '5'),
('oldTopicDays', '0'),
('edit_wait_time', '5'),
('edit_disable_time', '0'),
('autoFixDatabase', '1'),
('allow_guestAccess', '1'),
('time_format', '%B %d, %Y, %I:%M:%S %p'),
('number_format', '1234.00'),
('enableBBC', '1'),
('max_messageLength', '65536'),
('max_signatureLength', '400'),
('autoOptDatabase', '7'),
('autoOptMaxOnline', '0'),
('autoOptLastOpt', '1237413524'),
('defaultMaxMessages', '980'),
('defaultMaxTopics', '50'),
('defaultMaxMembers', '30'),
('enableParticipation', '0'),
('recycle_enable', '0'),
('recycle_board', '0'),
('maxMsgID', '19840'),
('enableAllMessages', '0'),
('fixLongWords', '0'),
('knownThemes', '1'),
('who_enabled', '1'),
('time_offset', '2'),
('cookieTime', '3153600'),
('lastActive', '5'),
('smiley_sets_known', 'default'),
('smiley_sets_names', 'Default'),
('smiley_sets_default', 'default'),
('cal_days_for_index', '7'),
('requireAgreement', '1'),
('unapprovedMembers', '0'),
('default_personalText', ''),
('package_make_backups', ''),
('databaseSession_enable', '1'),
('databaseSession_loose', '1'),
('databaseSession_lifetime', '2880'),
('search_cache_size', '50'),
('search_results_per_page', '50'),
('search_weight_frequency', '30'),
('search_weight_age', '25'),
('search_weight_length', '20'),
('search_weight_subject', '15'),
('search_weight_first_message', '10'),
('search_max_results', '0'),
('permission_enable_deny', '0'),
('permission_enable_postgroups', '0'),
('permission_enable_by_board', '0'),
('localCookies', '1'),
('default_timezone', 'Etc/GMT+5'),
('memberlist_updated', '1237413353'),
('latestMember', '1'),
('totalMembers', '0'),
('latestRealName', 'Admin'),
('mostOnlineUpdated', '2008-08-07'),
('cal_today_updated', '20090318'),
('cal_today_holiday', 'N;'),
('gallery_max_height', '0'),
('cal_today_birthday', 'N;'),
('global_announcements_enable', '0'),
('global_announcements_sort_by', 'subject'),
('signature_settings', '1,400,0,0,0,359,235,0:strike,ed2k,email,ftp,flash,swf,hr,googlevid,html,size,sub,sup,shadow,time,table,ytplaylist,youtube,hide'),
('cpgDisable', '1'),
('cpgPrefix', ''),
('ajaxregEnabled', '0'),
('ajaxregFailureCSS', ''),
('cal_today_event', 'N;'),
('topbottomEnable', '0'),
('enableSpellChecking', '0'),
('hide_posUnhiddenText', '4'),
('hide_hiddentext', 'Mensaje oculto, Responde Al Tema.'),
('gallery_max_filesize', '26000000'),
('sbox_Visible', '1'),
('sbox_ModsRule', '1'),
('sbox_DoHistory', '1'),
('sbox_GuestVisible', '0'),
('sbox_GuestAllowed', '0'),
('minChar', '0'),
('shopDate', '18th January 2007'),
('shopVersion', '3.0'),
('enable_buddylist', '0'),
('modlog_enabled', '0'),
('queryless_urls', '0'),
('er_who', 'anyone'),
('search_pointer', '0'),
('messageIcons_enable', '1'),
('sbox_Height', '138'),
('smfstaff_showlastactive', ''),
('country_flag_ask', '3'),
('country_flag_required', '1'),
('country_flag_show', '1'),
('smiley_enable', '1'),
('sbox_RefreshTime', '10'),
('smfstaff_showdateregistered', ''),
('smfstaff_showcontactinfo', ''),
('smfstaff_showlocalmods', '1'),
('hide_autounhidegroups', '1,2,3,7,5,6'),
('seo4smf_board_topic', 'on'),
('thankYouPostDisableUnhide', '0'),
('thankYouPostThxUnhideAll', '1'),
('thankYouPostPreviewOrder', '0'),
('thankYouPostFullOrder', '2'),
('thankYouPostUnhidePost', '1'),
('thankYouPostPreviewHM', '900'),
('thankYouPostPreview', '1'),
('thankYouPostDisplayPage', '0'),
('thankYouPostColors', '1'),
('thankYouPostOnePerPost', '0'),
('seo4smf_utf8_language', ''),
('sbox_AllowBBC', '1'),
('sbox_UserLinksVisible', '1'),
('sbox_GuestBBC', '0'),
('sbox_NewShoutsBar', '0'),
('sbox_MaxLines', '50'),
('smfstaff_showavatar', ''),
('shopCurrencyPrefix', ''),
('shopBuild', '12'),
('shopCurrencySuffix', ' Puntos'),
('shopPointsPerTopic', '1'),
('shopPointsPerPost', '0'),
('shopInterest', '0'),
('shopBankEnabled', '0'),
('shopImageWidth', '0'),
('shopImageHeight', '0'),
('shopTradeEnabled', '0'),
('shopItemsPerPage', '0'),
('shopMinDeposit', '0'),
('shopMinWithdraw', '0'),
('shopRegAmount', '20'),
('shopPointsPerWord', '0'),
('shopPointsPerChar', '0'),
('shopPointsLimit', '0'),
('shopFeeWithdraw', '0'),
('shopFeeDeposit', '0'),
('package_server', 'smallpirate.com'),
('package_port', '21'),
('package_username', 'Spirate'),
('sbox_BlockRefresh', '1'),
('sbox_SmiliesVisible', '1'),
('sitemap_xml', '1'),
('sitemap_topic_count', '90000'),
('sitemap_collapsible', '1'),
('password_strength', '0'),
('disable_visual_verification', '0'),
('hitStats', '1'),
('pm_register_from', 'Staff'),
('pm_register_enable', '0'),
('pm_register_body', '&amp;#039;Bienvenido/a &amp;quot;&amp;lt;b&amp;gt;{$username}&amp;lt;/b&amp;gt;&amp;quot;. Esperamos que te pases de nuevo por aqui, hagas tus aportes y preguntas. Te invitamos a que te [url={$boardurl}?topic=1]presentes[/url]&lt;br /&gt;&lt;br /&gt;El equipo del foro&lt;br /&gt;{$boardname}.'),
('pm_register_subject', 'Bienvenido'),
('sbox_EnableSounds', '0'),
('sbox_FontFamily', 'Arial, Helvetica, sans-serif'),
('sbox_TextSize', 'x-small'),
('sbox_TextColor1', '#CC780A'),
('sbox_DarkThemes', ''),
('sbox_TextColor2', ''),
('coppaAge', '0'),
('search_match_words', '0'),
('search_index', 'custom'),
('search_custom_index_config', 'a:1:{s:14:"bytes_per_word";i:5;}'),
('minWordLen', '0'),
('hide_enableHTML', '1'),
('hide_useSpanTag', '1'),
('convert_urls', '1'),
('ajaxregSuccessCSS', ''),
('censorWholeWord', '1'),
('gallery_max_width', '0'),
('gallery_who_viewing', '0'),
('gallery_commentchoice', '0'),
('gallery_shop_picadd', '0'),
('gallery_shop_commentadd', '0'),
('gallery_set_showcode_bbc_image', ''),
('gallery_set_showcode_directlink', ''),
('gallery_set_showcode_htmllink', ''),
('gallery_path', '{$boarddirl}/web/img/'),
('gallery_url', '{$boardurl}/web/img/'),
('global_character_set', 'UTF-8'),
('googletagged', '1'),
('allow_hiddenPost', '1'),
('show_hiddenMessage', '1'),
('max_hiddenValue', '500'),
('show_hiddenColor', 'red'),
('smftags_set_mintaglength', '3'),
('smftags_set_maxtaglength', '30'),
('smftags_set_maxtags', '10'),
('googletagged_together', '0'),
('avatar_download_external', '0'),
('global_announcements_sort_direction', 'ASC'),
('$key', '$value'),
('countChildPosts', '0'),
('search_stopwords', '101633002,227306032,310420379,387173358,606874276,665419812,710950976,740110935,760859284,780080978,807858898,918151391,943141432'),
('cache_enable', '3'),
('cache_memcached', '123'),
('anuncio1', 'Estoy Usando Spirate v2'),
('anuncio2', 'Uso Spirate v2'),
('anuncio3', 'Creado con Spirate v2'),
('anuncio4', 'Aupa Spirate!!! xD'),
('anuncio5', 'Bienvenido a ... Spirate v2!!! xD'),
('enlaces', '<a href="http://www.gmod.es">\r\n<img src="http://gmod.es/archivos/gmodspain.gif" width="88" height="32">');

# ############################

#
# Estructura de tabla para la tabla `smf_shop_categories`
#

CREATE TABLE `smf_shop_categories` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_shop_categories`
#


# ############################

#
# Estructura de tabla para la tabla `smf_shop_inventory`
#

CREATE TABLE `smf_shop_inventory` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ownerid` int(10) unsigned NOT NULL,
  `itemid` int(10) unsigned NOT NULL,
  `amtpaid` int(10) unsigned NOT NULL default '0',
  `trading` tinyint(1) unsigned NOT NULL,
  `tradecost` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_shop_inventory`
#


# ############################

#
# Estructura de tabla para la tabla `smf_shop_items`
#

CREATE TABLE `smf_shop_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `desc` mediumtext NOT NULL,
  `price` int(10) unsigned NOT NULL default '0',
  `module` tinytext NOT NULL,
  `stock` smallint(6) NOT NULL default '0',
  `info1` mediumtext NOT NULL,
  `info2` mediumtext NOT NULL,
  `info3` mediumtext NOT NULL,
  `info4` mediumtext NOT NULL,
  `input_needed` tinyint(3) unsigned NOT NULL default '1',
  `can_use_item` tinyint(3) unsigned NOT NULL default '1',
  `delete_after_use` tinyint(1) unsigned NOT NULL default '1',
  `image` tinytext NOT NULL,
  `category` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

#
# Volcar la base de datos para la tabla `smf_shop_items`
#


# ############################

#
# Estructura de tabla para la tabla `smf_smileys`
#

CREATE TABLE `smf_smileys` (
  `ID_SMILEY` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(30) NOT NULL default '',
  `filename` varchar(48) NOT NULL default '',
  `description` varchar(80) NOT NULL default '',
  `smileyRow` tinyint(4) unsigned NOT NULL default '0',
  `smileyOrder` smallint(5) unsigned NOT NULL default '0',
  `hidden` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_SMILEY`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

#
# Volcar la base de datos para la tabla `smf_smileys`
#

INSERT INTO `smf_smileys` (`ID_SMILEY`, `code`, `filename`, `description`, `smileyRow`, `smileyOrder`, `hidden`) VALUES
(54, ':smartass1:', 'smartass1.gif', '', 0, 31, 2),
(36, ':mrorange:', 'icon_mrorange.gif', '', 0, 16, 0),
(37, ':mrviolet:', 'icon_mrviolet.gif', '', 0, 17, 0),
(53, ':smartass:', 'smartass.gif', '', 0, 30, 2),
(59, ':offtopic:', 'offtopic.gif', '', 0, 32, 2),
(64, ':Ilcasita:', 'Ilcasitaweb.png', '', 0, 36, 2),
(35, ':mrgreen:', 'icon_mrgreen.gif', '', 0, 15, 0),
(46, ':twisted:', 'icon_twisted.gif', '', 0, 26, 0),
(60, ':cerrado:', 'cerrado.gif', '', 0, 33, 2),
(34, ':mrblue:', 'icon_mrblue.gif', '', 0, 14, 0),
(56, ':musica:', '725tqmp.gif', '', 0, 28, 0),
(62, ':google:', 'google.gif', '', 0, 34, 2),
(63, ':pirata:', 'pirata.gif', '', 0, 35, 2),
(23, ':arrow:', 'icon_arrow.gif', '', 0, 3, 0),
(21, ':cross:', 'cross.gif', '', 0, 1, 2),
(51, ':love1:', 'love1.gif', '', 0, 28, 2),
(52, ':nurse:', 'nurse.gif', '', 0, 29, 2),
(58, ':ninja:', 'ninja.gif', '', 0, 30, 0),
(26, ':cool:', 'icon_cool.gif', '', 0, 6, 0),
(29, ':evil:', 'icon_evil.gif', '', 0, 9, 0),
(31, ':idea:', 'icon_idea.gif', '', 0, 11, 0),
(42, ':roll:', 'icon_rolleyes.gif', '', 0, 22, 0),
(49, ':lcop:', 'lcop.gif', '', 0, 4, 2),
(50, ':love:', 'love.gif', '', 0, 28, 2),
(65, ':emo1:', 'emoticon-001-cw-net.gif', '', 0, 37, 2),
(22, ':doc:', 'doc.gif', '', 0, 2, 2),
(20, ':cop:', 'cop.gif', '', 0, 0, 2),
(25, ':???:', 'icon_confused.gif', '', 0, 5, 0),
(27, ':cry:', 'icon_cry.gif', '', 0, 7, 0),
(32, ':lol:', 'icon_lol.gif', '', 0, 12, 0),
(33, ':mad:', 'icon_mad.gif', '', 0, 13, 0),
(48, ':kid:', 'kid.gif', '', 0, 3, 2),
(57, ':fff:', 'ffff.gif', '', 0, 29, 0),
(30, ':!:', 'icon_exclaim.gif', '', 0, 10, 0),
(39, ':?:', 'icon_question.gif', '', 0, 19, 0),
(55, ':v:', 'tick.gif', '', 0, 28, 2),
(24, ':D', 'icon_biggrin.gif', '', 0, 4, 0),
(41, ':$', 'icon_redface.gif', '', 0, 21, 0),
(40, ':P', 'icon_razz.gif', '', 0, 20, 0),
(28, '8|', 'icon_eek.gif', '', 0, 8, 0),
(38, ':|', 'icon_neutral.gif', '', 0, 18, 0),
(43, ':(', 'icon_sad.gif', '', 0, 23, 0),
(44, ':)', 'icon_smile.gif', '', 0, 24, 0),
(45, ':O', 'icon_surprised.gif', '', 0, 25, 0),
(47, ';)', 'icon_wink.gif', '', 0, 27, 0),
(61, '!', 'icon13.gif', '', 0, 31, 0),
(66, ':banyg:', '002.gif', '', 0, 38, 2);

# ############################

#
# Estructura de tabla para la tabla `smf_tags`
#

CREATE TABLE `smf_tags` (
  `ID_TAG` mediumint(8) NOT NULL auto_increment,
  `tag` tinytext NOT NULL,
  `approved` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID_TAG`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_tags`
#


# ############################

#
# Estructura de tabla para la tabla `smf_tags_log`
#

CREATE TABLE `smf_tags_log` (
  `ID` int(11) NOT NULL auto_increment,
  `ID_TAG` mediumint(8) unsigned NOT NULL default '0',
  `ID_TOPIC` mediumint(8) unsigned NOT NULL default '0',
  `ID_MEMBER` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_tags_log`
#


# ############################

#
# Estructura de tabla para la tabla `smf_thank_you_post`
#

CREATE TABLE `smf_thank_you_post` (
  `ID_THX_POST` int(10) unsigned NOT NULL auto_increment,
  `ID_MSG` int(10) unsigned NOT NULL,
  `ID_TOPIC` mediumint(8) unsigned NOT NULL,
  `ID_BOARD` smallint(5) unsigned NOT NULL,
  `ID_MEMBER` mediumint(8) unsigned NOT NULL,
  `memberName` varchar(80) NOT NULL,
  `thx_time` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ID_THX_POST`),
  KEY `ID_BOARD` (`ID_BOARD`),
  KEY `ID_MSG` (`ID_MSG`),
  KEY `ID_TOPIC` (`ID_TOPIC`),
  KEY `ID_MEMBER` (`ID_MEMBER`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `smf_thank_you_post`
#


# ############################

#
# Estructura de tabla para la tabla `smf_themes`
#

CREATE TABLE `smf_themes` (
  `ID_MEMBER` mediumint(8) NOT NULL default '0',
  `ID_THEME` tinyint(4) unsigned NOT NULL default '1',
  `variable` tinytext NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY  (`ID_THEME`,`ID_MEMBER`,`variable`(30)),
  KEY `ID_MEMBER` (`ID_MEMBER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Volcar la base de datos para la tabla `smf_themes`
#

INSERT INTO `smf_themes` (`ID_MEMBER`, `ID_THEME`, `variable`, `value`) VALUES
(0, 1, 'name', 'Spirate Tema Predeterminado'),
(0, 1, 'theme_url', '{$boardurl}/Themes/default'),
(0, 1, 'images_url', '{$boardurl}/Themes/default/images'),
(0, 1, 'theme_dir', '{$boarddir}/Themes/default'),
(0, 1, 'show_bbc', '1'),
(0, 1, 'show_latest_member', '1'),
(0, 1, 'show_modify', '1'),
(0, 1, 'show_user_images', '1'),
(0, 1, 'show_blurb', '1'),
(0, 1, 'show_gender', '1'),
(0, 1, 'show_newsfader', '0'),
(0, 1, 'number_recent_posts', '15'),
(0, 1, 'show_member_bar', '1'),
(0, 1, 'linktree_link', '1'),
(0, 1, 'show_profile_buttons', '1'),
(0, 1, 'show_mark_read', '1'),
(0, 1, 'show_sp1_info', '1'),
(0, 1, 'linktree_inline', '0'),
(0, 1, 'show_board_desc', '1'),
(0, 1, 'newsfader_time', '5000'),
(0, 1, 'allow_no_censored', '0'),
(0, 1, 'additional_options_collapsable', '0'),
(0, 1, 'use_image_buttons', '1'),
(0, 1, 'enable_news', '0'),
(-1, 1, 'show_board_desc', '0'),
(-1, 1, 'show_children', '0'),
(-1, 1, 'show_no_avatars', '0'),
(-1, 1, 'show_no_signatures', '0'),
(-1, 1, 'show_no_censored', '0'),
(-1, 1, 'return_to_post', '0'),
(-1, 1, 'no_new_reply_warning', '0'),
(-1, 1, 'view_newest_first', '0'),
(-1, 1, 'view_newest_pm_first', '0'),
(-1, 1, 'popup_messages', '0'),
(-1, 1, 'copy_to_outbox', '0'),
(-1, 1, 'auto_notify', '0'),
(-1, 1, 'calendar_start_day', '1'),
(-1, 1, 'display_quick_reply', '2'),
(-1, 1, 'display_quick_mod', '1'),
(0, 1, 'header_logo_url', ''),
(0, 1, 'display_who_viewing', '0'),
(0, 1, 'smiley_sets_default', ''),
(0, 1, 'hide_post_group', '1');

# ############################

#
# Estructura de tabla para la tabla `smf_topics`
#

CREATE TABLE `smf_topics` (
  `ID_TOPIC` mediumint(8) unsigned NOT NULL auto_increment,
  `isSticky` tinyint(4) NOT NULL default '0',
  `ID_BOARD` smallint(5) unsigned NOT NULL default '0',
  `ID_FIRST_MSG` int(10) unsigned NOT NULL default '0',
  `ID_LAST_MSG` int(10) unsigned NOT NULL default '0',
  `ID_MEMBER_STARTED` mediumint(8) unsigned NOT NULL default '0',
  `ID_MEMBER_UPDATED` mediumint(8) unsigned NOT NULL default '0',
  `ID_POLL` mediumint(8) unsigned NOT NULL default '0',
  `numReplies` int(10) unsigned NOT NULL default '0',
  `numViews` int(10) unsigned NOT NULL default '0',
  `locked` tinyint(4) NOT NULL default '0',
  `puntos` tinyint(15) NOT NULL default '0',
  `thank_you_post_locked` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID_TOPIC`),
  UNIQUE KEY `lastMessage` (`ID_LAST_MSG`,`ID_BOARD`),
  UNIQUE KEY `firstMessage` (`ID_FIRST_MSG`,`ID_BOARD`),
  UNIQUE KEY `poll` (`ID_POLL`,`ID_TOPIC`),
  KEY `isSticky` (`isSticky`),
  KEY `ID_BOARD` (`ID_BOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `smf_topics`
#

