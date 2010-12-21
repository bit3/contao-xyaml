<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xYAML
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Class xYAML
 *
 * Post-Process the page output to make final modifications.
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xYAML 
 */
class xYAML {
	public static function getSelector($name) {
		if (is_array($GLOBALS['xYAML'][$name])) {
			return implode(', ', $GLOBALS['xYAML'][$name]);
		} else {
			return $GLOBALS['xYAML'][$name];
		}
	}
	
	public function replaceInvisibleClass($matches) {
		return $matches[1] . str_replace('invisible', 'hideme', $matches[2]) . $matches[3];
	}
	
	public function outputFrontendTemplate($strContent, $strTemplate) {
		if ($strTemplate == 'fe_page') {
			/*
			$strContent = preg_replace_callback(
				'|(class=["\'])(.*?invisible.*?)(["\'])|', 
				array(&$this, 'replaceInvisibleClass'),
				$strContent);
			*/
		}
		return $strContent;
	}
}
?>