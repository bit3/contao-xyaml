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

$GLOBALS['xYAML']['absolute_yaml_path'] = '/usr/lib/www/yaml';
$GLOBALS['xYAML']['yaml_css'] = array(
	array('src' => '/_yaml/core/base.css'),
	array('src' => '/_yaml/core/iehacks.css', 'condition' => 'lte IE 7')
);
$GLOBALS['xYAML']['style_css'] = array(
	array('src' => 'css/basemod.css'),
	array('src' => 'css/content.css'),
	array('src' => 'css/print.css', 'media' => 'print'),
	array('src' => 'css/ie6patches.css', 'condition' => 'IE 6'),
	array('src' => 'css/ie7patches.css', 'condition' => 'IE 7'),
	array('src' => 'css/ie8patches.css', 'condition' => 'IE 8')
);
$GLOBALS['xYAML']['newsletter_css'] = array(
	array('src' => 'css/content.css'),
	array('src' => 'css/newsletter.css')
);
$GLOBALS['xYAML']['wrapper_css_selector'] = array('#page_margins');
$GLOBALS['xYAML']['header_css_selector'] = array('#header');
$GLOBALS['xYAML']['left_css_selector'] = array('#col1');
$GLOBALS['xYAML']['right_css_selector'] = array('#col2');
$GLOBALS['xYAML']['main_css_selector'] = array('#col3');
$GLOBALS['xYAML']['footer_css_selector'] = array('#footer');

$GLOBALS['BE_MOD']['content']['newsletter']['send'][0] = 'NewsletterYAML';

?>