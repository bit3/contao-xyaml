<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins 
 * @package    xYAML 
 * @license    LGPL 
 * @filesource
 */


class xYAML {
	public function replaceMainCSS($matches) {
		$left = '0';
		$right = '0';
		$margins = explode(';', $matches[1]);
		foreach ($margins as $margin) {
			$margin = explode(':', $margin, 2);
			if (count($margin) == 2)  {
				switch (trim($margin[0])) {
				case 'margin-left':  $left  = trim($margin[1]); break;
				case 'margin-right': $right = trim($margin[1]); break;
				}
			}
		}
		return sprintf('#main { margin-left: %s; margin-right: %s; }', $left, $right);
	}
	
	public function buildCSS($class, $style = '') {
		switch ($class) {
			case 'main':
				$left = '0';
				$right = '0';
				$margins = explode(';', $style);
				foreach ($margins as $margin) {
					$margin = explode(':', $margin, 2);
					if (count($margin) == 2)  {
						switch (trim($margin[0])) {
						case 'margin-left':  $left  = trim($margin[1]); break;
						case 'margin-right': $right = trim($margin[1]); break;
						}
					}
				}
				$style = sprintf('margin-left:%s; margin-right:%s;', $left, $right);
				break;
		}
				
		if (isset($GLOBALS['xYAML'][$class.'_css_id'])) {
			$class = $GLOBALS['xYAML'][$class.'_css_id'];
			if (is_array($class))
				$class = implode(', ', $class);
		} else {
			$class = '#'.$class;
		}
		return sprintf("%s { %s }\n", $class, $style);
	}
	
	public function replaceCSS($matches) {
		$css = $this->generateCssList();
		$css .= '<style type="text/css" media="screen">
<!--/*--><![CDATA[/*><!--*/
';
		preg_match_all('/#(.*) \\{(.*)\\}/U', $matches[1], $cssMatches, PREG_SET_ORDER);
		$classes = array();
		foreach ($cssMatches as $cssMatch) {
			$class = trim($cssMatch[1]);
			$style = trim($cssMatch[2]);
			$classes[] = $class;
			$css .= $this->buildCSS($class, $style);
		}
		if (!in_array('main', $classes)) {
			$css .= $this->buildCSS('main');
		}
		$css .= '/*]]>*/-->
</style>
';
		return $css;
	}
	
	public function replaceInvisibleClass($matches) {
		return $matches[1] . str_replace('invisible', 'hideme', $matches[2]) . $matches[3];
	}
	
	public function generateCssList() {
		$html = sprintf('<link rel="stylesheet" href="%s/core/base.css" type="text/css" />',
			$GLOBALS['xYAML']['yaml_path'])."\n";
		foreach ($GLOBALS['xYAML']['css'] as $css) {
			$html .= sprintf('<link rel="stylesheet" href="%s" type="text/css" />', $css)."\n";
		}
		$html .= sprintf('<!--[if lte IE 7]><link rel="stylesheet" href="%s/core/iehacks.css" type="text/css" /><![endif]-->',
			$GLOBALS['xYAML']['yaml_path'])."\n";
		for ($i=6; $i<=8; $i++) {
			foreach ($GLOBALS['xYAML']['ie'.$i.'css'] as $css) {
				$html .= sprintf('<!--[if IE %d]><link rel="stylesheet" href="%s" type="text/css" /><![endif]-->', $i, $css)."\n";
			}
		}
		return $html;
	}
	
	public function outputFrontendTemplate($strContent, $strTemplate) {
		if ($strTemplate == 'fe_page') {
			$strContent = preg_replace_callback('#<style type="text/css" media="screen">(.*\\#wrapper.*)</style>#sU',
				array(&$this, 'replaceCSS'),
				$strContent);
			$strContent = str_replace(
				array(
					'<link rel="stylesheet" href="system/typolight.css" type="text/css" media="screen" />',
					'<!--[if lte IE 7]><link rel="stylesheet" href="system/iefixes.css" type="text/css" media="screen" /><![endif]-->'),
				array(
					'',
					''),
				$strContent);
			$strContent = preg_replace_callback(
				'|(class=["\'])(.*?invisible.*?)(["\'])|', 
				array(&$this, 'replaceInvisibleClass'),
				$strContent);
		}
		return $strContent;
	}
}
?>