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

namespace Bit3\Contao\XYAML\Runonce;

/**
 * Class UpdateDatabase
 */
class UpdateDatabase
{
	static public function run()
	{
		$database = \Database::getInstance();

		$elementResultSet = $database->query(
			'SELECT *
			 FROM tl_content
			 WHERE type="xyaml_grid_row_start"
			 OR type="xyaml_grid_row_end"
			 OR type="xyaml_grid_cell_start"
			 OR type="xyaml_grid_cell_end"
			 ORDER BY pid, sorting'
		);

		$elements = array();
		$rows = array();
		$currentRow = false;
		while ($elementResultSet->next()) {
			$elements[$elementResultSet->id] = (object) $elementResultSet->row();

			switch ($elementResultSet->type) {
				case 'xyaml_grid_row_start':
					$currentRow = (int) $elementResultSet->id;
					$rows[$elementResultSet->pid][$currentRow] = array(
						'cells' => array(),
						'end'   => false
					);
					break;

				case 'xyaml_grid_row_end':
					if ($currentRow) {
						$rows[$elementResultSet->pid][$currentRow]['end'] = (int) $elementResultSet->id;
						$currentRow = false;
					}
					break;

				case 'xyaml_grid_cell_start':
					if ($currentRow) {
						$last = count($rows[$elementResultSet->pid][$currentRow]['cells'])-1;
						if (
							isset($rows[$elementResultSet->pid][$currentRow]['cells'][$last]) &&
							!$rows[$elementResultSet->pid][$currentRow]['cells'][$last][0]
						) {
							$rows[$elementResultSet->pid][$currentRow]['cells'][$last][0] = (int) $elementResultSet->id;
						}
						else {
							$rows[$elementResultSet->pid][$currentRow]['cells'][] = array((int) $elementResultSet->id, false);
						}
					}
					break;

				case 'xyaml_grid_cell_end':
					if ($currentRow) {
						$last = count($rows[$elementResultSet->pid][$currentRow]['cells'])-1;
						if ($rows[$elementResultSet->pid][$currentRow]['cells'][$last][1]) {
							$rows[$elementResultSet->pid][$currentRow]['cells'][] = array(false, (int) $elementResultSet->id);
						}
						else {
							$rows[$elementResultSet->pid][$currentRow]['cells'][$last][1] = (int) $elementResultSet->id;
						}
					}
					break;

				default:
					throw new \RuntimeException('Invalid database result');
			}
		}

		foreach ($rows as $articleRows) {
			foreach ($articleRows as $firstElementId => $row) {
				$withs = array();
				$cells = array();

				foreach ($row['cells'] as $cell) {
					if ($cell[0]) {
						$withs[] = $elements[$cell[0]]->xyaml_grid;
						$cells[] = $cell;
					}
				}
				$withs = array_filter($withs);
				$size  = count($withs);

				$set = false;
				$existingSets = array_keys($GLOBALS['TL_SUBCL']['yaml4']['sets']);

				while (count($withs)) {
					$searchedSet = implode('x' , $withs);

					$regexp = '~^' . preg_quote($searchedSet, '~') . str_repeat('x\d+', $size - count($withs)) . '$~';

					foreach ($existingSets as $existingSet) {
						if (
							$existingSet == $searchedSet ||
							preg_match($regexp, $existingSet)
						) {
							$set = $existingSet;
							break 2;
						}
					}

					array_pop($withs);
				}

				if ($set) {
					$name = 'colset.' . $firstElementId;
					$replaceElementIds = array($firstElementId);
					foreach ($cells as $cell) {
						$replaceElementIds[] = $cell[1];
					}

					$sortId = 0;
					$startElementId = array_shift($replaceElementIds);

					$database
						->prepare(
							'UPDATE tl_content
							 SET type=?, sc_name=?, sc_gap=?, sc_type=?, sc_parent=?, sc_childs=?, sc_sortid=?
							 WHERE id=?'
						)
						->execute(
							'colsetStart',
							$name,
							'',
							$set,
							$startElementId,
							implode($replaceElementIds),
							$sortId,
							$startElementId
						);

					$endElementId = $replaceElementIds[count($replaceElementIds)-1];
					foreach ($replaceElementIds as $partElementId) {
						$database
							->prepare(
								'UPDATE tl_content
								 SET type=?, sc_name=?, sc_gap=?, sc_type=?, sc_parent=?, sc_sortid=?
								 WHERE id=?'
							)
							->execute(
								$partElementId == $endElementId ? 'colsetEnd' : 'colsetPart',
								$name,
								'',
								$set,
								$startElementId,
								$sortId,
								$partElementId
							);
					}
				}
			}
		}

		$database->query(
			'DELETE FROM tl_content
			 WHERE type="xyaml_grid_row_start"
			 OR type="xyaml_grid_row_end"
			 OR type="xyaml_grid_cell_start"
			 OR type="xyaml_grid_cell_end"'
		);
	}
}

UpdateDatabase::run();
