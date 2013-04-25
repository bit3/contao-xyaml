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
$GLOBALS['TL_CONFIG']['yaml_path_source'] = $GLOBALS['TL_CONFIG']['uploadPath'];


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['layout']['xyaml_grid_row_start']  = 'xYAML\Content\GridRowStart';
$GLOBALS['TL_CTE']['layout']['xyaml_grid_row_end']    = 'xYAML\Content\GridRowEnd';
$GLOBALS['TL_CTE']['layout']['xyaml_grid_cell_start'] = 'xYAML\Content\GridCellStart';
$GLOBALS['TL_CTE']['layout']['xyaml_grid_cell_end']   = 'xYAML\Content\GridCellEnd';


/**
 * HOOKs
 */
$GLOBALS['TL_HOOKS']['generatePage']['xyaml']      = array('xYAML\Hooks', 'hookGeneratePage');
$GLOBALS['TL_HOOKS']['getContentElement']['xyaml'] = array('xYAML\Hooks', 'wrapContentElement');


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
 * Custom class loader fix
 */
if (version_compare(VERSION, '3', '<')) {
	$objCache = FileCache::getInstance('classes');
	foreach (
		array(
			'xYAML\Content\GridRowStart',
			'xYAML\Content\GridRowEnd',
			'xYAML\Content\GridCellStart',
			'xYAML\Content\GridCellEnd',
		) as $strClass
	) {
		if (!$objCache->$strClass) {
			$objCache->$strClass = true;
		}
	}
}