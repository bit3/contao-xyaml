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
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    xYAML
 * @license    MIT
 * @filesource
 */


MetaPalettes::appendTo('tl_settings', array('xyaml' => array('yaml_auto_include')));

$GLOBALS['TL_DCA']['tl_settings']['metasubpalettes']['yaml_auto_include'] = array(
	'yaml_mode',
	'yaml_path_source',
	'yaml_path'
);
$GLOBALS['TL_DCA']['tl_settings']['metasubselectpalettes']['yaml_mode']   = array('sass' => array('yaml_compass_filter'));

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_auto_include'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['yaml_auto_include'],
	'inputType' => 'checkbox',
	'eval'      => array(
		'submitOnChange' => true,
		'tl_class'       => 'w50 m12',
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_mode'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['yaml_mode'],
	'inputType' => 'select',
	'options'   => array('css'),
	'eval'      => array(
		'submitOnChange' => true,
		'tl_class'       => 'w50',
	)
);

if (in_array('assetic', \Config::getInstance()->getActiveModules())) {
	$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_mode']['options'][] = 'sass';
}

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_compass_filter'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_settings']['yaml_compass_filter'],
	'inputType'        => 'select',
	'options_callback' => array('Bit3\Contao\XYAML\DataContainer\OptionsBuilder', 'getCompassFilterOptions'),
	'reference'        => &$GLOBALS['TL_LANG']['assetic'],
	'eval'             => array(
		'includeBlankOption' => true,
		'tl_class'           => 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_path_source'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_settings']['yaml_path_source'],
	'inputType'        => 'select',
	'options_callback' => array('Bit3\Contao\XYAML\DataContainer\OptionsBuilder', 'getPathSources'),
	'eval'             => array(
		'submitOnChange' => true,
		'tl_class'       => 'w50',
	),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_path'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['yaml_path'],
	'inputType' => (version_compare(VERSION, '3', '<') ||
	$GLOBALS['TL_CONFIG']['yaml_path_source'] == $GLOBALS['TL_CONFIG']['uploadPath']
		? 'fileTree'
		: 'fileSelector'),
	'eval'      => array(
		'submitOnChange' => true,
		'path'           => $GLOBALS['TL_CONFIG']['yaml_path_source'],
		'fieldType'      => 'radio',
		'tl_class'       => 'clr',
	)
);
