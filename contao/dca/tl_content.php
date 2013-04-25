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


$GLOBALS['TL_DCA']['tl_content']['config']['palettes_callback']['yaml'] = array('xYAML\DataContainer\Content', 'prepareDca');

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['xyaml_grid_row_start'] = array(
	'type'      => array('type', 'headline'),
	'protected' => array('protected'),
	'layout'    => array('xyaml_equialize'),
	'expert'    => array('guests', 'invisible', 'cssID', 'space')
);
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['xyaml_grid_row_end']   = array(
	'type'      => array('type', 'headline'),
	'protected' => array('protected'),
	'expert'    => array('guests', 'invisible')
);
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['xyaml_grid_cell_start'] = array(
	'type'      => array('type', 'headline'),
	'protected' => array('protected'),
	'layout'    => array('xyaml_grid'),
	'expert'    => array('guests', 'invisible', 'cssID', 'space')
);
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['xyaml_grid_cell_end']   = array(
	'type'      => array('type', 'headline'),
	'protected' => array('protected'),
	'expert'    => array('guests', 'invisible')
);

$GLOBALS['TL_DCA']['tl_content']['metasubselectpalettes']['xyaml_grid']   = array(
	'!' => array('xyaml_grid_float'),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xyaml_grid'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['xyaml_grid'],
	'inputType' => 'select',
	'options'   => array('20', '25', '33', '38', '40', '50', '60', '62', '66', '75', '80'),
	'reference' => &$GLOBALS['TL_LANG']['tl_content']['xyaml_grid_width'],
	'eval'      => array('submitOnChange' => true, 'includeBlankOption' => true, 'tl_class' => 'clr w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xyaml_grid_float'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['xyaml_grid_float'],
	'inputType' => 'select',
	'options'   => array('left', 'right'),
	'eval'      => array('tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xyaml_equialize'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['xyaml_equialize'],
	'inputType' => 'checkbox',
	'eval'      => array('tl_class' => 'm12 w50')
);
