<?php

/**
 * xYAML - YAML Integration for Contao
 *
 * Copyright (C) 2013 Tristan Lins <tristan.lins@bit3.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP version 5
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    xYAML
 * @license    MIT
 * @filesource
 */


/**
 * Settings
 */
$GLOBALS['TL_CONFIG']['yaml_auto_include'] = true;
$GLOBALS['TL_CONFIG']['yaml_mode']         = 'css';
$GLOBALS['TL_CONFIG']['yaml_path_source']  = $GLOBALS['TL_CONFIG']['uploadPath'];
$GLOBALS['TL_CONFIG']['subcolumns']        = 'yaml4';


/**
 * HOOKs
 */
$GLOBALS['TL_HOOKS']['getPageLayout']['xyaml'] = array('Bit3\Contao\XYAML\Hooks', 'hookGetPageLayout');


/**
 * YAML AddOns
 */
$GLOBALS['YAML_ADDONS']['accessible-tabs'] = array(
	'css' => array('add-ons/accessible-tabs/tabs.css'),
	'js'  => array('add-ons/accessible-tabs/jquery.tabs.js'),
);
$GLOBALS['YAML_ADDONS']['microformats'] = array(
	'css' => array('add-ons/microformats/microformats.css'),
);
$GLOBALS['YAML_ADDONS']['rtl-support'] = array(
	'css' => array(
		'add-ons/rtl-support/core/base-rtl.min.css',
		'add-ons/rtl-support/navigation/base-rtl.min.css',
		'add-ons/rtl-support/screen/base-rtl.min.css',
	),
);
$GLOBALS['YAML_ADDONS']['syncheight'] = array(
	'js' => array('add-ons/syncheight/jquery.syncheight.js'),
);


/**
 * YAML Forms
 */
$GLOBALS['YAML_FORMS']['gray-theme'] = array(
	'css' => array(
		'forms/gray-theme.css',
	),
);


/**
 * YAML Navigation
 */
$GLOBALS['YAML_NAVIGATION']['hlist'] = array(
	'css' => array('navigation/hlist.css'),
);
$GLOBALS['YAML_NAVIGATION']['vlist'] = array(
	'css' => array('navigation/vlist.css'),
);


/**
 * YAML Print
 */
$GLOBALS['YAML_PRINT']['print'] = array(
	'css' => array('print/print.css'),
);


/**
 * YAML Screen
 */
$GLOBALS['YAML_SCREEN']['grid-960gs-12'] = array(
	'css' => array('screen/grid-960gs-12.css'),
);
$GLOBALS['YAML_SCREEN']['grid-960gs-16'] = array(
	'css' => array('screen/grid-960gs-16.css'),
);
$GLOBALS['YAML_SCREEN']['grid-blueprint'] = array(
	'css' => array('screen/grid-blueprint.css'),
);
$GLOBALS['YAML_SCREEN']['grid-fluid-12col'] = array(
	'css' => array('screen/grid-fluid-12col.css'),
);
$GLOBALS['YAML_SCREEN']['screen-FULLPAGE-layout'] = array(
	'css' => array('screen/screen-FULLPAGE-layout.css'),
);
$GLOBALS['YAML_SCREEN']['screen-PAGE-layout'] = array(
	'css' => array('screen/screen-PAGE-layout.css'),
);
$GLOBALS['YAML_SCREEN']['typography'] = array(
	'css' => array('screen/typography.css'),
);
