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

namespace xYAML;

/**
 * Class xYAML
 */
class Hooks
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
		if ($GLOBALS['TL_CONFIG']['yaml_auto_include'] && $objLayout->xyaml && !empty($GLOBALS['TL_CONFIG']['yaml_path']))
		{
			$path = \Compat::resolveFile($GLOBALS['TL_CONFIG']['yaml_path'], false);

			if ($path) {
				if (!is_array($GLOBALS['TL_CSS'])) {
					$GLOBALS['TL_CSS'] = array();
				}
				if (!is_array($GLOBALS['TL_JAVASCRIPT'])) {
					$GLOBALS['TL_JAVASCRIPT'] = array();
				}

				// add yaml addons
				$addons = deserialize($objLayout->xyaml_addons, true);
				foreach ($addons as $addon) {
					if (isset($GLOBALS['YAML_ADDONS'][$addon])) {
						$config = $GLOBALS['YAML_ADDONS'][$addon];
						if (isset($config['css'])) {
							foreach ($config['css'] as $css) {
								array_unshift($GLOBALS['TL_CSS'], $path . '/' . $css);
							}
						}
						if (isset($config['js'])) {
							foreach ($config['js'] as $css) {
								array_unshift($GLOBALS['TL_JAVASCRIPT'], $path . '/' . $css);
							}
						}
					}
				}

				// add yaml base
				array_unshift($GLOBALS['TL_CSS'], $path . '/core/base.css');

				// add yaml iehacks
				if ($objLayout->xyaml_iehacks) {
					$GLOBALS['TL_HEAD']['xyaml_iehacks'] = <<<EOF
<!--[if lte IE 7]>
<link rel="stylesheet" href="{$path}/core/iehacks.min.css" type="text/css"/>
<![endif]-->
EOF;
				}
			}
		}

		return false;
	}

	public function wrapContentElement($element, $buffer)
	{
		if ($element->type != 'xyaml_grid_cell_start' && $element->xyaml_grid) {
			$startTemplate = new \FrontendTemplate('ce_xyaml_grid_cell_start');
			$startTemplate->grid = $element->xyaml_grid;
			$startTemplate->float = $element->xyaml_float;

			$endTemplate = new \FrontendTemplate('ce_xyaml_grid_cell_end');

			$buffer = $startTemplate->parse() . $buffer . $endTemplate->parse();
		}

		return $buffer;
	}
}

