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


MetaPalettes::appendTo('tl_settings', array('xyaml' => 'yaml_path'));

$GLOBALS['TL_DCA']['tl_settings']['fields']['yaml_path'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['yaml_path'],
	'inputType'               => 'fileSelector',
	'eval'                    => array('tl_class'=>'m12', 'path'=>'')
);

