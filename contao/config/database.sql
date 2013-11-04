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
  `xyaml_iehacks` char(1) NOT NULL default '',
  `xyaml_addons` text NULL,
  `xyaml_forms` text NULL,
  `xyaml_navigation` text NULL,
  `xyaml_print` text NULL,
  `xyaml_screen` text NULL,
  `xyaml_subcolumns_linearize` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_content`
--

CREATE TABLE `tl_content` (
  `xyaml_equialize` char(1) NOT NULL default '',
  `xyaml_grid` char(2) NOT NULL default '',
  `xyaml_grid_float` char(5) NOT NULL default 'left',
  `xyaml_linearize_level` varchar(255) NOT NULL default '',
  `xyaml_class` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
