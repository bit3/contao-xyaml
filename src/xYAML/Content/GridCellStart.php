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

namespace xYAML\Content;

/**
 * Class xYAML
 */
class GridCellStart extends \ContentElement
{
	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_xyaml_grid_cell_start';

	/**
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### GRID CELL START ###';

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		$this->Template->grid  = $this->xyaml_grid;
		$this->Template->float = $this->xyaml_float;
	}
}
