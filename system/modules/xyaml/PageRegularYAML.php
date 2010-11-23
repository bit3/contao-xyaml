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
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xYAML 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class PageRegularYAML
 *
 * Provide methods to handle a regular front end page.
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xYAML 
 */
class PageRegularYAML extends PageRegular
{
	/**
	 * Create a new template
	 * @param object
	 * @param object
	 */
	protected function createTemplate(Database_Result $objPage, Database_Result $objLayout)
	{
		// HOOK: modify the page or layout object
		if (isset($GLOBALS['TL_HOOKS']['createTemplate']) && is_array($GLOBALS['TL_HOOKS']['createTemplate']))
		{
			foreach ($GLOBALS['TL_HOOKS']['createTemplate'] as $callback)
			{
				$this->import($callback[0]);
				$this->$callback[0]->$callback[1]($objPage, $objLayout, $this);
			}
		}
		
		parent::createTemplate($objPage, $objLayout);
		$this->Template->framework = '';
		
		// Initialize margin
		$arrMargin = array
		(
			'left'   => '0 auto 0 0',
			'center' => '0 auto',
			'right'  => '0 0 0 auto'
		);

		$templateFramework = new FrontendTemplate('xyaml_framework');
		
		$arrSizeLeft = false;
		$arrSizeRight = false;
		
		// Wrapper
		$templateFramework->wrapperSelector = xYAML::getSelector('wrapper_css_selector');
		if ($objLayout->static)
		{
			$arrSize = deserialize($objLayout->width);
			$templateFramework->wrapperWidth = $arrSize['value'] . $arrSize['unit'];
			$templateFramework->wrapperMargins = $arrMargin[$objLayout->align];
		}

		// Header
		$templateFramework->headerSelector = xYAML::getSelector('header_css_selector');
		if ($objLayout->header)
		{
			$arrSize = deserialize($objLayout->headerHeight);

			if ($arrSize['value'] > 0)
			{
				$templateFramework->headerHeight = $arrSize['value'] . $arrSize['unit'];
			}
		}

		// Left column
		$templateFramework->leftSelector = xYAML::getSelector('left_css_selector');
		$templateFramework->mainMarginLeft = 0;
		if ($objLayout->cols == '2cll' || $objLayout->cols == '3cl')
		{
			$arrSizeLeft = deserialize($objLayout->widthLeft);

			if ($arrSizeLeft['value'] > 0)
			{
				$templateFramework->mainMarginLeft = $arrSizeLeft['value'] . $arrSizeLeft['unit'];
			}
		}

		// Right column
		$templateFramework->rightSelector = xYAML::getSelector('right_css_selector');
		$templateFramework->mainMarginRight = 0;
		if ($objLayout->cols == '2clr' || $objLayout->cols == '3cl')
		{
			$arrSizeRight = deserialize($objLayout->widthRight);

			if ($arrSizeRight['value'] > 0)
			{
				$templateFramework->mainMarginRight = $arrSizeRight['value'] . $arrSizeRight['unit'];
			}
		}
		
		// Both column
		if ($arrSizeLeft && $arrSizeRight && $arrSizeLeft['unit'] == $arrSizeRight['unit'])
		{
			$templateFramework->mainMarginBoth = ($arrSizeLeft['value'] + $arrSizeRight['value']) + $arrSizeRight['unit'];
		}

		// Main column
		$templateFramework->mainSelector = xYAML::getSelector('main_css_selector');
		
		// Footer
		$templateFramework->footerSelector = xYAML::getSelector('footer_css_selector');
		if ($objLayout->footer)
		{
			$arrSize = deserialize($objLayout->footerHeight);

			if ($arrSize['value'] > 0)
			{
				$templateFramework->footerHeight = $arrSize['value'] . $arrSize['unit'];
			}
		}
		
		// Include basic style sheets
		$this->Template->framework .= xYAML::buildCSSLinks($GLOBALS['xYAML']['yaml_css']);
		
		// Include additional style sheets
		$this->Template->framework .= xYAML::buildCSSLinks($GLOBALS['xYAML']['style_css']);
			
		// Add layout specific CSS
		$this->Template->framework .= $templateFramework->parse()."\n";
	}
}

?>