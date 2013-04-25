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

namespace xYAML\DataContainer;

/**
 * Class Settings
 */
class Content
{
	public function prepareDca()
	{
		foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette => $fields) {
			if ($palette != '__selector__' && $palette != 'default' && $palette != 'xyaml_grid_row_start' && $palette != 'xyaml_grid_row_end') {
				\MetaPalettes::appendBefore('tl_content', $palette, 'expert', array('layout' => array('xyaml_grid')));
			}
		}
	}
}