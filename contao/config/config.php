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
$GLOBALS['TL_CTE']['layout']['xyaml_grid_row_start'] = 'xYAML\Content\GridRowStart';
$GLOBALS['TL_CTE']['layout']['xyaml_grid_row_end'] = 'xYAML\Content\GridRowEnd';


/**
 * HOOKs
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('xYAML', 'hookGeneratePage');


/**
 * Custom class loader fix
 */
if (version_compare(VERSION, '3', '<')) {
	$objCache = FileCache::getInstance('classes');
	foreach (
		array(
			'xYAML\Content\GridRowStart',
			'xYAML\Content\GridRowEnd'
		) as $strClass
	) {
		if (!$objCache->$strClass) {
			$objCache->$strClass = true;
		}
	}
}