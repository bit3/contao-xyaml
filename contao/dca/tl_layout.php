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


if ($GLOBALS['TL_CONFIG']['yaml_auto_include']) {
	MetaPalettes::appendFields('tl_layout', 'default', 'style', array('xyaml'));

	$GLOBALS['TL_DCA']['tl_layout']['metasubpalettes']['xyaml'] = array('xyaml_iehacks', 'xyaml_addons');
}

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml'],
	'inputType' => 'checkbox',
	'eval'      => array('submitOnChange' => true, 'tl_class' => 'w50 m12')
);
$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_iehacks'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_iehacks'],
	'inputType' => 'checkbox',
	'eval'      => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_addons'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_layout']['xyaml_addons'],
	'inputType' => 'checkbox',
	'options'   => array_keys($GLOBALS['YAML_ADDONS']),
	'eval'      => array('multiple' => true)
);
