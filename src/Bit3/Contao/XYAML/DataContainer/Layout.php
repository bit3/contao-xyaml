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

namespace Bit3\Contao\XYAML\DataContainer;

/**
 * Class Layout
 */
class Layout
{
	public function load($dc)
	{
		$layout = \LayoutModel::findByPk($dc->id);

		if (!$layout->xyaml) {
			return;
		}

		\MetaPalettes::appendAfter(
			'tl_layout',
			'default',
			'style',
			array(
				'xyaml' => array(
					'xyaml_iehacks',
					'xyaml_addons',
					'xyaml_forms',
					'xyaml_navigation',
					'xyaml_print',
					'xyaml_screen',
					'xyaml_subcolumns_linearize',
				),
				'xyaml_files' => array(
					'xyaml_auto_include',
				),
			)
		);

		if (version_compare(VERSION, '3', '>=') && $layout->xyaml_path_source != $GLOBALS['TL_CONFIG']['uploadPath']) {
			$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_path']['inputType'] = 'fileSelector';
		}

		$GLOBALS['TL_DCA']['tl_layout']['fields']['xyaml_path']['eval']['path'] = $layout->xyaml_path_source;
	}
}