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
 * Class xYAML
 */
class xYAML
{
	/**
	 * Add yaml css to layout.
	 *
	 * @param Database_Result $objPage
	 * @param Database_Result $objLayout
	 * @param PageRegular $objPageRegular
	 */
	public function hookGeneratePage($objPage, $objLayout, $objPageRegular)
	{
		if (!$objLayout->xyaml)
		{
			return false;
		}

		array_unshift($GLOBALS['TL_CSS'], LocalThemePlusFile::create('system/modules/xYAML/yaml/core/iehacks.css', '', 'lte IE 7'));
		array_unshift($GLOBALS['TL_CSS'], 'system/modules/xYAML/yaml/core/base.css');
	}
}

