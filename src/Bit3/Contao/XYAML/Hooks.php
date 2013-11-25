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

namespace Bit3\Contao\XYAML;

use Assetic\Asset\FileAsset;
use ContaoAssetic\AsseticFactory;

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
	public function hookGetPageLayout($objPage, $objLayout, $objPageRegular)
	{
		$autoInclude = $objLayout->xyaml_auto_include || $GLOBALS['TL_CONFIG']['yaml_auto_include'];
		$path = $objLayout->xyaml_auto_include ? $objLayout->xyaml_path : $GLOBALS['TL_CONFIG']['yaml_path'];

		if ($autoInclude && $objLayout->xyaml && !empty($path))
		{
			$mode = $objLayout->xyaml_auto_include ? $objLayout->xyaml_mode : $GLOBALS['TL_CONFIG']['yaml_mode'];
			$filter = $objLayout->xyaml_auto_include ? $objLayout->xyaml_compass_filter : $GLOBALS['TL_CONFIG']['yaml_compass_filter'];

			$path = \Compat::resolveFile($path, false);

			if ($path) {
				if (!is_array($GLOBALS['TL_CSS'])) {
					$GLOBALS['TL_CSS'] = array();
				}
				if (!is_array($GLOBALS['TL_JAVASCRIPT'])) {
					$GLOBALS['TL_JAVASCRIPT'] = array();
				}

				$useSass = $mode == 'sass';

				if ($useSass) {
					$activeModules = \Config::getInstance()->getActiveModules();
					if (!in_array('assetic', $activeModules)) {
						throw new \RuntimeException('Cannot use YAML SASS without assetic extension');
					}

					$filters = array(AsseticFactory::createFilterOrChain($filter));
				}
				else {
					$filters = array();
				}

				// add yaml addons
				$addons = deserialize($objLayout->xyaml_addons, true);
				$this->addFiles($addons, $GLOBALS['YAML_ADDONS'], $path, $useSass, $filters);

				// add yaml forms
				$forms = deserialize($objLayout->xyaml_forms, true);
				$this->addFiles($forms, $GLOBALS['YAML_FORMS'], $path, $useSass, $filters);

				// add yaml navigation
				$navigations = deserialize($objLayout->xyaml_navigation, true);
				$this->addFiles($navigations, $GLOBALS['YAML_NAVIGATION'], $path, $useSass, $filters);

				// add yaml print
				$prints = deserialize($objLayout->xyaml_print, true);
				$this->addFiles($prints, $GLOBALS['YAML_PRINT'], $path, $useSass, $filters);

				// add yaml screen
				$screens = deserialize($objLayout->xyaml_screen, true);
				$this->addFiles($screens, $GLOBALS['YAML_SCREEN'], $path, $useSass, $filters);

				// add yaml base
				$this->addStyleSheets(array('core/base.css'), $path, $useSass, $filters);

				// add yaml iehacks
				if ($objLayout->xyaml_iehacks) {
					$ieHacks = $path . '/core/iehacks.min.css';

					if ($useSass) {
						$targetPath = 'assets/css/iehacks-' . substr(md5($path), 0, 8) . '.css';

						if (!file_exists(TL_ROOT . '/' . $targetPath)) {
							// load asset
							$asset = new FileAsset(
								TL_ROOT . '/' . $path . '/core/_iehacks.scss',
								$filters,
								TL_ROOT,
								$path . '/core/_iehacks.scss'
							);
							$asset->setTargetPath(TL_ROOT . '/' . $targetPath);
							$asset->dump();
						}

						$ieHacks = $targetPath;
					}

					$GLOBALS['TL_HEAD']['xyaml_iehacks'] = <<<EOF
<!--[if lte IE 7]>
<link rel="stylesheet" href="{$ieHacks}" type="text/css"/>
<![endif]-->
EOF;
				}

				// linearize level
				if ($objLayout->xyaml_subcolumns_linearize) {
					$cssClass = ' linearize-level-' . $objLayout->xyaml_subcolumns_linearize;
					$GLOBALS['TL_SUBCL']['yaml4']['scclass']            .= $cssClass;
					$GLOBALS['TL_SUBCL']['yaml4_additional']['scclass'] .= $cssClass;
				}
			}
		}

		return false;
	}

	protected function addFiles($selectedKey, array $fileSets, $path, $useSass, array $filters)
	{
		foreach ($selectedKey as $key) {
			if (isset($fileSets[$key])) {
				$config = $fileSets[$key];
				if (isset($config['css'])) {
					$this->addStyleSheets($config['css'], $path, $useSass, $filters);
				}
				if (isset($config['js'])) {
					$this->addJavaScripts($config['js'], $path);
				}
			}
		}
	}

	protected function addStyleSheets(array $files, $path, $useSass, array $filters)
	{
		foreach ($files as $file) {
			if ($useSass) {
				$file = $this->transformCssToSass($file);
			}

			$file = $path . '/' . $file;
			$asset = new FileAsset(
				TL_ROOT . '/' . $file,
				$filters,
				TL_ROOT,
				$file
			);
			array_unshift($GLOBALS['TL_CSS'], $asset);
		}

	}

	protected function addJavaScripts(array $files, $path)
	{
		foreach ($files as $file) {
			array_unshift($GLOBALS['TL_JAVASCRIPT'], $path . '/' . $file);
		}
	}

	protected function transformCssToSass($css)
	{
		$pathinfo = pathinfo($css);
		return $pathinfo['dirname'] . '/_' . $pathinfo['filename'] . '.scss';
	}
}

