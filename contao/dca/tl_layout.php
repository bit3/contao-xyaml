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


$GLOBALS['TL_DCA']['tl_layout']['config']['onload_callback'][] = array('Bit3\Contao\XYAML\DataContainer\Layout', 'load');

MetaPalettes::appendFields(
	'tl_layout',
	'default',
	'style',
	array('xyaml')
);

$GLOBALS['TL_DCA']['tl_layout']['metasubpalettes']['xyaml_auto_include'] = array(
	'xyaml_mode',
	'xyaml_path_source',
	'xyaml_path'
);

$GLOBALS['TL_DCA']['tl_layout']['metasubselectpalettes']['xyaml_mode']   = array('sass' => array('xyaml_compass_filter'));

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml']         = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml'],
	'inputType' => 'checkbox',
	'eval'      => array('submitOnChange' => true)
);
$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_iehacks'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_iehacks'],
	'inputType' => 'checkbox',
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_addons'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_addons'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_ADDONS']),
	'eval'      => array('multiple' => true, 'tl_class' => 'clr')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_forms'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_forms'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_FORMS']),
	'eval'      => array('multiple' => true, 'tl_class' => 'clr')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_navigation'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_navigation'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_NAVIGATION']),
	'eval'      => array('multiple' => true, 'tl_class' => 'clr')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_print'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_print'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_PRINT']),
	'eval'      => array('multiple' => true, 'tl_class' => 'clr')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_screen'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_screen'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_SCREEN']),
	'eval'      => array('multiple' => true, 'tl_class' => 'clr')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_subcolumns_linearize'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_subcolumns_linearize'],
	'inputType' => 'select',
	'options'   => array(1, 2),
	'reference' => $GLOBALS['TL_LANG']['tl_layout']['xyaml_subcolumns_linearize_levels'],
	'eval'      => array('includeBlankOption' => true, 'tl_class' => 'clr')
);


/**
 * Layout specific config
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_auto_include'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_auto_include'],
	'inputType' => 'checkbox',
	'eval'      => array(
		'submitOnChange' => true,
		'tl_class'       => 'm12',
	)
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_mode'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_mode'],
	'inputType' => 'select',
	'options'   => array('css'),
	'eval'      => array(
		'submitOnChange' => true,
		'tl_class'       => 'clr w50',
	)
);

if (in_array('assetic', \Config::getInstance()->getActiveModules())) {
	$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_mode']['options'][] = 'sass';
}

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_compass_filter'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_compass_filter'],
	'inputType'        => 'select',
	'options_callback' => array('Bit3\Contao\XYAML\DataContainer\OptionsBuilder', 'getCompassFilterOptions'),
	'reference'        => &$GLOBALS['TL_LANG']['assetic'],
	'eval'             => array(
		'includeBlankOption' => true,
		'tl_class'           => 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_path_source'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_path_source'],
	'inputType'        => 'select',
	'options_callback' => array('Bit3\Contao\XYAML\DataContainer\OptionsBuilder', 'getPathSources'),
	'eval'             => array(
		'submitOnChange' => true,
		'tl_class'       => 'w50 clr',
	),
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_path'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_path'],
	'inputType' => 'fileTree',
	'eval'      => array(
		'submitOnChange' => true,
		'path'           => $GLOBALS['TL_CONFIG']['uploadPath'],
		'fieldType'      => 'radio',
		'tl_class'       => 'clr',
	)
);
