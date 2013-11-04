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

use ContaoAssetic\Model\FilterModel;

/**
 * Class Settings
 */
class Settings
{
	public function getCompassFilterOptions($dc)
	{
		$options = array();

		$filter = FilterModel::findBy('type', 'compass', array('order' => 'type'));

		if ($filter) {
			while ($filter->next()) {
				$label = $GLOBALS['TL_LANG']['assetic'][$filter->type]
					? : $filter->type;

				if ($filter->note) {
					$label .= ' [' . $filter->note . ']';
				}

				$GLOBALS['TL_LANG']['assetic']['filter:' . $filter->id] = $label;

				$options[] = 'filter:' . $filter->id;
			}
		}

		return $options;
	}

	public function getPathSources()
	{
		$options = array();

		if (version_compare(VERSION, '3', '>=')) {
			$options[] = 'assets';
		}
		else {
			$options[] = 'plugins';
		}

		if (is_dir(TL_ROOT . '/composer/components')) {
			$options[] = 'composer/components';
		}

		$options[] = $GLOBALS['TL_CONFIG']['uploadPath'];

		return $options;
	}
}