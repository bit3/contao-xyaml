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
class Content extends \Frontend
{
	/**
	 * @var Content
	 */
	protected static $instance;

	/**
	 * @return Content
	 */
	static public function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Content();
		}
		return self::$instance;
	}

	protected $originalChildRecordCallback = null;

	protected $columnOffset = array('left' => 0, 'right' => 0);

	protected $columnOffsetStack = array();

	public function prepareDca()
	{
		foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette => $fields) {
			if ($palette != '__selector__' &&
				$palette != 'default' &&
				$palette != 'xyaml_grid_row_start' &&
				$palette != 'xyaml_grid_row_end' &&
				$palette != 'xyaml_grid_cell_start' &&
				$palette != 'xyaml_grid_cell_end'
			) {
				\MetaPalettes::appendBefore('tl_content', $palette, 'expert', array('layout' => array('xyaml_grid')));
			}
		}

		if ($this->originalChildRecordCallback === null) {
			$this->originalChildRecordCallback = $GLOBALS['TL_DCA']['tl_content']['list']['sorting']['child_record_callback'];
			$this->import($this->originalChildRecordCallback[0], 'originalChildRecordCallbackClass');
			$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['child_record_callback'] = array('xYAML\DataContainer\Content', 'addColumnInformation');
		}
	}

	/**
	 * Add the type of content element
	 * @param array
	 * @return string
	 */
	public function addColumnInformation($arrRow)
	{
		$GLOBALS['TL_CSS']['xyaml_backend'] = 'system/modules/xYAML/assets/css/backend.css';

		$callback = $this->originalChildRecordCallback;
		$buffer = $this->originalChildRecordCallbackClass->$callback[1]($arrRow);

		if ($arrRow['type'] == 'xyaml_grid_row_start') {
			$this->columnOffsetStack[] = $this->columnOffset;
			$this->columnOffset = array('left' => 0, 'right' => 0);
		}
		else if ($arrRow['type'] == 'xyaml_grid_row_end') {
			$this->columnOffset = array_pop($this->columnOffsetStack);
		}
		else if ($arrRow['xyaml_grid']) {
			$float = $arrRow['xyaml_grid_float'];

			switch ($arrRow['xyaml_grid']) {
				case '33':
					$width = 33.3333;
					break;
				case '38':
					$width = 38.2;
					break;
				case '62':
					$width = 61.8;
					break;
				case '66':
					$width = 66.6666;
					break;
				default:
					$width = $arrRow['xyaml_grid'];
			}

			if ($this->columnOffset['left'] + $this->columnOffset['right'] + $width > 100) {
				$this->columnOffset[$float] = 0;
			}

			$grid = '<div class="grid-indicator">';
			$grid .= sprintf(
				'<div class="item" style="float:%s;margin-%s:%d%%;width:%d%%">%s %%</div>',
				$float,
				$float,
				$this->columnOffset[$float],
				$width,
				$this->getFormattedNumber($width, 0)
			);
			$grid .= '</div>';

			$buffer = preg_replace(
				'#<div class="limit_height( h64)">#',
				'$0' . $grid,
				$buffer
			);

			$this->columnOffset[$float] += $width;
		}

		return $buffer;
	}
}
