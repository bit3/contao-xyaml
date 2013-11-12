-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_layout`
-- 

CREATE TABLE `tl_layout` (
  `xyaml` char(1) NOT NULL default '',
  `xyaml_config` char(6) NOT NULL default '',
  `xyaml_iehacks` char(1) NOT NULL default '',
  `xyaml_addons` text NULL,
  `xyaml_forms` text NULL,
  `xyaml_navigation` text NULL,
  `xyaml_print` text NULL,
  `xyaml_screen` text NULL,
  `xyaml_subcolumns_linearize` char(1) NOT NULL default '',
  `xyaml_auto_include` char(1) NOT NULL default '',
  `xyaml_mode` char(4) NOT NULL default '',
  `xyaml_compass_filter` varchar(255) NOT NULL default '',
  `xyaml_path_source` varchar(255) NOT NULL default '',
  `xyaml_path` text NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
