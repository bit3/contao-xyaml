<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2009-2010 Leo Feyer
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
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins 
 * @package    xYAML 
 * @license    LGPL 
 * @filesource
 */


#$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('xYAML', 'outputFrontendTemplate');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('NewsletterYAMLInsertTags', 'replaceInsertTags');
$GLOBALS['TL_PTY']['regular'] = 'PageRegularYAML';
$GLOBALS['xYAML'] = array_merge(
	array(
		'absolute_yaml_path' => '/usr/lib/www/yaml',
		'yaml_path' => '/_yaml',
		'css' => array('css/basemod.css', 'css/content.css', 'css/print.css'),
		'ie6css' => array('css/ie6patches.css'),
		'ie7css' => array('css/ie7patches.css'),
		'ie8css' => array('css/ie8patches.css'),
		'newsletter' => array('css/content.css', 'css/newsletter.css'),
		'wrapper_css_selector' => array('#page_margins'),
		'header_css_selector' => array('#header'),
		'left_css_selector' => array('#col1'),
		'right_css_selector' => array('#col2'),
		'main_css_selector' => array('#col3'),
		'footer_css_selector' => array('#footer')
	),
	is_array($GLOBALS['xYAML']) ? $GLOBALS['xYAML'] : array());
$GLOBALS['BE_MOD']['content']['newsletter']['send'][0] = 'NewsletterYAML';

?>